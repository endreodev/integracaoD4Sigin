<?php

namespace App\Services;

use CURLFile;

class D4SignAPI {

    private $host;
    private $tokenAPI;
    private $cryptKey;
    private $uuidSafe;

    private $uuidFile;
    
    public function __construct() {

        $this->host        = DATA_D4SIGN_CONFIG['host'];
        $this->tokenAPI    = DATA_D4SIGN_CONFIG['tokenAPI'];
        $this->cryptKey    = DATA_D4SIGN_CONFIG['cryptKey'];
        $this->uuidSafe    = DATA_D4SIGN_CONFIG['uuidSafe'];

        // print_r(DATA_D4SIGN_CONFIG);

    }

    public function setUuidFile($uuidFile){
        $this->uuidFile = $uuidFile;
    }
    
    public function uploadFile($filePath, $file) {
        // Implemente o método de upload de arquivo aqui
        // Use $this->host, $this->tokenAPI, $this->cryptKey e $uuidSafe conforme necessário
        $ret = false;
        $curl = curl_init();

        $uploadUrl = $this->host.'/documents/'.$this->uuidSafe.'/upload?tokenAPI='.$this->tokenAPI.'&cryptKey='.$this->cryptKey ;

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
                'tokenAPI:'.$this->tokenAPI,
                'Cookie: AWSALB=o3PruH/HNfysR7jg61CkjSujGXtzLVbvGF8BQrcj4d26VNOtS/ty6VJASj8LGUNQu3IddfPNj+al/kvi47L1BusjzIj/oHNONNznPVlW17lIO88clikbo5CH+qP7; AWSALBCORS=o3PruH/HNfysR7jg61CkjSujGXtzLVbvGF8BQrcj4d26VNOtS/ty6VJASj8LGUNQu3IddfPNj+al/kvi47L1BusjzIj/oHNONNznPVlW17lIO88clikbo5CH+qP7; AWSALBTG=fzphdY244g/Dwd5rJQOop7c07mLg+n6OhdVMAIJD9CS4DLAh+ivDgVr0U7l6tadWBzSWHaFcxFvxCjQtu8EiSS8COnRgbo9X813RAKB2outWB4ZEZpizhwCSiqOYuD2A7JagKT9b0VrNgu5jxOGqU9Y4OtMiBfKYKEx1WnlfSsidxyhKSnY=; AWSALBTGCORS=fzphdY244g/Dwd5rJQOop7c07mLg+n6OhdVMAIJD9CS4DLAh+ivDgVr0U7l6tadWBzSWHaFcxFvxCjQtu8EiSS8COnRgbo9X813RAKB2outWB4ZEZpizhwCSiqOYuD2A7JagKT9b0VrNgu5jxOGqU9Y4OtMiBfKYKEx1WnlfSsidxyhKSnY='
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Erro cURL: ' . curl_error($curl);
        } else {
            $retorno_array = json_decode( $response, true);
            $uuid = $retorno_array['uuid'];
            $this->setUuidFile($uuid);
            $ret = true;
        }

        curl_close($curl);

        return $ret;

    }
    
    public function createSignatureList($email, $telefone) {
        // Implemente o método de criação de lista de assinaturas aqui
        // Use $this->host, $this->tokenAPI, $this->cryptKey, $uuidDocument e $signers conforme necessário

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->host.'/documents/'.$this->uuidFile.'/createlist?tokenAPI='.$this->tokenAPI.'&cryptKey='.$this->cryptKey ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "signers": [
                {
                    "email": "'.$email.'",
                    "act": "1",
                    "foreign": "0",
                    "certificadoicpbr": "0",
                    "whatsapp_number": "+55'.$telefone.'"
                }
            ]
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
    
    public function solicitaEnviodeDocumento() {
        // Implemente o método de criação de pasta no cofre aqui
        // Use $this->host, $this->tokenAPI, $this->cryptKey, $folderName e $uuidSafe conforme necessário
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->host.'/documents/'.$this->uuidFile.'/sendtosigner?tokenAPI='.$this->tokenAPI.'&cryptKey='.$this->cryptKey,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "skip_email" : ""
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Cookie: AWSALB=uNatnFjakenIuCqUjftl4+N1G11VZKi7ZhSImXPEaAjhDqaJfarE6WtCJ/G5yj7T9+ba57c3zSzXLc16PIQECEeNrM/v4vQqWzBHABVajcIsJJ1bAGO1H8TgDYTO; AWSALBCORS=uNatnFjakenIuCqUjftl4+N1G11VZKi7ZhSImXPEaAjhDqaJfarE6WtCJ/G5yj7T9+ba57c3zSzXLc16PIQECEeNrM/v4vQqWzBHABVajcIsJJ1bAGO1H8TgDYTO; AWSALBTG=XYj/H+ZilggGOrieu5YE70y4gKVeb3SxchhstPSJ868jJsenA7WWpvHSYMLOw6ElLVhV5XEO5Yzj4JvyIy8OXjJX7oPRheo2S0KIJJsSNOtGuEVgfK8f3R+FtuOEki5GW4UEdAHx4VqlAvYNdamqt4PQ4NbnJ/cOgUNPWAwXUByAVGhMwVM=; AWSALBTGCORS=XYj/H+ZilggGOrieu5YE70y4gKVeb3SxchhstPSJ868jJsenA7WWpvHSYMLOw6ElLVhV5XEO5Yzj4JvyIy8OXjJX7oPRheo2S0KIJJsSNOtGuEVgfK8f3R+FtuOEki5GW4UEdAHx4VqlAvYNdamqt4PQ4NbnJ/cOgUNPWAwXUByAVGhMwVM=; ci_session=punlrtabv6inge1j64jbe99i67g02en9'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

}



