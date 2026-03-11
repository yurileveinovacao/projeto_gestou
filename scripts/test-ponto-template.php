<?php
/**
 * Script de teste local para templates de ponto OCR
 *
 * Uso:
 *   php scripts/test-ponto-template.php <pdf_ou_json> <template> <cnpj>
 *
 * Templates: tangerino_v7, pontosecullum_v7, pontosecullum_p_v7, saturno_v1, ponto_1_v7
 *
 * Exemplos:
 *   php scripts/test-ponto-template.php /tmp/ponto.pdf pontosecullum_v7 09359577000160
 *   php scripts/test-ponto-template.php /tmp/ponto-ocr.json saturno_v1 20428224000188
 *
 * Requer: GOOGLE_VISION_API_KEY (env var) quando entrada é PDF
 */

// --- Helpers ---
function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

function limpa_zero($texto)
{
    if (substr($texto, 0, 1) === '0') {
        return substr($texto, 1);
    }
    return $texto;
}

function normalize_text($var_text)
{
    return str_replace("R.G.:", "R.G.:", str_replace("Ó", "O", str_replace("ó", "o",
        str_replace("Ç", "C", str_replace("Õ", "O", str_replace("(", "",
        str_replace("ç", "c", str_replace("õ", "o", str_replace("í", "i",
        str_replace("á", "a", str_replace("Á", "A", str_replace("Í", "I",
        str_replace("ê", "e", str_replace("Ê", "E", $var_text))))))))))))));
}

// --- CLI args ---
if ($argc < 4) {
    fwrite(STDERR, "Uso: php scripts/test-ponto-template.php <pdf_ou_json> <template> <cnpj>\n");
    fwrite(STDERR, "Templates: tangerino_v7, pontosecullum_v7, pontosecullum_p_v7, saturno_v1, ponto_1_v7\n");
    exit(1);
}

$input_file = $argv[1];
$template = $argv[2];
$cnpj_completo = limpar_texto($argv[3]);

$valid_templates = array(
    'tangerino_v7', 'pontosecullum_v7', 'pontosecullum_p_v7', 'saturno_v1', 'ponto_1_v7'
);
if (!in_array($template, $valid_templates)) {
    fwrite(STDERR, "Template invalido: $template\n");
    fwrite(STDERR, "Validos: " . implode(', ', $valid_templates) . "\n");
    exit(1);
}

if (!file_exists($input_file)) {
    fwrite(STDERR, "Arquivo nao encontrado: $input_file\n");
    exit(1);
}

// --- OCR ou JSON ---
$ext = strtolower(pathinfo($input_file, PATHINFO_EXTENSION));

if ($ext === 'json') {
    echo "Carregando JSON: $input_file\n";
    $json_str = file_get_contents($input_file);
} else {
    // PDF — chamar Google Vision OCR
    $api_key = getenv('GOOGLE_VISION_API_KEY');
    if (empty($api_key)) {
        fwrite(STDERR, "GOOGLE_VISION_API_KEY nao definida. Defina com: export GOOGLE_VISION_API_KEY=...\n");
        exit(1);
    }

    require_once __DIR__ . '/../config/ocr.php';

    echo "Enviando PDF para Google Vision OCR...\n";
    $json_str = googleVisionOCR($input_file);

    // Salvar JSON para reutilização
    $json_file = '/tmp/' . pathinfo($input_file, PATHINFO_FILENAME) . '-ocr.json';
    file_put_contents($json_file, $json_str);
    echo "JSON salvo em: $json_file\n";
}

$json_base = json_decode($json_str);

if (!$json_base || !isset($json_base->analyzeResult->readResults)) {
    fwrite(STDERR, "JSON invalido ou sem resultados OCR.\n");
    exit(1);
}

// --- Exibir texto OCR ---
echo "\n=== TESTE: $template ===\n";
echo "Arquivo: $input_file\n";
echo "CNPJ esperado: $cnpj_completo\n";
echo "\n--- TEXTO OCR (por pagina) ---\n";

