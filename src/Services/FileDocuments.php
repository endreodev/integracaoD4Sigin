<?php

namespace App\Services;

class FileDocuments {

	public function extrairTelefoneEmail($nomeArquivo):array
	{
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

	

}