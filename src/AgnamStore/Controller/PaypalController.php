<?php

namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AgnamStore\Domain\ItemCart;
use AgnamStore\Payment\Paypal\Paypal;

class PaypalController extends MainController {

    public function index(Request $request, Application $app) {
        $cart = $this->getCart($app);
        //try {
        $paypal = new Paypal($app['paypal']);
        $order = $paypal->buildPaypalShoppingCart($cart);
        
        
        $order->setUrlFail('http://'.$request->getHost().'/paypal/fail')
                ->setUrlOK('http://'.$request->getHost().'/paypal/success')
                ->setPaymentDescription('L\'équipe du AgnamStore vous remercie.');
        $url = $paypal->create($order);
        return new RedirectResponse($url);
        /* } catch (\Exception $exc) {
          echo $exc->getMessage();
          } */
    }

    public function success(Request $request, Application $app) {
        $paymentId = $request->get('paymentId');
        $payerID = $request->get('PayerID');
        $paypal = new Paypal($app['paypal']);
        
        try {
            var_dump($paypal->getPayement($paymentId));
            $paypal->payementExecute($paymentId, $payerID);
            var_dump($paypal->getPayement($paymentId));
            $payerPaypal = $paypal->getPayer($paymentId);
            var_dump($payerPaypal);
            die();
        } catch (\Exception $exc) {
            var_dump($exc);
        }
    }

    public function fail(Application $app) {
        
    }

}
