<?php


// inclua antes do código que utilizará o SDK
require_once(__DIR__ . '../vendor/autoload.php');

use App\Comunication\Alert;

Alert::sendMessage('Olá Mundo');