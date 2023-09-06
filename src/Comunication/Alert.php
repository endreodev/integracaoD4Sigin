<?php

namespace App\Comunication;

use Exception;

class Alert {

	const TELEGRAN_BOT_TOKEN = '6453296194:AAFqSiqS1Sotk1_bUg91Jnwe3gA5i2WzCW4';

	const TELEGRAN_ID_CHATBOT = -1001696881762 ;// 1534370927

 /**
  * Summary of sendMessage
  * @param string $messagem
  * @return void
  */
	public static function sendMessage($messagem){ 

		try{
			$bot = new \TelegramBot\Api\BotApi(self::TELEGRAN_BOT_TOKEN);
			$bot->sendMessage(self::TELEGRAN_ID_CHATBOT , $messagem);
		}catch(Exception $e){
			print_r($e);
		}
		
	}

}


// SELECT Name,
//     Surname,
//     JSON_VALUE(jsonCol, '$.info.address.PostCode') AS PostCode,
//     JSON_VALUE(jsonCol, '$.info.address."Address Line 1"')
//         + ' ' + JSON_VALUE(jsonCol, '$.info.address."Address Line 2"') AS Address,
//     JSON_QUERY(jsonCol, '$.info.skills') AS Skills
// FROM People