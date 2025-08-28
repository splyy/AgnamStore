<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AgnamStore\Domain\User;
use AgnamStore\Form\Type\User\UserRegistrationType;
use AgnamStore\Form\Type\User\UserMdpType;
use AgnamStore\Form\Type\User\UserProfilType;
use AgnamStore\Form\Type\User\UserTypeAdm;
use AgnamStore\Form\Type\User\UserRoleType;

class UserController extends MainController
{
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     *       Zone accés tout Utilisateur
     *
     * * * * * */

    // Connexion
    public function loginAction(Request $request, Application $app)
    {
        return $this->renderView($app, 'login.html.twig', array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

    // Registration
    public function registration(Request $request, Application $app)
    {
        $user = new User();

        $userForm = $app['form.factory']->create(new UserRegistrationType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $user->setRole('ROLE_USER');
            $this->cryptPassword($user, $app);
            $this->saveUser($user, $app, 'Votre inscription est terminé. Vous pouvez désormais vous connecter.');
            return new RedirectResponse($request->getBaseUrl() . '/login');
        }
        return $this->renderView($app, 'user_registration_form.html.twig', array(
            'title' => 'Nouvel utilisateur',
            'userForm' => $userForm->createView()
        ));
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     *       Zone accés Utilisateur Connecté
     *
     * * * * * */

    // Edit Profil
    private function cryptPassword($user, Application $app)
    {
        $plainPassword = $user->getPassword();
        // find the encoder for the user
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
    }

    // Edit Password
    private function saveUser($user, Application $app, $msg = 'L\'utilisateur a été mis à jour')
    {
        try {
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', $msg);
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     *       Administration
     *
     * * * * * */

    // Add User on admin
    public function profil(Request $request, Application $app)
    {
        $userMenu = 0;

        $user = $this->getUserClient($app);
        $userForm = $app['form.factory']->create(new UserProfilType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->saveUser($user, $app, 'Le profil de l\'utilisateur a été mis à jour');
        }
        return $this->renderView($app, 'user.html.twig', array(
            'title' => 'Editer un utilisateur',
            'userForm' => $userForm->createView(),
            'userMenu' => $userMenu,
        ));
    }

    // Edit User Profil on admin
    public function password(Request $request, Application $app)
    {

        $userMenu = 1;
        $user = $this->getUserClient($app);
        $userForm = $app['form.factory']->create(new UserMdpType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->cryptPassword($user, $app);
            $this->saveUser($user, $app, 'Le mot de passe de l\'utilisateur a été mis à jour');
        }
        return $this->renderView($app, 'user.html.twig', array(
            'title' => 'Edtier un utilisateur',
            'userForm' => $userForm->createView(),
            'userMenu' => $userMenu,
        ));
    }

    // Edit password on admin
    public function addUserAdm(Request $request, Application $app)
    {
        $user = new User();

        $userForm = $app['form.factory']->create(new UserTypeAdm(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $user->setRole('ROLE_USER');
            $this->cryptPassword($user, $app);
            $this->saveUser($user, $app);
        }
        return $this->renderView($app, 'user_form_adm.html.twig', array(
            'title' => 'Nouvel utilisateur',
            'userForm' => $userForm->createView()
        ));
    }

    // Edit role on admin
    public function profilAdm($id, Request $request, Application $app)
    {
        $user = $app['dao.user']->find($id);

        $userMenu = 0;
        $userForm = $app['form.factory']->create(new UserProfilType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->saveUser($user, $app);
        }
        return $this->renderView($app, 'user_adm.html.twig', array(
            'title' => 'Editer un utilisateur',
            'userForm' => $userForm->createView(),
            'userMenu' => $userMenu,
            'user' => $user,
        ));
    }

    // Delete user on admin
    public function passwordAdm($id, Request $request, Application $app)
    {
        $user = $app['dao.user']->find($id);

        $userMenu = 1;
        $userForm = $app['form.factory']->create(new UserMdpType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->cryptPassword($user, $app);
            $this->saveUser($user, $app);
        }
        return $this->renderView($app, 'user_adm.html.twig', array(
            'title' => 'Editer un utilisateur',
            'userForm' => $userForm->createView(),
            'userMenu' => $userMenu,
            'user' => $user,
        ));
    }


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *
     *       Methode
     *
     * * * * * */

    // Encrypted password on md5
    public function roleAdm($id, Request $request, Application $app)
    {
        $user = $app['dao.user']->find($id);

        $userMenu = 2;
        $userForm = $app['form.factory']->create(new UserRoleType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $this->saveUser($user, $app);
        }
        return $this->renderView($app, 'user_adm.html.twig', array(
            'title' => 'Editer un utilisateur',
            'userForm' => $userForm->createView(),
            'userMenu' => $userMenu,
            'user' => $user,
        ));
    }

    // Save an user
    public function delUserAdm($id, Request $request, Application $app)
    {
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'utilisateur a été supprimé.');
        return $app->redirect('/admin');
    }

}
