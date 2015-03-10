<?php

namespace AgnamStore\Domain;


class ItemCart{
       
    /** ItemCart $item
     * @var AgnamStore\Domain\Item 
     * **/
    private $item;
    
    /** ItemCart $cartId
     * @var integer **/
    private $cartId;
    
    /** ItemCart $qte
     * @var integer **/
    private $qte;
    
    public function getItemCartId() {
        return $this->itemCartId;
    }

    public function getItem() {
        return $this->item;
    }

    public function getCartId() {
        return $this->cartId;
    }

    public function getQte() {
        return $this->qte;
    }

    public function setItemCartId($itemCartId) {
        $this->itemCartId = $itemCartId;
    }

    public function setItem(AgnamStore\Domain\Item $item) {
        $this->item = $item;
    }

    public function setCartId($cartId) {
        $this->cartId = $cartId;
    }

    public function setQte($qte) {
        $this->qte = $qte;
    }

}
