<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ItemController {

    public function index(Application $app) {
        $types = $app['dao.type']->findAll();
        foreach($types as $type){
            $lastItems[$type->getId()]['type']=$type;
            $lastItems[$type->getId()]['item']= $app['dao.item']->findByTypeThreeLast($type->getId());
        }
        return $app['twig']->render('index.html.twig', array('types' => $types, 'lastItems'=> $lastItems));
    }

    public function itemsByType($typeId, Application $app) {
        $items = $app['dao.item']->findByType($typeId);
        $types = $app['dao.type']->findAll();
        $typeG = $app['dao.type']->find($typeId);
        return $app['twig']->render('items.html.twig', array('types' => $types, 'items' => $items, "typeG" => $typeG));
    }

    public function itemById($id, Application $app) {
        $item = $app['dao.item']->find($id);
        $types = $app['dao.type']->findAll();
        return $app['twig']->render('item.html.twig', array('item' => $item, 'types' => $types));
    }

}
