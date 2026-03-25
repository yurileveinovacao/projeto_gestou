<?php
/**
 * OCR Configuration - Google Cloud Vision API
 * Replaces Azure Computer Vision with Google Cloud Vision
 * Converts Google response to Azure format for backward compatibility with layout templates
 */

/**
 * Performs OCR on a PDF file using Google Cloud Vision API (synchronous)
 *
 * Uses files:annotate endpoint which supports PDF natively.
 * Batches requests in groups of 5 pages (API limit per request).
 *
 * @param string $pdfFilePath Path to the PDF file
 * @return string JSON string in Azure Computer Vision format
 */
function googleVisionOCR($pdfFilePath)
{
    $apiKey = getenv('GOOGLE_VISION_API_KEY');

    if (empty($apiKey)) {
        return json_encode(array(
            'status' => 'failed',
            'analyzeResult' => array('readResults' => array())
        ));
    }

    if (!file_exists($pdfFilePath)) {
        return json_encode(array(
            'status' => 'failed',
            'analyzeResult' => array('readResults' => array())
        ));
    }

    $pdfContent = file_get_contents($pdfFilePath);
    $base64Content = base64_encode($pdfContent);

    // Google Vision files:annotate processes up to 5 pages per request
    // Batch requests for PDFs with more than 5 pages
    $allPageResponses = array();
    $maxPagesPerRequest = 5;
    $batch = 0;

    while (true) {
        $pages = array();
        for ($i = 1; $i <= $maxPagesPerRequest; $i++) {
            $pages[] = ($batch * $maxPagesPerRequest) + $i;
        }

        $requestBody = json_encode(array(
            'requests' => array(
                array(
                    'inputConfig' => array(
                        'content' => $base64Content,
                        'mimeType' => 'application/pdf'
                    ),
                    'features' => array(
                        array('type' => 'DOCUMENT_TEXT_DETECTION')
                    ),
                    'pages' => $pages
                )
            )
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vision.googleapis.com/v1/files:annotate?key=' . urlencode($apiKey),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200 || $response === false) {
            break;
        }

        $decoded = json_decode($response);

        if (!isset($decoded->responses[0]->responses) || !is_array($decoded->responses[0]->responses)) {
            break;
        }

        $pageResponses = $decoded->responses[0]->responses;

        foreach ($pageResponses as $pageResp) {
            $allPageResponses[] = $pageResp;
        }

        // If we got fewer pages than requested, we've reached the end
        if (count($pageResponses) < $maxPagesPerRequest) {
            break;
        }

        $batch++;

        // Safety limit: 100 pages max
        if ($batch >= 20) {
            break;
        }
    }

    return convertGoogleToAzureFormat($allPageResponses);
}

/**
 * Converts Google Cloud Vision response to Azure Computer Vision format
 *
 * Uses block bounding box coordinates to produce deterministic line ordering
 * (top-to-bottom, left-to-right) instead of relying on fullTextAnnotation.text
 * which returns lines in arbitrary/varying order.
 *
 * Templates in admin/layout/ expect the Azure format:
 *   $json->analyzeResult->readResults[n]->page
 *   $json->analyzeResult->readResults[n]->lines[m]->text
 *
 * @param array $googlePageResponses Array of Google Vision per-page response objects
 * @return string JSON string in Azure format
 */
function convertGoogleToAzureFormat($googlePageResponses)
{
    $readResults = array();

    foreach ($googlePageResponses as $index => $pageResponse) {
        $pageNumber = $index + 1;

        // Get page number from Google's context if available
        if (isset($pageResponse->context->pageNumber)) {
            $pageNumber = (int)$pageResponse->context->pageNumber;
        }

        $lines = array();

        if (isset($pageResponse->fullTextAnnotation->pages[0])) {
            // Extract blocks with their bounding box coordinates
            $page = $pageResponse->fullTextAnnotation->pages[0];
            $blocks = array();

            foreach ($page->blocks as $block) {
                $minY = 99;
                $minX = 99;
                $blockText = '';

                foreach ($block->paragraphs as $para) {
                    foreach ($para->words as $word) {
                        $wordText = '';
                        foreach ($word->symbols as $sym) {
                            $wordText .= $sym->text;
                        }
                        $blockText .= ($blockText !== '' ? ' ' : '') . $wordText;

                        $y = isset($word->boundingBox->normalizedVertices[0]->y) ? $word->boundingBox->normalizedVertices[0]->y : 0;
                        $x = isset($word->boundingBox->normalizedVertices[0]->x) ? $word->boundingBox->normalizedVertices[0]->x : 0;
                        if ($y < $minY) $minY = $y;
                        if ($x < $minX) $minX = $x;
                    }
                }

                if ($blockText !== '') {
                    // Clean up spacing around punctuation (Google Vision separates / - : . as individual words)
                    $blockText = preg_replace('/\s*\/\s*/', '/', $blockText);
                    $blockText = preg_replace('/\s*-\s*/', '-', $blockText);
                    $blockText = preg_replace('/\s+:/', ':', $blockText);
                    $blockText = preg_replace('/\s+\./', '.', $blockText);
                    $blocks[] = array('text' => $blockText, 'y' => $minY, 'x' => $minX);
                }
            }

            // Sort blocks by Y position (top to bottom), then X (left to right)
            // Tolerance of 0.006 (~5px on 841px page) groups blocks on the same visual line
            usort($blocks, function ($a, $b) {
                if (abs($a['y'] - $b['y']) < 0.006) {
                    return $a['x'] <=> $b['x'];
                }
                return $a['y'] <=> $b['y'];
            });

            // Convert blocks to Azure line format
            foreach ($blocks as $b) {
                $words = array();
                $wordTexts = preg_split('/\s+/', $b['text']);
                foreach ($wordTexts as $wordText) {
                    if ($wordText !== '') {
                        $words[] = (object)array('text' => $wordText);
                    }
                }

                $lines[] = (object)array(
                    'text' => $b['text'],
                    'words' => $words
                );
            }
        }

        $readResults[] = (object)array(
            'page' => $pageNumber,
            'lines' => $lines
        );
    }

    $result = (object)array(
        'status' => 'succeeded',
        'analyzeResult' => (object)array(
            'readResults' => $readResults
        )
    );

    return json_encode($result);
}
