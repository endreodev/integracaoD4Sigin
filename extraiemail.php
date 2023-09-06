<?php 

$COFRE = "80b8c278-7576-4bc8-8ad7-288cef4389be";

$directory = '.'; // Substitua pelo caminho do diretório desejado

// Verifica se o diretório existe
if (!is_dir($directory)) {
    die("O diretório não existe.");
}

$files = scandir($directory); // Lista todos os arquivos e diretórios

// print_r($files);

foreach ($files as $file) {
    $filePath = $directory . '/' . $file;

    // Verifica se é um arquivo PDF
    if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {

        // Coloque aqui o código para processar o arquivo PDF
        echo "Arquivo PDF encontrado: $file<br>";

        //Retorna o email
        $emailAssinante = getEmail($file);
        $whatsapp       = '';

        //Envia documento e retorna id gerado no D4Sign 
        $idDocumento = enviarDocumento($filePath,$file,$COFRE);
        
        enviaSignatarioParaDocumento($emailAssinante,$whatsapp, $uuid);

        solicitaEnvioDocumento($uuid);
        
        if (rename($filePath, "executados/" . $file)) {
            echo "Arquivo movido com sucesso!". PHP_EOL;
        } else {
            echo "Não foi possível mover o arquivo.". PHP_EOL;
        }
        
    }
}

function getEmail($filename){

    // Use uma expressão regular para extrair o email
    $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/';
    preg_match($pattern, $filename, $matches);

    if (isset($matches[1])) {
        $email = $matches[1];
    } else {
        $email = "Email não encontrado";
    }

    return $email;

}

function extrairTelefoneEmail($nomeArquivo) {
    $telefonePadrao = '/(\d{11})\.pdf/';
    $emailPadrao = '/([\w\.-]+@[\w\.-]+)/';

    if (preg_match($telefonePadrao, $nomeArquivo, $telefoneEncontrado)) {
        $telefone = $telefoneEncontrado[1];
    } else {
        $telefone = null;
    }

    if (preg_match($emailPadrao, $nomeArquivo, $emailEncontrado)) {
        $email = $emailEncontrado[1];
    } else {
        $email = null;
    }

    return array('telefone' => $telefone, 'email' => $email);
}

/**
 * Summary of enviarDocumento
 * @param mixed $filePath
 * @param mixed $file
 * @return mixed
 */
