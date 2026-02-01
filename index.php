<?php
require_once 'vendor/autoload.php';
require_once 'db_connection.php';

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;

$client = Client::createChromeClient();
$client->request('GET', 'https://lugansk.mot-motor.ru/snegohody/');
$client->waitFor('#_R_', 30);
$crawler = $client->getCrawler();
$crawler->filterXPath('/html/body/main/section[1]/div/div[2]/div/div[1]/ul');
var_dump($crawler);



