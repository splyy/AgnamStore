<?php


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 * Gestion Item
 * 
 * * * * */


// Items by type
$app->get('/items/type={typeId}', "AgnamStore\Controller\ItemController::itemsByType");
// Item by id
$app->get('/items/{id}', "AgnamStore\Controller\ItemController::itemById");

/* Administration */

// Edit an existing user
$app->match('/admin/item/{id}/', "AgnamStore\Controller\ItemController::editItemAdm");
// Remove a user
$app->get('/admin/item/{id}/delete', "AgnamStore\Controller\ItemController::delItemAdm");
// Add a item
$app->match('/admin/item/add', "AgnamStore\Controller\ItemController::addItemAdm");


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 *      Home Page
 * 
 * * * * */
// Index page Adm Accés ROLE_ADMIN
$app->get('/admin', "AgnamStore\Controller\HomeController::indexAdm");
// Index page 
$app->get('/', "AgnamStore\Controller\HomeController::index");


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 * Gestion User
 * 
 * * * * */

/* User identified */

/* All User */

// Login form
$app->get('/login', "AgnamStore\Controller\UserController::loginAction")
->bind('login');  // named route so that path('login') works in Twig templates
// Registration
$app->match('/registration', "AgnamStore\Controller\UserController::registration" );

// Edit an existing user
$app->match('/user', "AgnamStore\Controller\UserController::profil" );
$app->match('/user/password', "AgnamStore\Controller\UserController::password" );

/* Administration */

// Add a user
$app->match('/admin/user/add', "AgnamStore\Controller\UserController::addUserAdm");
// Edit an existing user
$app->match('/admin/user/{id}/', "AgnamStore\Controller\UserController::profilAdm");
$app->match('/admin/user/{id}/password', "AgnamStore\Controller\UserController::passwordAdm");
$app->match('/admin/user/{id}/role', "AgnamStore\Controller\UserController::roleAdm");
// Remove a users
$app->get('/admin/user/{id}/delete', "AgnamStore\Controller\UserController::delUserAdm");