foreach ($json_base->analyzeResult->readResults as $page) {
    echo "\n[Pagina " . $page->page . "]\n";
    foreach ($page->lines as $line) {
        echo "  " . $line->text . "\n";
    }
}

// --- Parsing ---
echo "\n--- PARSING ($template) ---\n";

$raiz_cnpj = substr($cnpj_completo, 0, 8);

// Chamar função de parsing conforme template
switch ($template) {
    case 'tangerino_v7':
        $result = parse_tangerino_v7($json_base, $cnpj_completo);
        break;
    case 'pontosecullum_v7':
    case 'pontosecullum_p_v7':
        $result = parse_pontosecullum_v7($json_base, $cnpj_completo);
        break;
    case 'saturno_v1':
        $result = parse_saturno_v1($json_base, $cnpj_completo);
        break;
    case 'ponto_1_v7':
        $result = parse_ponto_1_v7($json_base, $cnpj_completo);
        break;
}

// --- Exibir resultados ---
echo "\n--- RESULTADOS ---\n";

if ($result['cnpj_encontrado']) {
    echo "OK CNPJ detectado: " . $result['cnpj_encontrado'] . "\n";
} else {
    echo "FALHA CNPJ nao detectado (esperado: $cnpj_completo)\n";
}

if (!empty($result['periodo'])) {
    echo "OK Periodo: " . $result['periodo'] . "\n";
} else {
    echo "FALHA Periodo nao detectado\n";
}

if (!empty($result['dois_cpfs'])) {
    echo "AVISO 2+ CPFs na mesma pagina detectados (arquivo pode ter problemas)\n";
}

$ids = $result['identificadores'];
$count = count($ids);
$tipo_label = $result['tipo_busca'] === 'cpf' ? 'CPF' : 'PIS';

if ($count > 0) {
    echo "OK $tipo_label encontrados: $count\n";
    foreach ($ids as $idx => $id) {
        $num = $idx + 1;
        echo "  [$num] $tipo_label " . $id['valor'] . " (pag " . $id['pag_ini'] . "-" . $id['pag_fim'] . ")\n";
    }
} else {
    echo "FALHA Nenhum $tipo_label encontrado\n";
}

echo "\nTipo pagina: " . $result['tipo_pagina'] . "\n";
echo "Total registros: " . $result['total'] . "\n";

// ==========================================
// Funções de parsing por template
// ==========================================

/**
 * tangerino_v7: coleta 2 datas para período, CPF sem label (11 dígitos)
 */
