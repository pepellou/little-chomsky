#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

$bot_api_key  = '877772552:AAGTxeFlJgnE4pFTfeAKlp3hqYDCUxynZaM';
$bot_username = 'LittleChomskyBot';

$mysql_credentials = [
   'host'     => 'localhost',
   'port'     => 3306, // optional
   'user'     => 'chomsky',
   'password' => 'L1ttl3_Ch0msky.',
   'database' => 'chomsky',
];

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Enable MySQL
    $telegram->enableMySql($mysql_credentials);

    // Handle telegram getUpdates request
    $telegram->handleGetUpdates();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    // echo $e->getMessage();
}
