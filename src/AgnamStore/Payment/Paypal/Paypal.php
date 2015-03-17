<?php

namespace Run\Payment\Paypal;

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Run\Payment\Paypal\OrderPaypal;
use Run\Domain\ShoppingCart;

class Paypal {

    const CODE = '100';

    private $paypalValuesKeys;

    public function __construct(Array $config) {
        $this->setPaypalValuesKeys($config);
    }

    public function getCode() {
        return self::CODE;
    }

    public function setPaypalValuesKeys($paypalValues) {
        if (is_array($paypalValues)) {
            $this->paypalValuesKeys = $paypalValues;
            return $this;
        } else {
            throw new \Exception('$paypalValues is not an array() !');
        }
    }

    public function getPaypalValuesKeys() {
        return $this->paypalValuesKeys;
    }

    private function getApiContext() {
        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                $this->getPaypalValuesKeys()['settings.paypal.api.id'], // ClientID
                $this->getPaypalValuesKeys()['settings.paypal.api.secret'] // ClientSecret
        ));

        $apiContext->setConfig([
            'mode'                   => $this->getPaypalValuesKeys()['settings.paypal.mode'],
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled'         => true,
            'log.FileName'           => realpath(APPPATH . '/logs/paypal/PayPal.log'),
            'log.LogLevel'           => 'FINE'
        ]);
        return $apiContext;
    }

    /**
     * Create a order with shoppingCart
     * @param type $shoppingCart
     */
    public function buildPaypalShoppingCart(ShoppingCart $shoppingCart) {
        $order = new OrderPaypal();
        $tax   = $shoppingCart->getPriceTaxe();
        $ttc   = $shoppingCart->getPriceTTC();
        $ht    = $shoppingCart->getPriceHT();
        $items = $shoppingCart->getPaypalArray();
        $order->setItems($items)
                ->setTax($tax)
                ->setSubtotal($ht)
                ->setTotal($ttc);

        return $order;
    }

    /**
     * Create a payement and return the url payment
     * @param type $order
     * @return string
     * @throws \Run\Exception\Exception
     */
    public function create($order) {
        try {
            $apiContext  = $this->getApiContext();
            $paymant     = $order->getPayment();
            $paymant->create($apiContext);
            $approvalUrl = $paymant->getApprovalLink();
            return $approvalUrl;
        } catch (\Exception $exc) {
            $dataException = null;
            if ($exc->getData()) {
                $dataException = json_decode($exc->getData());
            }
            log_message('error', __METHOD__ . '->apiContext : ' . $exc->getMessage());
            throw new \Run\Exception\Exception('Impossible de crée un payement pour la commande', $dataException, 1);
        }
    }

    /**
     * Execute Payement
     * @param type $paymentId
     * @param type $payerId
     * @throws \Run\Exception\Exception
     */
    public function payementExecute($paymentId, $payerId) {
        try {
            $apiContext = $this->getApiContext();
            $payment    = Payment::get($paymentId, $apiContext);
            $execution  = new PaymentExecution();
            $execution->setPayerId($payerId);
            $payment->execute($execution, $apiContext);
        } catch (\Exception $exc) {
            $dataException = null;
            if ($exc->getData()) {
                $dataException = json_decode($exc->getData());
            }
            log_message('error', __METHOD__ . '->apiContext : ' . $exc->getMessage());
            throw new \Run\Exception\Exception(__METHOD__, ' Impossible de créer un payement pour la commande', $dataException, (int) $this->getCode() . '03');
        }
    }

    /**
     * get Payer of payment
     * @param type $paymentId
     * @return type
     * @throws \Run\Exception\Exception
     */
    public function getPayer($paymentId) {
        try {
            $apiContext = $this->getApiContext();
            $payment    = Payment::get($paymentId, $apiContext);
            return $payment->getPayer();
        } catch (\Exception $exc) {
            $dataException = null;
            if ($exc->getData()) {
                $dataException = json_decode($exc->getData());
            }
            log_message('error', __METHOD__ . '->apiContext : ' . $exc->getMessage());
            throw new \Run\Exception\Exception(__METHOD__, 'Impossible d\'obtenir le payeur', $dataException, $this->getCode() . '03');
        }
    }

    /**
     * get payment by id
     * @param type $paymentId
     * @return type
     * @throws \Run\Exception\Exception
     */
    public function getPayement($paymentId) {
        try {
            $apiContext = $this->getApiContext();
            return $payment    = Payment::get($paymentId, $apiContext);
        } catch (\Exception $exc) {
            $dataException = null;
            if (method_exists($exc, 'getData')) {
                $dataException = json_decode($exc->getData());
            }
            throw new \Run\Exception\Exception(__METHOD__, 'Impossible d\'obtenir le payement de la commande', $dataException, $this->getCode() . '03');
        }
    }

}