function parse_tangerino_v7($json_base, $cnpj_completo)
{
    $contagem_cpf = 0;
    $contagem_cpf_pagina = 0;
    $count_data = 0;
    $cnpj_consulta = '';
    $cpf_consulta = '';
    $retorno_cnpj = 0;
    $concat_cpf = '';
    $concat_pagina_ini = '';
    $concat_pagina_fim = '';
    $periodo = '';
    $dois_cpfs = 0;
    $pagina_espelhada = 0;
    $date1 = null;
    $date2 = null;
    $cnpj_encontrado = '';

    foreach ($json_base->analyzeResult->readResults as $key) {
        $page_number = $key->page;
        $contagem_cpf_pagina = 0;

        foreach ($key->lines as $key2) {
            $var_text = normalize_text($key2->text);

            // Período completo na mesma linha (ex: "01/10/2022 a 31/10/2022")
            if (empty($periodo)) {
                if (preg_match('/(\d{2}\/?\d{2}\/?\d{4})\s*a\s*(\d{2}\/?\d{2}\/?\d{4})/i', $var_text, $matches_periodo)) {
                    $periodo = $matches_periodo[1] . " a " . $matches_periodo[2];
                }
            }

            // Fallback: coleta 2 primeiras datas avulsas
            if (empty($periodo)) {
                $pattern = '/[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}/';
                if (preg_match($pattern, $var_text, $matches)) {
                    $date = $matches[0];
                    if ($count_data == 0) {
                        $date1 = $date;
                    }
                    if ($count_data == 1) {
                        $date2 = $date;
                    }
                    $count_data++;
                }
                if (isset($date1) && isset($date2)) {
                    $periodo = $date1 . " a " . $date2;
                }
            }

            // CNPJ
            if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
                $cnpj = limpar_texto($var_text);
                if ($cnpj == $cnpj_completo) {
                    $cnpj_consulta = $cnpj;
                    $cnpj_encontrado = $cnpj;
                }
            }

            if ($cnpj_consulta == $cnpj_completo && !empty($cnpj_consulta)) {
                $retorno_cnpj = 1;

                // CPF: 11 dígitos sem label
                if (preg_match('/\b[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}\b/i', $var_text)) {
                    $regex = '/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i';
                    preg_match($regex, $var_text, $resposta);
                    $cpf = limpar_texto($resposta[0]);

                    if ($cpf != $cpf_consulta) {
                        $cpf_consulta = $cpf;
                        $contagem_cpf++;
                        $contagem_cpf_pagina++;
                        $pagina_ini = $page_number;
                        $concat_cpf .= "||" . $cpf_consulta;
                        $concat_pagina_ini .= "||" . $pagina_ini;
                        $pagina_fim = $page_number;
                        if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                    } else {
                        $pagina_fim = $page_number;
                        $pagina_espelhada = 1;
                    }
                }
            }
        }

        if (!empty($pagina_fim)) {
            $concat_pagina_fim .= "||" . $pagina_fim;
        }
        unset($cnpj_consulta);
        $cnpj_consulta = '';
        unset($pagina_fim);
    }

    return build_result($contagem_cpf, $concat_cpf, $concat_pagina_ini, $concat_pagina_fim,
        $retorno_cnpj, $cnpj_encontrado, $periodo, $dois_cpfs, $pagina_espelhada, 'cpf');
}

/**
 * pontosecullum_v7 / pontosecullum_p_v7: DE/ATE + fallback datas, CPF/PIS com flags
 */
