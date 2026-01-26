<?php
require 'vendor/autoload.php';
require_once 'db_connection.php';
require_once 'decimal_type.php';

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();
$response = $client->request('GET', 'https://cbr.ru/');
$html = $response->getContent();
$crawler = new Crawler($html);

/* Извлекаем значения */

$values = $crawler->filterXPath('//div[@class="col-md-2 col-xs-9 _right mono-num"]')->extract(['_text']);
$currency = ['CNY', 'USD', 'EUR'];

/* Переносим значения курсов валют за последнюю дату из массивы $values в массив 
$currency_rate и при этом "округляем" число до сотых */

$currency_rate = [];
for ($i = 0; $i < count($values); $i++) {
    $length = strpos($values[$i], ',') + 3; // Определяем кол-во цифр до запятой, и прибавляем 3.
    if ($i % 2 != 0) {
        $currency_rate[] = substr($values[$i], 0, $length);
    }   
}

/* Приводим тип данных (string) к (double) при помощи написанной нами функции get_decimal(), 
и выводи значения на экран */

for ($i = 0; $i < count($currency_rate); $i++) {
    $currency_rate[$i] = get_decimal($currency_rate[$i]);
    echo $currency[$i] . ': ' . $currency_rate[$i] . '</br>';
}

/* Сохраняем данные в базу данных */

$query = 'INSERT INTO currency_rate_cbrf VALUES (now(), ?, ?, ?)';

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$currency_rate[0], $currency_rate[1], $currency_rate[2]]);
    echo 'Данные успешно добавленны в базу данных' . PHP_EOL; 
} catch (PDOException $e) {
    echo 'Добавление данных не удалось по причине: ' . $e->getMessage() . '</br>';
}
