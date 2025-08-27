<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver' => 'pdo_mysql',
    'charset' => 'utf8mb4',
    'host' => 'db',
    'port' => '3306',
    'dbname' => 'agnamstore',
    'user' => 'agnamstore_user',
    'password' => 'secret',
    'driverOptions' => array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
    ),
);

$app['paypal'] = [
    'settings.paypal.mode' => 'sandbox',
    'settings.paypal.api.id' => 'AcyVqLtb0DYFubnvU7fnpPI9fR2NFoER6w1B8RN_QIhQQCjiLUSQ9FG_XIYUOep8mGMWFvr_j10i5gnx',
    'settings.paypal.api.secret' => 'EPkOaODk9TWEije1U7BvEctH1mrzQ2Safo9dHEKG4dmLynNoXZ4GSPTgZSA2SB8RRZeMSmpuZTbKZ0rn',
    'settings.paypal.endpoint' => 'api.sandbox.paypal.com',
    'settings.paypal.sandboxaccount' => null,
];
// define log parameters
$app['monolog.level'] = 'WARNING';

