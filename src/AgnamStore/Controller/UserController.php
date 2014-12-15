<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Domain\User;
use AgnamStore\Form\Type\User\UserRegistrationType;
use AgnamStore\Form\Type\User\UserMdpType;
use AgnamStore\Form\Type\User\UserProfilType;
use AgnamStore\Form\Type\User\UserTypeAdm;
use AgnamStore\Form\Type\User\UserRoleType;


class UserController {

    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Zone accés tout Utilisateur
     * 
     * * * * * */
    
    
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
        $userForm = $app['form.factory']->create(new UserRegistrationType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $user->setRole('ROLE_USER');
            $this->cryptPassword($user,$app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_registration_form.html.twig', array(
                    'title' => 'New user',
                    'userForm' => $userForm->createView(),
                    'types' => $types
        ));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Zone accés Utilisateur Connecté
     * 
     * * * * * */
    
    public function profil(Request $request, Application $app) {
        $userMenu = 0;
        $types = $app['dao.type']->findAll();
        $user = $this->getUserClient($app);
        $userForm = $app['form.factory']->create(new UserProfilType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user.html.twig', array(
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types,
                    'userMenu' => $userMenu,
        ));
    }

    public function password(Request $request, Application $app) {
        $types = $app['dao.type']->findAll();
        $userMenu = 1;
        $user = $this->getUserClient($app);
        $userForm = $app['form.factory']->create(new UserMdpType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->cryptPassword($user,$app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user.html.twig', array(
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types,
                    'userMenu' => $userMenu,
        ));
    }
    
    public function addUserAdm(Request $request, Application $app) {
        $user = new User();
        $types = $app['dao.type']->findAll();
        $userForm = $app['form.factory']->create(new UserTypeAdm(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $user->setRole('ROLE_USER');
            $this->cryptPassword($user,$app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_form_adm.html.twig', array(
                    'title' => 'New user',
                    'userForm' => $userForm->createView(),
                    'types' => $types
        ));
    }

    public function profilAdm($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $types = $app['dao.type']->findAll();
        $userMenu = 0;
        $userForm = $app['form.factory']->create(new UserProfilType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_adm.html.twig', array(
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types,
                    'userMenu' => $userMenu,
                    'user' => $user,
        ));
    }
    public function passwordAdm($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $types = $app['dao.type']->findAll();
        $userMenu = 1;
        $userForm = $app['form.factory']->create(new UserMdpType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->cryptPassword($user, $app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_adm.html.twig', array(
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types,
                    'userMenu' => $userMenu,
                    'user' => $user,
        ));
    }
    public function roleAdm($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $types = $app['dao.type']->findAll();
        $userMenu = 2;
        $userForm = $app['form.factory']->create(new UserRoleType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_adm.html.twig', array(
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types,
                    'userMenu' => $userMenu,
                    'user' => $user,
        ));
    }

    public function delUserAdm($id, Request $request, Application $app) {
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
        return $app->redirect('/admin');
    }
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Methode
     * 
     * * * * * */
    
    
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
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }

}
