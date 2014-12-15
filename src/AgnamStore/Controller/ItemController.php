<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Form\Type\Item\ItemType;
use AgnamStore\Domain\Item;


class ItemController {

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
            $item->setType($app['dao.type']->find($item->getType()));
            $this->saveItem($item,$app);
        }
        return $app['twig']->render('item_form.html.twig', array(
                    'title' => 'New item',
                    'itemForm' => $itemForm->createView(),
                    'types' => $types
        ));
    }
    
    public function editItemAdm($id, Request $request, Application $app){
        $item = $item = $app['dao.item']->find($id);
        $item->setType($item->getType()->getId());
        $types = $app['dao.type']->findAll();
        $form = new ItemType();
        $form->setType($types);
        $itemForm = $app['form.factory']->create($form, $item);
        $itemForm->handleRequest($request);
        if ($itemForm->isValid()) {
            $item->setType($app['dao.type']->find($item->getType()));
            $this->saveItem($item,$app);
        }
        return $app['twig']->render('item_form.html.twig', array(
                    'title' => 'Edit item',
                    'itemForm' => $itemForm->createView(),
                    'types' => $types
        ));
    }
    public function delItemAdm($id, Request $request, Application $app) {
        // Delete the item
        $app['dao.item']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The item was succesfully removed.');
        return $app->redirect('/admin');
    }
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Methode
     * 
     * * * * * * * * * * */

    private function saveItem($item, Application $app) {
        try {
            $app['dao.item']->save($item);
            $app['session']->getFlashBag()->add('success', 'The item was succesfully updated.');
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }

}
