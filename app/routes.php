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

$app->get('/item/{id}', function ($id) use ($app) {
    $item = $app['dao.item']->find($id);
    return $app['twig']->render('item.html.twig', array('item' => $item));
});


