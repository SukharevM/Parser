<?php
require_once 'vendor/autoload.php';
require_once 'db_connection.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

/* Создаем клиент, и забираем странцицу */
$client = HttpClient::create();
$response = $client->request(
    'GET',
    'https://lugansk.mot-motor.ru/snegohody/'
);
$content = $response->getContent();
$crawler = new Crawler($content);
$data = $crawler->filterXPath("//ul");
echo $data->count() . PHP_EOL . 'node_name: ' . $data->nodeName();
echo 'Type: ' . gettype($data) . ' Class: ' . $data::class . PHP_EOL;
$array = $data->extract(['_text']);
echo 'Type: ' . gettype($array) . PHP_EOL;
var_dump($array);
/* Выбираем нужный элемент из DOM-дерева, при помощи CssSelector'a */

