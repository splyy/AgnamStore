<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AgnamStore\Domain\ItemCart;

class CartController extends MainController {

    public function index(Application $app) {
        $cart = $this->getCart($app);
        return $this->renderView($app, 'cart.html.twig', array('cart' => $cart));
    }

    public function add($id, Request $request, Application $app) {
        try {
            $cart = $this->getCart($app);
            $notFound = TRUE;
            foreach ($cart as $itemCart) {
                if ($itemCart->getItem()->getid() === $id)
                    $notFound = FALSE;
            }
            if ($notFound) {
                $itemCart = new ItemCart();
                $itemCart->setUser($this->getUserClient($app));
                $itemCart->setItem($app['dao.item']->find($id));
                $itemCart->setQte(1);
                $app['dao.itemCart']->save($itemCart);
            }
            $app['session']->getFlashBag()->add('success', "Produit ajouter au panier");
        } catch (\Exception $exc) {
            var_dump($exc);
            $app['session']->getFlashBag()->add('error', 'Une erreur c\'est produit lors de l\'ajout du produit au panier');
        }
        return new RedirectResponse($request->getBaseUrl() . '/cart');
    }

    public function edit($id, Request $request, Application $app) {
        try {
            $cart = $this->getCart($app);
            $qte = $request->get('qte');
            $itemCarts = $cart->getItems();
            $itemCartFound = null;
            foreach ($itemCarts as $itemCart) {
                if ($itemCart->getItem()->getid() == $id) {
                    $itemCartFound = $itemCart;
                    $itemCartFound->setQte($qte);
                }
            }
            if ($notFound) {
                $app['dao.itemCart']->addItemCart($cart->getId(), $id);
            }
            $app['session']->getFlashBag()->add('success', "Quantité modifier");
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', 'Une erreur c\'est produit lors de la modification de la quantité du produit');
        }
        return new RedirectResponse($request->getBaseUrl() . '/cart');
    }

    public function del($id, Request $request, Application $app) {
        try {
            $cart = $this->getCart($app);
            foreach ($cart as $itemCart){
                if ($itemCart->getItem()->getid() == $id) {
                    $app['dao.itemCart']->deleteItemCart($itemCart);
                    $app['session']->getFlashBag()->add('success', "Produit supprimer");
                }
            }            
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', 'Une erreur c\'est produit lors de la suppresion du produit');
        }

        return new RedirectResponse($request->getBaseUrl() . '/cart');
    }

    private function getCart($app) {
        $user = $this->getUserClient($app);
        $cart = $app['dao.itemCart']->findAllItemCartByuser($user);
        return $cart;
    }

}
