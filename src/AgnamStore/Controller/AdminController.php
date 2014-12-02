<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Domain\User;
use AgnamStore\Form\Type\UserTypeAdm;

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

    public function editUser($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $types = $app['dao.type']->findAll();
        $userForm = $app['form.factory']->create(new UserTypeAdm(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->cryptPassword($user,$app);
            $this->saveUser($user,$app);
        }
        return $app['twig']->render('user_form_adm.html.twig', array(
                    'mdpChanged' => true,
                    'title' => 'Edit user',
                    'userForm' => $userForm->createView(),
                    'types' => $types
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
