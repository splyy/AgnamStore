<?php
namespace AgnamStore\Payment\Paypal;

use AgnamStore\Tools\ArrayRule;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class OrderPaypal {
    
    const CODE = '101';
    private $payer;
    private $itemList;
    private $details;
    private $amount;
    private $transaction;
    private $redirectUrls;
    private $payment;
    private $currency;

    public function getCode(){
        return self::CODE;
    }

    public function __construct($currency = 'EUR') {

        $this->setCurrency($currency);

        $this->redirectUrls = new RedirectUrls();
        $this->itemList     = new ItemList();

        $this->payer = new Payer();
        $this->payer->setPaymentMethod('paypal');

        $this->details = new Details();
        $this->details->setShipping(0);

        $this->amount = new Amount();
        $this->amount->setCurrency($this->currency);
        $this->amount->setDetails($this->details);

        $this->transaction = new Transaction();
        $this->transaction->setAmount($this->amount);
        $this->transaction->setItemList($this->itemList);
        $this->transaction->setInvoiceNumber(uniqid() . '-agnamstore');

        $this->payment = new Payment();
        $this->payment->setIntent('sale');
        $this->payment->setPayer($this->payer);
        $this->payment->setRedirectUrls($this->redirectUrls);
        $this->payment->setTransactions([$this->transaction]);
    }

    /**
     * setItem for
     * @param array $itemValues
     * @return \Run\Payement\Paypal\Paypal
     * @throws \Exception
     */
    public function setItems(array $itemValues) {
        if (!is_array($itemValues)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $itemValues is not valid (array).',(int) getCode().'01');
        }
        $shoppingCart = [];
        foreach ($itemValues as $itemValue) {
            $rules = ['name' => 'string', 'quantity' => 'numeric', 'price'=> 'numeric'];
            ArrayRule::rules($itemValue, $rules);
            $item = new Item();
            $item->setName($itemValue['name'])
                    ->setCurrency($this->getCurrency())
                    ->setQuantity($itemValue['quantity'])
                    ->setPrice($itemValue['price']);
            array_push($shoppingCart, $item);
        }
        $this->itemList->setItems($shoppingCart);
        
        return $this;
    }

    public function setShipping($shipping) {
        if (!is_numeric($shipping)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $shipping is not valid (numeric).',(int) getCode().'02');
        }
        $this->details->setShipping($shipping);
        return $this;
    }

    public function setTax($tax) {
        if (!is_numeric($tax)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $tax is not valid (numeric).',(int) getCode().'03');
        }
        $this->details->setTax($tax);
        return $this;
    }

    public function setSubtotal($subtotal) {
        if (!is_numeric($subtotal)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $subtotal is not valid (numeric).',(int) getCode().'04');
        }
        $this->details->setSubtotal($subtotal);
        return $this;
    }

    public function setCurrency($currency) {
        if (!is_string($currency)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $currency is not valid (string).',(int) getCode().'04');
        }
        $this->currency = $currency;
        return $this;
    }

    public function setTotal($total) {
        if (!is_numeric($total)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $total is not valid (numeric).',(int) getCode().'05');
        }
        $this->amount->setTotal($total);
        return $this;
    }

    public function setPaymentDescription($paymentDescription) {
        if (!is_string($paymentDescription)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $paymentDescription is not valid (string).',(int) getCode().'05');
        }
        $this->transaction->setDescription($paymentDescription);
        return $this;
    }

    public function setUrlOK($urlOK) {
        if (!is_string($urlOK)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $urlOK is not valid (string).',(int) getCode().'06');
        }
        $this->redirectUrls->setReturnUrl($urlOK);
        return $this;
    }

    public function setUrlFail($urlFail) {
        if (!is_string($urlFail)) {
            throw new \Exception( __METHOD__  , ' The format of the parameter $urlFail is not valid (string).',(int) getCode().'07');
        }
        $this->redirectUrls->setCancelUrl($urlFail);
        return $this;
    }
    
    public function getCurrency() {
        return $this->currency;
    }

    public function getPayer() {
        return $this->payer;
    }

    public function getItemList() {
        return $this->itemList;
    }

    public function getDetails() {
        return $this->details;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getTransaction() {
        return $this->transaction;
    }

    public function getRedirectUrls() {
        return $this->redirectUrls;
    }

    public function getPayment() {
        return $this->payment;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }

    public function setItemList($itemList) {
        $this->itemList = $itemList;
        return $this;
    }

    public function setDetails($details) {
        $this->details = $details;
        return $this;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    public function setTransaction($transaction) {
        $this->transaction = $transaction;
        return $this;
    }

    public function setRedirectUrls($redirectUrls) {
        $this->redirectUrls = $redirectUrls;
        return $this;
    }

    public function setPayment($payment) {
        $this->payment = $payment;
        return $this;
    }



}
