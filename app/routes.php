<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('index.html.twig', array('types' => $types));
});

// Login form
$app->get('/login', function(Request $request) use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('login.html.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
                'types' => $types,
    ));
})->bind('login'); // named route so that path('login') works in Twig templates

$app->get('/items/type={typeId}', function($typeId) use ($app) {
    $items = $app['dao.item']->findByType($typeId);
    $types = $app['dao.type']->findAll();
    $typeG = $app['dao.type']->find($typeId);
    return $app['twig']->render('items.html.twig', array('types' => $types, 'items' => $items, "typeG" => $typeG));
});

$app->get('/items/{id}', function ($id) use ($app) {
    $item = $app['dao.item']->find($id);
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('item.html.twig', array('item' => $item, 'types' => $types));
});

// Test
$app->get('/test/type={typeId}', function($typeId) use ($app) {
    $items = $app['dao.item']->findByType($typeId);
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('test.html.twig', array('types' => $types, 'items' => $items));
});


