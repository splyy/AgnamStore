<?php

namespace AgnamStore\Domain;

class Cart {
     /** ShoppingCart id.
     * @var integer 
     * * */
    private $id;

    /** ShoppingCart id.
     * @var integer 
     * * */
    private $userId;

    /** ShoppingCart id.
     * @var DateTime 
     * * */
    private $dateCreate;

    /** ShoppingCart id.
     * @var array 
     * * */
    private $items;
    
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getDateCreate() {
        return $this->dateCreate;
    }

    public function getItems() {
        return $this->items;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function setDateCreate($dateCreate) {
        $this->dateCreate = $dateCreate;
        return $this;
    }

    public function setItems($items) {
        $this->items = $items;
        return $this;
    }


}
