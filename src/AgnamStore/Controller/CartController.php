<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AgnamStore\Domain\Cart;

class CartController extends MainController {

    public function index(Application $app) {
        $types = $app['dao.type']->findAll();
        $cart = $this->getCart($app);
        var_dump($cart);
        return $app['twig']->render('cart.html.twig', array('types' => $types,'cart' => $cart));
    }

    public function add($id, Request $request, Application $app) {
        try {
            $cart = $this->getCart($app);
            $itemCarts = $cart->getItems();
            $notFound = TRUE;
            foreach ($itemCarts as $itemCart) {
                if ($itemCart->getItem()->getid() === $id)
                    $notFound = FALSE;
            }
            if ($notFound) {
                $app['dao.cart']->addItemCart($cart->getId(), $id);
            }
            $app['session']->getFlashBag()->add('success', "Produit ajouter au panier");
        } catch (\Exception $exc) {
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
                $app['dao.cart']->addItemCart($cart->getId(), $id);
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
            $itemCarts = $cart->getItems();
            $found = FALSE;
            foreach ($itemCarts as $itemCart) {
                if ($itemCart->getItem()->getid() === $id)
                    $found = TRUE;
            }
            if ($found) {
                $app['dao.cart']->deleteItemCart($cart->getId(), $id);
            }
            $app['session']->getFlashBag()->add('success', "Produit supprimer");
        } catch (\Exception $exc) {
            $app['session']->getFlashBag()->add('error', 'Une erreur c\'est produit lors de la suppresion du produit');
        }

        return new RedirectResponse($request->getBaseUrl() . '/cart');
    }

    private function getCart($app) {
        $user = $this->getUserClient($app);
        try {
            $cart = $app['dao.cart']->findByUser($user);
        } catch (\Exception $exc) {
            var_dump($exc);
            $cart = new Cart();
            $cart->setUser($user);
            $app['dao.cart']->save($cart);
        }        
        return $cart;
    }

}
