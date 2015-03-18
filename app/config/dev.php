<?php

// include the prod configuration
require __DIR__ . '/prod.php';

// enable the debug mode
$app['debug'] = true;

// define log parameters
$app['monolog.level'] = 'INFO';