function parse_pontosecullum_v7($json_base, $cnpj_completo)
{
    $contagem_cpf = 0;
    $contagem_cpf_pagina = 0;
    $count_data = 0;
    $cnpj_consulta = '';
    $pis_consulta = '';
    $retorno_cnpj = 0;
    $concat_cpf = '';
    $concat_pagina_ini = '';
    $concat_pagina_fim = '';
    $periodo = '';
    $dois_cpfs = 0;
    $pagina_espelhada = 0;
    $date1 = null;
    $date2 = null;
    $cnpj_encontrado = '';
    $busca_por_cpf = 0;
    $encontra_cpf = 0;
    $encontra_pis = 0;

    foreach ($json_base->analyzeResult->readResults as $key) {
        $page_number = $key->page;
        $contagem_cpf_pagina = 0;

        foreach ($key->lines as $key2) {
            $var_text = normalize_text($key2->text);

            // Período: formato completo "DE ... ATE ..."
            // Usa AT\S+ em vez de AT[EÉ] para evitar problema de UTF-8 sem flag /u
            if (preg_match('/DE\s+(\d{2}\/?\d{2}\/?\d{4})\s+AT\S*\s+(\d{2}\/?\d{2}\/?\d{4})/i', $var_text, $matches_periodo)) {
                $periodo = "DE " . $matches_periodo[1] . " ATE " . $matches_periodo[2];
            }

            // Fallback: 2 datas separadas
            if (empty($periodo)) {
                $pattern_data = '/[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}/';
                if (preg_match($pattern_data, $var_text, $matches_data)) {
                    if ($count_data == 0) { $date1 = $matches_data[0]; }
                    if ($count_data == 1) { $date2 = $matches_data[0]; }
                    $count_data++;
                }
                if (isset($date1) && isset($date2)) {
                    $periodo = "DE " . $date1 . " ATE " . $date2;
                }
            }

            // CNPJ
            if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
                $cnpj = limpar_texto($var_text);
                if ($cnpj == $cnpj_completo) {
                    $cnpj_consulta = $cnpj;
                    $cnpj_encontrado = $cnpj;
                }
            }

            if ($cnpj_consulta == $cnpj_completo && !empty($cnpj_consulta)) {
                $retorno_cnpj = 1;

                // Flag CPF da iteração anterior
                if ($encontra_cpf == 1) {
                    if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text, $resposta)) {
                        $pis = limpar_texto($resposta[0]);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    }
                    $encontra_cpf = 0;
                }

                // Google Vision: flag PIS ativo — buscar número PIS nas próximas linhas (até 5)
                if ($encontra_pis >= 1) {
                    $regex2 = '/[0-9]{10}([0-9]|[1-9][0-9]|(1[0-9]{2})|(2[0-7][0-9])|(28[0-7]))\b/';
                    if (preg_match($regex2, $var_text, $resposta)) {
                        $pis = limpar_texto($resposta[0]);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                        $encontra_pis = 0;
                    } else {
                        $encontra_pis++;
                        if ($encontra_pis > 5) { $encontra_pis = 0; }
                    }
                }

                // Detecta "CPF" na linha
                if (preg_match('/CPF/i', $var_text)) {
                    $busca_por_cpf = 1;
                    if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/', $var_text, $resposta_inline)) {
                        $pis = limpar_texto($resposta_inline[0]);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    } else {
                        $encontra_cpf = 1;
                    }
                }

                // Detecta "PIS" na linha
                if (preg_match('/PIS/i', $var_text)) {
                    $regex_pis_inline = '/[0-9]{10}([0-9]|[1-9][0-9]|(1[0-9]{2})|(2[0-7][0-9])|(28[0-7]))\b/';
                    if (preg_match($regex_pis_inline, $var_text, $resposta_inline)) {
                        $pis = limpar_texto($resposta_inline[0]);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    } else {
                        $encontra_pis = 1;
                    }
                }
            }
        }

        if (!empty($pagina_fim)) {
            $concat_pagina_fim .= "||" . $pagina_fim;
        }
        $cnpj_consulta = '';
        unset($pagina_fim);
    }

    $tipo = $busca_por_cpf ? 'cpf' : 'pis';
    return build_result($contagem_cpf, $concat_cpf, $concat_pagina_ini, $concat_pagina_fim,
        $retorno_cnpj, $cnpj_encontrado, $periodo, $dois_cpfs, $pagina_espelhada, $tipo);
}

/**
 * saturno_v1: "Periodo dd/mm/yyyy a dd/mm/yyyy", CNPJ com/sem label, CPF com flag
 */
