<?php
require 'vendor/autoload.php';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

$data = json_encode(file_get_contents('php://input'));

$text = "what was the score between arsenal and chelsea";

$client = new Client('AIzaSyCzhcvDNXlCYq80xGjaieIJOuGapDwCtFc');

$response = $client->geminiPro()->generateContent(
    new TextPart($text),
);

echo $response->text();
