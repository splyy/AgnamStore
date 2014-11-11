<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/test', function () use ($app) {
    $items = $app['dao.item']->findAll();
    return $app['twig']->render('items.html.twig', array('items' => $items));
});


