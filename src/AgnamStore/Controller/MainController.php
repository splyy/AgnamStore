<?php
namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class MainController {  
     // Get user connected
     protected function getUserClient(Application $app) {
        $user = $app['security']->getToken()->getUser();
        $user = $app['dao.user']->refreshUser($user);
        return $user;
    }
}
