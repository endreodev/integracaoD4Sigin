<?php

/*dados db*/ 
const DATA_D4SIGN_CONFIG = [
	'host' => "https://secure.d4sign.com.br/api/v1",
	'tokenAPI' => "live_da50f81a191736dbf2339e82b12aca4a79525f9c8ce9717875560841e80e79ff",
	'cryptKey' => "live_crypt_JYv0O0crnzY6vFFS4SipqRwGsyxHWfgJ",
	'uuidSafe' => "80b8c278-7576-4bc8-8ad7-288cef4389be"
];

const DATA_TELEGRAN = [
	'tokenTelegran' => "6453296194:AAFqSiqS1Sotk1_bUg91Jnwe3gA5i2WzCW4"
];

// start api bot
// https://api.telegram.org/bot{tokenTelegran}/getUpdates
// vai mostrar as mensagens ai 6453296194:AAFqSiqS1Sotk1_bUg91Jnwe3gA5i2WzCW4
// https://api.telegram.org/bot6453296194:AAFqSiqS1Sotk1_bUg91Jnwe3gA5i2WzCW4/getUpdates