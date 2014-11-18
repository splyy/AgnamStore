<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('index.html.twig',  array('types' => $types));
});

$app->get('/test', function () use ($app) {
    $items = $app['dao.item']->findAll();
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('items.html.twig', array('types' => $types,'items' => $items));
});

$app->get('/items/type={typeId}', function($typeId) use ($app) {
    $items = $app['dao.item']->findByType($typeId);
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('items.html.twig', array('types' => $types,'items' => $items));
});

$app->get('/items/{id}', function ($id) use ($app) {
    $item = $app['dao.item']->find($id);
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('item.html.twig', array('item' => $item, 'types' => $types));
});


