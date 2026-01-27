<?php
require_once 'vendor/autoload.php';
require_once 'db_connection.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

$client = HttpClient::create();
$response = $client->request(
    'GET',
    'https://habr.com/ru/feed/'
);

