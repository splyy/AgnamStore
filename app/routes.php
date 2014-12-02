<?php

use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Domain\User;
use AgnamStore\Form\Type\UserType;
use AgnamStore\Form\Type\UserTypeAdm;

// Home page
$app->get('/', function () use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('index.html.twig', array('types' => $types));
});

// Login form
$app->get('/login', "AgnamStore\Controller\UserController::loginAction")
->bind('login');  // named route so that path('login') works in Twig templates

// Registration
$app->match('/registration', "AgnamStore\Controller\UserController::registration" );

// Edit an existing user
$app->match('/settings', "AgnamStore\Controller\UserController::settings" );

// Items by type
$app->get('/items/type={typeId}', "AgnamStore\Controller\ItemController::itemsByType");
// Item by id
$app->get('/items/{id}', "AgnamStore\Controller\ItemController::itemById");


/* * ************************************************************
 * Administration
 * Accés ROLE_ADMIN
 * **** */
$app->get('/admin', "AgnamStore\Controller\AdminController::index");


/* * ************************************************************
 * Gestion User
 * **** */
// Add a user
$app->match('/admin/user/add', "AgnamStore\Controller\AdminController::addUser");
// Edit an existing user
$app->match('/admin/user/{id}/edit', "AgnamStore\Controller\AdminController::editUser");
// Remove a user
$app->get('/admin/user/{id}/delete', "AgnamStore\Controller\AdminController::delUser");




