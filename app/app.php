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
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
            $twig->addExtension(new Twig_Extensions_Extension_Text());
            return $twig;
        })
);
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new AgnamStore\DAO\UserDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
        array('^/user', 'ROLE_USER'),
    ),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../var/logs/AgnamStore.log',
    'monolog.name' => 'AgnamStore',
    'monolog.level' => $app['monolog.level']
));
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
if (isset($app['debug']) && $app['debug']) {
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__ . '/../var/cache/profiler'
    ));
}


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

$app['dao.user'] = $app->share(function ($app) {
    return new AgnamStore\DAO\UserDAO($app['db']);
});

$app->error(function (\Exception $e, $code) use ($app) {
    $types = $app['dao.type']->findAll();
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = "Something went wrong.";
    }
    return $app['twig']->render('error.html.twig', array('types' => $types, 'message' => $message));
});
