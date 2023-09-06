<?php 

	// inclua antes do código que utilizará o SDK
	require_once(__DIR__ . '../../vendor/autoload.php');

	use App\Services\D4Sigin\D4SignAPI;

	$d4SignAPI = new D4SignAPI();



	try{
	

	
		//print_r($id_doc);
	} catch (Exception $e) {
		echo $e->getMessage();
	} 