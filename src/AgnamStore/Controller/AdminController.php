<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Domain\User;
use AgnamStore\Form\Type\UserTypeAdm;
use AgnamStore\Form\Type\UserMdpType;
use AgnamStore\Form\Type\UserProfilType;
use AgnamStore\Form\Type\UserRoleType;

class AdminController {

    public function index(Application $app) {
        $types = $app['dao.type']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
                    'types' => $types,
                    'users' => $users));
    }

    public function addUser(Request $request, Application $app) {
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

    public function profil($id, Request $request, Application $app) {
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
    public function password($id, Request $request, Application $app) {
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
    public function role($id, Request $request, Application $app) {
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

    public function delUser($id, Request $request, Application $app) {
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
        return $app->redirect('/admin');
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
