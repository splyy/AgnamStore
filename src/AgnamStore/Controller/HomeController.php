<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Form\Type\Item\ItemType;
use AgnamStore\Domain\Item;

class HomeController extends MainController{
    /*     * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       All User
     * 
     * * * * * */

    public function index(Application $app) {
        $types = $app['dao.type']->findAll();
        foreach ($types as $type) {
            $lastItems[$type->getId()]['type'] = $type;
            $lastItems[$type->getId()]['item'] = $app['dao.item']->findByTypeThreeLast($type->getId());
        }
        return $this->renderView($app,'index.html.twig', array( 'lastItems' => $lastItems));
    }

    /*     * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Administration
     * 
     * * * * * */

    public function indexAdm(Application $app) {
        
        $users = $app['dao.user']->findAll();

        foreach ($types as $type) {
            $items[$type->getId()]['type'] = $type;
            $items[$type->getId()]['item'] = $app['dao.item']->findByType($type->getId());
        }
        return $this->renderView($app,'admin.html.twig', array(
                    
                    'users' => $users,
                    'itemsByType' => $items
        ));
    }
}
