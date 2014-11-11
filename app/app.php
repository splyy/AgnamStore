<?php

// Register global error and exception handlers
use Symfony\Component\Debug\ErrorHandler;

ErrorHandler::register();

use Symfony\Component\Debug\ExceptionHandler;

ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());


// Register services.
$app['dao.genre'] = $app->share(function ($app) {
    return new AgnamStore\DAO\GenreDAO($app['db']);
});
$app['dao.type'] = $app->share(function ($app) {
    return new AgnamStore\DAO\TypeDAO($app['db']);
});

$app['dao.item'] = $app->share(function ($app) {
    $itemDAO = new AgnamStore\DAO\ItemDAO($app['db']);
    $itemDAO->setGenreDAO($app['dao.genre']);
    $itemDAO->setTypeDAO($app['dao.type']);
    return $itemDAO;
});