function parse_saturno_v1($json_base, $cnpj_completo)
{
    $contagem_cpf = 0;
    $contagem_cpf_pagina = 0;
    $count_data = 0;
    $cnpj_consulta = '';
    $cpf_consulta = '';
    $retorno_cnpj = 0;
    $concat_cpf = '';
    $concat_pagina_ini = '';
    $concat_pagina_fim = '';
    $periodo = '';
    $dois_cpfs = 0;
    $pagina_espelhada = 0;
    $date1 = null;
    $date2 = null;
    $cnpj_encontrado = '';
    $encontra_cpf_saturno = 0;

    foreach ($json_base->analyzeResult->readResults as $key) {
        $page_number = $key->page;
        $contagem_cpf_pagina = 0;

        foreach ($key->lines as $key2) {
            $var_text = normalize_text($key2->text);

            // Período: "Periodo dd/mm/yyyy a dd/mm/yyyy"
            if (empty($periodo)) {
                if (preg_match('/Periodo\s[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}\sa\s[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}/i', $var_text)) {
                    $periodo = str_replace('Periodo ', '', $var_text);
                }

                // Fallback: 2 datas separadas
                if (empty($periodo)) {
                    $pattern_data = '/[0-9]{2}\/?[0-9]{2}\/?[0-9]{4}/';
                    if (preg_match($pattern_data, $var_text, $matches_data)) {
                        if ($count_data == 0) { $date1 = $matches_data[0]; }
                        if ($count_data == 1) { $date2 = $matches_data[0]; }
                        $count_data++;
                    }
                    if (isset($date1) && isset($date2)) {
                        $periodo = $date1 . " a " . $date2;
                    }
                }
            }

            // CNPJ: com ou sem label "CNPJ"
            if (preg_match('/CNPJ\s*[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)
                || preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
                $cnpj = limpar_texto($var_text);
                if ($cnpj == $cnpj_completo) {
                    $cnpj_consulta = $cnpj;
                    $cnpj_encontrado = $cnpj;
                }
            }

            if ($cnpj_consulta == $cnpj_completo && !empty($cnpj_consulta)) {
                $retorno_cnpj = 1;

                // Flag CPF da iteração anterior
                if ($encontra_cpf_saturno == 1) {
                    if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text, $resposta)) {
                        $cpf = limpar_texto($resposta[0]);
                        if ($cpf != $cpf_consulta) {
                            $cpf_consulta = $cpf;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $cpf_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    }
                    $encontra_cpf_saturno = 0;
                }

                // Detecta "CPF" na linha
                if (preg_match('/CPF/i', $var_text)) {
                    if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text, $resposta)) {
                        $cpf = limpar_texto($resposta[0]);
                        if ($cpf != $cpf_consulta) {
                            $cpf_consulta = $cpf;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $cpf_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    } else {
                        $encontra_cpf_saturno = 1;
                    }
                }
            }
        }

        if (!empty($pagina_fim)) {
            $concat_pagina_fim .= "||" . $pagina_fim;
        }
        $cnpj_consulta = '';
        unset($pagina_fim);
    }

    return build_result($contagem_cpf, $concat_cpf, $concat_pagina_ini, $concat_pagina_fim,
        $retorno_cnpj, $cnpj_encontrado, $periodo, $dois_cpfs, $pagina_espelhada, 'cpf');
}

/**
 * ponto_1_v7: array de datas por página, PIS com limpa_zero + flag next-line
 */
