<?php

namespace AgnamStore\Domain;

class Cart {
     /** ShoppingCart id.
     * @var integer 
     * * */
    private $id;

    /** ShoppingCart $dateCreate.
     * @var DateTime 
     * * */
    private $dateCreate;
    
    /** ShoppingCart $user.
     * @var AgnamStore\Domain\User 
     * * */
    private $user;

    /** ShoppingCart $dateUpdate.
     * @var DateTime 
     * * */
    private $dateUpdate;

    /** ShoppingCart $items.
     * @var array 
     * * */
    private $items;
    
    public function getId() {
        return $this->id;
    }

    public function getDateCreate() {
        return $this->dateCreate;
    }

    public function getItems() {
        return $this->items;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDateCreate($dateCreate) {
        $this->dateCreate = $dateCreate;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function getUser() {
        return $this->user;
    }

    public function getDateUpdate() {
        return $this->dateUpdate;
    }

    public function setUser(AgnamStore\Domain\User $user) {
        $this->user = $user;
        return $this;
    }

    public function setDateUpdate(DateTime $dateUpdate) {
        $this->dateUpdate = $dateUpdate;
        return $this;
    }
}
