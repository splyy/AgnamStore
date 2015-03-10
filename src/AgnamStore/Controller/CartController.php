<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Domain\Cart;


class CartController {

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
    
    public function cart(Application $app){
        $types = $app['dao.type']->findAll();
        return $app['twig']->render('cart.html.twig',array('types'=> $types));
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Administration
     * 
     * * * * * */
 
    public function addItemAdm( Request $request, Application $app){
        $item = new Item();
        $types = $app['dao.type']->findAll();
        $form = new ItemType();
        $form->setType($types);
        $itemForm = $app['form.factory']->create($form, $item);        
        $itemForm->handleRequest($request);
        if ($itemForm->isValid()) {
            // TODO Mettre date actuel
            $item->setSaleDate('0000-00-00');
            //TODO GESTION des genre
            $item->setType($app['dao.type']->find($item->getType()));
            $this->saveItem($item,$app);
        }
        return $app['twig']->render('item_form.html.twig', array(
                    'title' => 'Nouveau produit',
                    'itemForm' => $itemForm->createView(),
                    'types' => $types
        ));
    }

    public function delItemAdm($id, Request $request, Application $app) {
        // Delete the item
        $app['dao.item']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le produit a été supprimé.');
        return $app->redirect('/admin');
    }
}
