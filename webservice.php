<?php 
	
	// inclua antes do código que utilizará o SDK
	require_once('./vendor/autoload.php');

	use App\Comunication\Alert;

	$D4SignAPI = new \App\Services\D4SignAPI();
	$MSGTELEGRAN = "";

	// Substitua pelo caminho do diretório desejado
	$directory = '.'; 

	// Verifica se o diretório existe
	if (!is_dir($directory)) { 

		$MSGTELEGRAN .= "Diretorio: ".$directory. PHP_EOL;
		$MSGTELEGRAN .= "O diretório não existe.";

		Alert::sendMessage($MSGTELEGRAN);

		die("O diretório não existe.");

	}else{
		echo "Diretório encontrado Prosseguir".PHP_EOL;
	}

	// Lista todos os arquivos e diretórios
	$files = scandir($directory); 

	
	// Filtrar apenas os arquivos PDF
	$pdfFiles = array_filter($files, function($file) {
		return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
	});
	
	$MSGTELEGRAN .= "Carregou arquivos.".PHP_EOL;
	echo "Carregou arquivos... ".count($pdfFiles)."".PHP_EOL;

	foreach ($pdfFiles as $file) {

		$filePath = $directory . '/' . $file;

		$MSGTELEGRAN .= "Processando aquivo ".$filePath."".PHP_EOL;
		echo "Processando aquivo ".$filePath."".PHP_EOL;

		// Verifica se é um arquivo PDF
		if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {

			// Coloque aqui o código para processar o arquivo PDF
			$MSGTELEGRAN .= "Arquivo PDF encontrado: $file ". PHP_EOL;
			echo "Arquivo PDF encontrado: $file ". PHP_EOL;

			//Retorna o email e telefone 
			$Signature = (new \App\Services\FileDocuments())->extrairTelefoneEmail($file);

			//Envia documento e retorna id gerado no D4Sign 
			if($D4SignAPI->uploadFile($filePath,$file)){
				$MSGTELEGRAN .= "Sucesso no envio de documento para D4Sigin!". PHP_EOL;
				echo "Sucesso no envio de documento para D4Sigin!". PHP_EOL;

				$D4SignAPI->createSignatureList($Signature['email'],$Signature['telefone']);
				$MSGTELEGRAN .= "Criou Signatario para o documento!". PHP_EOL;
				echo "Criou Signatario para o documento!". PHP_EOL;

				$D4SignAPI->solicitaEnviodeDocumento();
				$MSGTELEGRAN .= "Solicitou o envio de documento para documento!". PHP_EOL;
				echo "Solicitou o envio de documento para documento!". PHP_EOL;

			}else{
				
				$MSGTELEGRAN .= "Erro no envio de documento para D4Sigin!". PHP_EOL;
				echo "Erro no envio de documento para D4Sigin!". PHP_EOL;
			}
			
			if (rename($filePath, "executados/" . $file)) {
				
				$MSGTELEGRAN .= "Arquivo movido com sucesso!". PHP_EOL;
				echo "Arquivo movido com sucesso!". PHP_EOL;
				
			} else {
				
				$MSGTELEGRAN .= "Não foi possível mover o arquivo.". PHP_EOL;
				echo "Não foi possível mover o arquivo.". PHP_EOL;
			}

			Alert::sendMessage($MSGTELEGRAN);
			
		}
	}

	echo "Processo executado!". PHP_EOL;


	