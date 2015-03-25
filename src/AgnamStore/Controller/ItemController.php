<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AgnamStore\Form\Type\Item\ItemType;
use AgnamStore\Domain\Item;


class ItemController extends MainController{

    public function itemsByType($typeId, Application $app) {
        $items = $app['dao.item']->findByType($typeId);        
        $typeG = $app['dao.type']->find($typeId);
        return $this->renderView($app,'items.html.twig', array( 'items' => $items, "typeG" => $typeG));
    }

    public function itemById($id, Application $app) {
        $item = $app['dao.item']->find($id);
        return $this->renderView($app,'item.html.twig', array('item' => $item));
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
            $this->saveItem($item,$app, 'Le produit a bien été ajouté.');
        }
        return $this->renderView($app,'item_form.html.twig', array(
                    'title' => 'Nouveau produit',
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
        return $this->renderView($app,'item_form.html.twig', array(
                    'title' => 'Editer un produit',
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
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * 
     *       Methode
     * 
     * * * * * * * * * * */

    private function saveItem($item, Application $app, $msg =  'Le produit a été mis à jour.') {
        try {
            $app['dao.item']->save($item);
            $app['session']->getFlashBag()->add('success',$msg);
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', $exc->getMessage());
        }
    }

}
