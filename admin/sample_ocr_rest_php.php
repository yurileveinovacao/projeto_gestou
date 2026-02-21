<?php

        /*
        
           Sample project for OCRWebService.com (REST API).
           Extract text from scanned images and convert into editable formats.
           Please create new account with ocrwebservice.com via http://www.ocrwebservice.com/account/signup and get license code

        */

        // Provide your user name and license code
       // $license_code = '54122F4E-15A7-40BF-8B46-424B19197FA6';
       // $username =  'gestou';

        $license_code = 'DCE21445-5ADA-4D79-9F02-0352DF720F0A';
        $username =  'teste1';

        /*

           You should specify OCR settings. See full description http://www.ocrwebservice.com/service/restguide
         
           Input parameters:
         [idioma] - Especifica o idioma de reconhecimento.
Este parâmetro pode conter vários nomes de idiomas separados por vírgulas.
                            Por exemplo "idioma=inglês,alemão,espanhol".
Parâmetro opcional. Por padrão: inglês
        
[pagerange] - Insira os números de página e/ou intervalos de páginas separados por vírgulas.
Por exemplo, "pagerange=1,3,5-12" ou "pagerange=allpages".
                            Parâmetro opcional. Por padrão: todas as páginas
         
           [tobw] - Converte a imagem em preto e branco (recomendado para imagens e fotos coloridas).
Por exemplo "tobw=false"
                            Parâmetro opcional. Por padrão: falso
         
           [zona] - Especifica a região na imagem para OCR zonal.
As coordenadas em pixels relativas ao canto superior esquerdo no seguinte formato: topo:esquerda:altura:largura.
Este parâmetro pode conter várias zonas separadas por vírgulas.
Por exemplo "zona=0:0:100:100,50:50:50:50"
                            Parâmetro opcional.
          
           [outputformat] - Especifica o formato do arquivo de saída.
                            Podem ser especificados até dois formatos de saída, separados por vírgulas.
Por exemplo "outputformat=pdf,txt"
                            Parâmetro opcional. Por padrão: doc

           [gettext] - Especifica que o texto extraído será retornado.
Por exemplo "tobw=true"
                            Parâmetro opcional. Por padrão: falso
        
           [descrição] - Especifica a descrição da sua tarefa. Será devolvido em resposta.
                            Parâmetro opcional.


!!!! Para obter o resultado, você deve especificar "gettext" ou "outputformat" !!!!

	*/


        // Build your OCR:

        // Extraction text with English language
        //$url = 'http://www.ocrwebservice.com/restservices/processDocument?gettext=true';

        // Extraction text with English and german language using zonal OCR
        //$url = 'http://www.ocrwebservice.com/restservices/processDocument?language=english,brasileiro&zone=0:0:600:400,500:1000:150:400';
       

        // Convert first 5 pages of multipage document into doc and txt
        // $url = 'http://www.ocrwebservice.com/restservices/processDocument?language=brazilian&pagerange=allpages&outputformat=txt';
          $url = 'http://www.ocrwebservice.com/restservices/processDocument?language=brazilian&pagerange=allpages&gettext=true&outputformat=txt';
      

        // Full path to uploaded document
        $filePath = 'uploads/ocrweb/Imperio.pdf';
  
        $fp = fopen($filePath, 'r');
        $session = curl_init();

        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_USERPWD, "$username:$license_code");

        curl_setopt($session, CURLOPT_UPLOAD, true);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session, CURLOPT_TIMEOUT, 200);
        curl_setopt($session, CURLOPT_HEADER, false);


        // For SSL using
        //curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true);

        // Specify Response format to JSON or XML (application/json or application/xml)
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 
        curl_setopt($session, CURLOPT_INFILE, $fp);
        curl_setopt($session, CURLOPT_INFILESIZE, filesize($filePath));

        $result = curl_exec($session);

  	$httpCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
        curl_close($session);
        fclose($fp);
	
        if($httpCode == 401) 
	{
           // Please provide valid username and license code
           die('Unauthorized request');
        }

        // Output response
	$data = json_decode($result);

        if($httpCode != 200) 
	{
	   // OCR error
           die($data->ErrorMessage);
        }

        // Task description
	//echo 'TaskDescription:'.$data->TaskDescription."\r\n".'<br>';

        // Available pages 
	echo 'AvailablePages:'.$data->AvailablePages."\r\n".'<br>';
/*
    $count = $data->AvailablePages;
        // Extracted text
        for ($i = 0; $i <= $count; ++$i){
            echo 'OCRText='.$data->OCRText[0][$i]."\r\n".'<br>'.'<br>';

        }
*/
       

        // For zonal OCR: OCRText[z][p]    z - zone, p - pages

        // Get First zone from each page 
        echo 'OCRText[0][0]='.$data->OCRText[0][0].'<br>';
        echo 'OCRText[0][1]='.$data->OCRText[0][1].'<br>';
        echo 'OCRText[0][2]='.$data->OCRText[0][2].'<br>';
        echo 'OCRText[0][3]='.$data->OCRText[0][3].'<br>';


        // Get second zone from each page
        //echo 'OCRText[1][0]='.$data->OCRText[1][0]."\r\n";
        //echo 'OCRText[1][1]='.$data->OCRText[1][1]."\r\n";


        // Download output file (if outputformat was specified)

        $url = $data->OutputFileUrl;   
        $content = file_get_contents($url);
        file_put_contents('uploads/ocrweb/converted_document.txt', $content);

        // End recognition

?>