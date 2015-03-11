<?php
namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class MainController {  
    protected function renderView(Application $app,$view,$param = array()){
        
        $param['types'] = $app['dao.type']->findAll();
        return $app['twig']->render($view, $param);
    }

    protected function getUserClient(Application $app) {
        $user = $app['security']->getToken()->getUser();
        $user = $app['dao.user']->refreshUser($user);
        return $user;
    }
}
