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
$app->get('/login', function(Request $request) use ($app) {
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('login.html.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
                'types' => $types,
    ));
})->bind('login'); // named route so that path('login') works in Twig templates

$app->match('/registration', function(Request $request) use ($app) {
    $user = new User();
    $types = $app['dao.type']->findAll();
    $userForm = $app['form.factory']->create(new UserType(), $user);
    $userForm->handleRequest($request);
    if ($userForm->isValid()) {
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $user->setRole('ROLE_USER');
        $plainPassword = $user->getPassword();
        // find the default encoder
        $encoder = $app['security.encoder.digest'];
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        try {
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        } catch (Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }
    return $app['twig']->render('user_form.html.twig', array(
                'title' => 'New user',
                'userForm' => $userForm->createView(),
                'types' => $types
    ));
});

// Edit an existing user
$app->match('/settings', function(Request $request) use ($app) {
    $types = $app['dao.type']->findAll();
    $user = $app['security']->getToken()->getUser();
    $user = $app['dao.user']->refreshUser($user);
    $userForm = $app['form.factory']->create(new UserType(), $user);
    $userForm->handleRequest($request);
    if ($userForm->isValid()) {
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        try {
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        } catch (Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }
    return $app['twig']->render('user_form.html.twig', array(
                'title' => 'Edit user',
                'userForm' => $userForm->createView(),
                'types' => $types
    ));
});

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







/* * ************************************************************
 * Administration
 * Accés ROLE_ADMIN
 * **** */

// Admin zone
$app->get('/admin', function() use ($app) {
    $types = $app['dao.type']->findAll();
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
                'types' => $types,
                'users' => $users));
});

/* * ************************************************************
 * Administration
 * Gestion User
 * **** */
// Add a user
$app->match('/admin/user/add', function(Request $request) use ($app) {
    $user = new User();
    $types = $app['dao.type']->findAll();
    $userForm = $app['form.factory']->create(new UserTypeAdm(), $user);
    $userForm->handleRequest($request);
    if ($userForm->isValid()) {
        $salt = substr(md5(time()), 0, 23);
        $user->setSalt($salt);
        $user->setRole('ROLE_USER');
        $plainPassword = $user->getPassword();
        // find the default encoder
        $encoder = $app['security.encoder.digest'];
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        try {
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        } catch (Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }
    return $app['twig']->render('user_form_adm.html.twig', array(
                'title' => 'New user',
                'userForm' => $userForm->createView(),
                'types' => $types
    ));
});
// Edit an existing user
$app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
    $user = $app['dao.user']->find($id);
    $types = $app['dao.type']->findAll();
    $userForm = $app['form.factory']->create(new UserTypeAdm(), $user);
    $userForm->handleRequest($request);
    if ($userForm->isValid()) {
        $option['mdpChanged']  = $_REQUEST['mdpChanged'];
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
        try {
            $app['dao.user']->save($user,$option);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        } catch (Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }
    return $app['twig']->render('user_form_adm.html.twig', array(
                'mdpChanged' => true,
                'title' => 'Edit user',
                'userForm' => $userForm->createView(),
                'types' => $types
    ));
});
// Remove a user
$app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
    // Delete the user
    $app['dao.user']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
    return $app->redirect('/admin');
});


