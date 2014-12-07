<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Domain\User;
use AgnamStore\Form\Type\UserType;


class UserController {

    public function loginAction(Request $request, Application $app) {
        $types = $app['dao.type']->findAll();
        return $app['twig']->render('login.html.twig', array(
                    'error' => $app['security.last_error']($request),
                    'last_username' => $app['session']->get('_security.last_username'),
                    'types' => $types,
        ));
    }

    public function registration(Request $request, Application $app) {
        $user = new User();
        $types = $app['dao.type']->findAll();
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $user->setRole('ROLE_USER');
            $this->cryptPassword($user,$app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_form.html.twig', array(
                    'title' => 'New user',
                    'userForm' => $userForm->createView(),
                    'types' => $types
        ));
    }

    // Edit an existing user
    public function settings(Request $request, Application $app) {
        $types = $app['dao.type']->findAll();
        $user = $this->getUserClient($app);
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->cryptPassword($user,$app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_form.html.twig', array(
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types
        ));
    }

    private function getUserClient(Application $app) {
        $user = $app['security']->getToken()->getUser();
        $user = $app['dao.user']->refreshUser($user);
        return $user;
    }

    private function cryptPassword($user, Application $app) {
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
    }

    private function saveUser($user, Application $app) {
        try {
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        } catch (Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }

}