function parse_ponto_1_v7($json_base, $cnpj_completo)
{
    $contagem_cpf = 0;
    $contagem_cpf_pagina = 0;
    $cnpj_consulta = '';
    $pis_consulta = '';
    $retorno_cnpj = 0;
    $concat_cpf = '';
    $concat_pagina_ini = '';
    $concat_pagina_fim = '';
    $periodo = '';
    $dois_cpfs = 0;
    $pagina_espelhada = 0;
    $cnpj_encontrado = '';
    $busca_por_cpf = 0;
    $busca_por_pis = 0;
    $encontra_pis_next = 0;
    $encontra_cpf = 0;

    foreach ($json_base->analyzeResult->readResults as $key) {
        $page_number = $key->page;
        $contagem_cpf_pagina = 0;
        $datas = array();

        foreach ($key->lines as $key2) {
            $var_text = normalize_text($key2->text);

            // CNPJ (antes da coleta de datas para evitar capturar data de emissão)
            if (preg_match('/[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}/i', $var_text)) {
                $cnpj = limpar_texto($var_text);
                if ($cnpj == $cnpj_completo) {
                    $cnpj_consulta = $cnpj;
                    $cnpj_encontrado = $cnpj;
                }
            }

            if ($cnpj_consulta == $cnpj_completo && !empty($cnpj_consulta)) {
                $retorno_cnpj = 1;

                // Datas: só coleta após CNPJ confirmado (evita data de emissão)
                // Aceita data sozinha ou com texto após (ex: "20/12/2022 TER")
                if (preg_match('/^(\d{2}\/\d{2}\/\d{4})/', $var_text, $matches)) {
                    $datas[] = $matches[1];
                }
                // Fallback Google Vision: data concatenada
                if (empty($datas) || count($datas) < 2) {
                    if (preg_match('/\b(\d{2}\/\d{2}\/\d{4})\b/', $var_text, $matches_gv)) {
                        if (empty($datas) || end($datas) !== $matches_gv[1]) {
                            $datas[] = $matches_gv[1];
                        }
                    }
                }

                // Flag CPF da iteração anterior
                if ($encontra_cpf == 1) {
                    if (preg_match('/[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}/i', $var_text, $resposta)) {
                        $pis = limpar_texto($resposta[0]);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    }
                    $encontra_cpf = 0;
                }

                // Flag PIS next-line da iteração anterior
                if ($encontra_pis_next == 1) {
                    $regex_pis = '/[0-9]{10}([0-9]|[1-9][0-9]|(1[0-9]{2})|(2[0-7][0-9])|(28[0-7]))\b/';
                    if (preg_match($regex_pis, $var_text, $resposta)) {
                        $pis = limpar_texto($resposta[0]);
                        $pis = limpa_zero($pis);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    }
                    $encontra_pis_next = 0;
                }

                // Detecta "PIS" na linha
                if (preg_match('/PIS/i', $var_text)) {
                    $busca_por_pis = 1;
                    $busca_por_cpf = 0;
                    $regex_pis = '/[0-9]{10}([0-9]|[1-9][0-9]|(1[0-9]{2})|(2[0-7][0-9])|(28[0-7]))\b/';
                    if (preg_match($regex_pis, $var_text, $resposta)) {
                        $pis = limpar_texto($resposta[0]);
                        $pis = limpa_zero($pis);
                        if ($pis != $pis_consulta) {
                            $pis_consulta = $pis;
                            $contagem_cpf++;
                            $contagem_cpf_pagina++;
                            $pagina_ini = $page_number;
                            $concat_cpf .= "||" . $pis_consulta;
                            $concat_pagina_ini .= "||" . $pagina_ini;
                            $pagina_fim = $page_number;
                            if ($contagem_cpf_pagina > 1) { $dois_cpfs = 1; }
                        } else {
                            $pagina_fim = $page_number;
                            $pagina_espelhada = 1;
                        }
                    } else {
                        $encontra_pis_next = 1;
                    }
                }
            }
        }

        // Período: primeira e última data da página
        if (count($datas) >= 2) {
            $periodo = "De " . $datas[0] . " ate " . $datas[count($datas) - 1];
        }

        if (!empty($pagina_fim)) {
            $concat_pagina_fim .= "||" . $pagina_fim;
        }
        $cnpj_consulta = '';
        unset($pagina_fim);
    }

    $tipo = $busca_por_cpf ? 'cpf' : 'pis';
    return build_result($contagem_cpf, $concat_cpf, $concat_pagina_ini, $concat_pagina_fim,
        $retorno_cnpj, $cnpj_encontrado, $periodo, $dois_cpfs, $pagina_espelhada, $tipo);
}

/**
 * Monta array de resultado padronizado a partir das variáveis concatenadas
 */
function build_result($contagem_cpf, $concat_cpf, $concat_pagina_ini, $concat_pagina_fim,
    $retorno_cnpj, $cnpj_encontrado, $periodo, $dois_cpfs, $pagina_espelhada, $tipo_busca)
{
    $identificadores = array();

    if ($retorno_cnpj && $contagem_cpf > 0) {
        $cpf_array = explode('||', $concat_cpf);
        $ini_array = explode('||', $concat_pagina_ini);
        $fim_array = explode('||', $concat_pagina_fim);

        for ($i = 1; $i <= $contagem_cpf; $i++) {
            $identificadores[] = array(
                'valor' => isset($cpf_array[$i]) ? trim($cpf_array[$i]) : '?',
                'pag_ini' => isset($ini_array[$i]) ? trim($ini_array[$i]) : '?',
                'pag_fim' => isset($fim_array[$i]) ? trim($fim_array[$i]) : '?',
            );
        }
    }

    return array(
        'cnpj_encontrado' => $cnpj_encontrado,
        'periodo' => $periodo,
        'tipo_busca' => $tipo_busca,
        'tipo_pagina' => $pagina_espelhada ? 'Pagina Espelhada' : 'Pagina Unica',
        'dois_cpfs' => $dois_cpfs,
        'total' => $contagem_cpf,
        'identificadores' => $identificadores,
    );
}
