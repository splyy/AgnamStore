<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('index.html.twig',  array('type' => $types));
});

$app->get('/test', function () use ($app) {
    $items = $app['dao.item']->findAll();
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('items.html.twig', array('types' => $types,'items' => $items));
});

$app->get('/type={typeId}', function($typeId) use ($app) {
    $items = $app['dao.item']->findByType($typeId);
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('items.html.twig', array('types' => $types,'items' => $items));
});


