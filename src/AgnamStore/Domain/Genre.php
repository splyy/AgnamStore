<?php

namespace AgnamStore\Domain;

class Genre {
    /** Type id.
     * @var integer 
     * **/
    private $id;
    
    /** Type name.
     * @var string 
     * **/
    private $name;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }
}