# integracaoD4Sigin

Integra com API D4Sigin  dev

config.php 
Token e chaves de acesso para api`s
> host		= "https://secure.d4sign.com.br/api/v1",
> tokenAPI	= token deve ser obtido dentro do sistema
> cryptKey	= cryptKey deve ser obtido dentro do sistema
> uuidSafe	= acesse o sistema e o cofre abaixo do cofre esta o id do cofre

const DATA_D4SIGN_CONFIG = [
	'host' => "https://secure.d4sign.com.br/api/v1",
	'tokenAPI' => "live_da50f81a19173",
	'cryptKey' => "live_crypt_JYv0O0c",
	'uuidSafe' => "80b8c278-7576-4bc8"
];


#Para criar bot telegram:
>acesse telegram 
>busque por BotFather
>envie ola 
> preencha os dados 
> salve o token 
> inicie uma conversa
> start api bot
> acesse a pagina 
// https://api.telegram.org/bot{tokenTelegran}/getUpdates
// vai mostrar as mensagens ai 6453296194:AAFqSiqS1Sotk1_bUg91Jnwe3gA5i2WzCW4
// https://api.telegram.org/bot6453296194:AAFqSiqS1Sotk1_bUg91Jnwe3gA5i2WzCW4/getUpdates

Copie o id da conversa 