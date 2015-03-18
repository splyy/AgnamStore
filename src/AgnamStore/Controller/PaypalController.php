<?php
namespace AgnamStore\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AgnamStore\Domain\ItemCart;
use AgnamStore\Payment\Paypal\Paypal;

class PaypalController extends MainController {
    public function index(Request $request,Application $app) {
        $cart = $this->getCart($app);
        //try {
            $paypal = new Paypal($app['paypal']);
            $order  = $paypal->buildPaypalShoppingCart($cart);
            $order->setUrlFail('http://localhost1/paypal/fail')
                    ->setUrlOK('http://localhost1/paypal/success')
                    ->setPaymentDescription('L\'équipe du AgnamStore vous remercie.');
            var_dump($cart);
            var_dump($order);
            $url = $paypal->create($order);
            die();
            return new RedirectResponse();
        /*} catch (\Exception $exc) {
            echo $exc->getMessage();
        }*/
    }

    public function success(Request $request, Application $app) {
        $this->_settings['metaTitle'] = 'Commande réussite';
        $paymentId = $request->get('paymentId');
        $paypal    = new Run\Payment\Paypal\Paypal($this->config->item('provider')['paypal']);
        try {
            $paypal->payementExecute($paymentId, $payerID);
            $payerPaypal          = $paypal->getPayer($paymentId);
            $payer                = $this->DAO_Model->get('Payer')->convertPaypalPayer($payerPaypal);
            $this->DAO_Model->get('Payer')->save($payer);
            $shoppingCart         = $this->_getShoppingCart();
            $this->_data['order'] = $this->DAO_Model->get('Order')->createOrder($shoppingCart, $paymentId, $payer);
            $this->DAO_Model->get('ShoppingCart')->delete($shoppingCart->getId());
            $this->DAO_Model->get('Payer')->save($payer);
            $this->dataOrder();
        } catch (\Exception $exc) {
            $this->testPayment($paypal, $paymentId);
        }
    }

    public function fail(Application $app) {
       
    }


}
