<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Form\Type\Item\ItemType;
use AgnamStore\Domain\Item;

class HomeController {
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
        return $app['twig']->render('index.html.twig', array('types' => $types, 'lastItems' => $lastItems));
    }

    /*     * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Administration
     * 
     * * * * * */

    public function indexAdm(Application $app) {
        $types = $app['dao.type']->findAll();
        $users = $app['dao.user']->findAll();

        foreach ($types as $type) {
            $items[$type->getId()]['type'] = $type;
            $items[$type->getId()]['item'] = $app['dao.item']->findByType($type->getId());
        }
        return $app['twig']->render('admin.html.twig', array(
                    'types' => $types,
                    'users' => $users,
                    'itemsByType' => $items
        ));
    }
}
