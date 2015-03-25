<?php

namespace AgnamStore\Domain;

class Type {

    /** Type id.
     * @var integer 
     * * */
    private $id;

    /** Type name.
     * @var string
     * * */
    private $label;

    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

}