function enviarDocumento($filePath,$file,$COFRE){

    $curl = curl_init();

    $uploadUrl = 'https://secure.d4sign.com.br/api/v1/documents/'.$COFRE.'/upload?tokenAPI=live_da50f81a191736dbf2339e82b12aca4a79525f9c8ce9717875560841e80e79ff&cryptKey=live_crypt_JYv0O0crnzY6vFFS4SipqRwGsyxHWfgJ';
    // $filePath  = $filePath;

    $fileData = [
        'file' => new CURLFile($filePath, 'application/pdf', $file)
    ];

    curl_setopt_array($curl, array(
        CURLOPT_URL => $uploadUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $fileData,
        CURLOPT_HTTPHEADER => array(
            'tokenAPI: live_da50f81a191736dbf2339e82b12aca4a79525f9c8ce9717875560841e80e79ff',
            'Cookie: AWSALB=o3PruH/HNfysR7jg61CkjSujGXtzLVbvGF8BQrcj4d26VNOtS/ty6VJASj8LGUNQu3IddfPNj+al/kvi47L1BusjzIj/oHNONNznPVlW17lIO88clikbo5CH+qP7; AWSALBCORS=o3PruH/HNfysR7jg61CkjSujGXtzLVbvGF8BQrcj4d26VNOtS/ty6VJASj8LGUNQu3IddfPNj+al/kvi47L1BusjzIj/oHNONNznPVlW17lIO88clikbo5CH+qP7; AWSALBTG=fzphdY244g/Dwd5rJQOop7c07mLg+n6OhdVMAIJD9CS4DLAh+ivDgVr0U7l6tadWBzSWHaFcxFvxCjQtu8EiSS8COnRgbo9X813RAKB2outWB4ZEZpizhwCSiqOYuD2A7JagKT9b0VrNgu5jxOGqU9Y4OtMiBfKYKEx1WnlfSsidxyhKSnY=; AWSALBTGCORS=fzphdY244g/Dwd5rJQOop7c07mLg+n6OhdVMAIJD9CS4DLAh+ivDgVr0U7l6tadWBzSWHaFcxFvxCjQtu8EiSS8COnRgbo9X813RAKB2outWB4ZEZpizhwCSiqOYuD2A7JagKT9b0VrNgu5jxOGqU9Y4OtMiBfKYKEx1WnlfSsidxyhKSnY='
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Erro cURL: ' . curl_error($curl);
    } else {
        echo 'Resposta: ' . $response . PHP_EOL;

        $retorno_array = json_decode( $response, true);

        $uuid = $retorno_array['uuid'];
        echo "UUID ". $uuid . PHP_EOL;

    }

    curl_close($curl);

    return $uuid;
}


function enviaSignatarioParaDocumento($emailAssinante,$whatsapp, $uuid){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://secure.d4sign.com.br/api/v1/documents/'.$uuid.'/createlist?tokenAPI=live_da50f81a191736dbf2339e82b12aca4a79525f9c8ce9717875560841e80e79ff&cryptKey=live_crypt_JYv0O0crnzY6vFFS4SipqRwGsyxHWfgJ',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "signers":"[{\\"email\\":\\"'.$emailAssinante.'\\",
        \\"act\\":\\"1\\",
        \\"foreign\\":\\"0\\",
        \\"certificadoicpbr\\":\\"0\\",
        \\"whatsapp_number\\":\\"'.$whatsapp.'\\"}]"
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json'
     ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response . PHP_EOL;

}




/**
 * Summary of solicitaEnvioDocumento
 * @return void
 */
function solicitaEnvioDocumento($uuid){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://secure.d4sign.com.br/api/v1/documents/'.$uuid.'/sendtosigner?tokenAPI=live_da50f81a191736dbf2339e82b12aca4a79525f9c8ce9717875560841e80e79ff&cryptKey=live_crypt_JYv0O0crnzY6vFFS4SipqRwGsyxHWfgJ',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "message":"\\"Segue documento de Paceiria Comercial para assinatura.\\"",
    "workflow":"0",
    "skip_email":"0"
    }',

    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Cookie: AWSALB=uYJae7vh21S8UakVMu/DrlibiuOADk6S/Rd3JPp0RGKHOU62+JeFoMGtNOpfSKLIeVD14i5CY9wv1Mc7fEO8nvQW9c4eJxNhxlCHe17yZ90tM20idsSDSMaqfTsO; AWSALBCORS=uYJae7vh21S8UakVMu/DrlibiuOADk6S/Rd3JPp0RGKHOU62+JeFoMGtNOpfSKLIeVD14i5CY9wv1Mc7fEO8nvQW9c4eJxNhxlCHe17yZ90tM20idsSDSMaqfTsO; AWSALBTG=SREYso22OhYXFiOO2C1FOALhWD+CPSTpiiEt/RQf4A+zzq/g8WEJcNtA1xwadySsG9Uk1s9cmbRM9ILa6RmJ1Hab0YHs1AaYMMHPWEktI04jI3VomX/Y/S/HqpJDvvcJPlLGwS8SwwnnWOBRzYMJdy3m+wduGBINO2G6kZGKZclHOMzAlSw=; AWSALBTGCORS=SREYso22OhYXFiOO2C1FOALhWD+CPSTpiiEt/RQf4A+zzq/g8WEJcNtA1xwadySsG9Uk1s9cmbRM9ILa6RmJ1Hab0YHs1AaYMMHPWEktI04jI3VomX/Y/S/HqpJDvvcJPlLGwS8SwwnnWOBRzYMJdy3m+wduGBINO2G6kZGKZclHOMzAlSw='
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response. PHP_EOL;

}