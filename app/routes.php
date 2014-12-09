<?php

// Home page
$app->get('/', "AgnamStore\Controller\ItemController::index");

// Login form
$app->get('/login', "AgnamStore\Controller\UserController::loginAction")
->bind('login');  // named route so that path('login') works in Twig templates

// Registration
$app->match('/registration', "AgnamStore\Controller\UserController::registration" );

// Edit an existing user
$app->match('/user', "AgnamStore\Controller\UserController::profil" );
$app->match('/user/password', "AgnamStore\Controller\UserController::password" );

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
$app->match('/admin/user/{id}/', "AgnamStore\Controller\AdminController::profil");
$app->match('/admin/user/{id}/password', "AgnamStore\Controller\AdminController::password");
$app->match('/admin/user/{id}/role', "AgnamStore\Controller\AdminController::role");
// Remove a user
$app->get('/admin/user/{id}/delete', "AgnamStore\Controller\AdminController::delUser");




