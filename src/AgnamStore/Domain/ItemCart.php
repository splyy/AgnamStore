<?php

namespace AgnamStore\Domain;

class ItemCart {

    /** ItemCart $item
     * @var AgnamStore\Domain\Item
     * * */
    private $item;

    /** ItemCart $user
     * @var AgnamStore\Domain\User * */
    private $user;

    /** ItemCart $qte
     * @var integer * */
    private $qte;

    public function getItem() {
        return $this->item;
    }

    public function getUser() {
        return $this->user;
    }

    public function getQte() {
        return $this->qte;
    }

    public function setItem( $item) {
        $this->item = $item;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setQte($qte) {
        $this->qte = $qte;
        return $this;
    }

     public function getPaypalArray(){
        return ['name' => $this->item->getName(), 'quantity' => $this->qte, 'price' => $this->item->getPrice()];
    }


}
