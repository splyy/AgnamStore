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

}
