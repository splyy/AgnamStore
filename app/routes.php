<?php

use Symfony\Component\HttpFoundation\Request;
use \GSB\Domain\VisitReport;
use \GSB\Form\Type\VisitReportType;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});


