<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver' => 'pdo_mysql',
    'charset' => 'utf8',
    'host' => '127.0.0.1',
    'port' => '3306',
    'dbname' => 'agnamstore',
    'user' => 'agnamstore_user',
    'password' => 'secret',
);

$app['paypal'] = [
    'settings.paypal.mode' => 'sandbox',
    'settings.paypal.api.id' => null,
    'settings.paypal.api.secret' => null,
    'settings.paypal.endpoint' => 'api.sandbox.paypal.com',
    'settings.paypal.sandboxaccount' => null,
];
// define log parameters
$app['monolog.level'] = 'WARNING';
