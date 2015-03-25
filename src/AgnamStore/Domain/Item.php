<?php

namespace AgnamStore\Domain;

class Item {
    /** Item id.
     * @var integer 
     * **/
    private $id;
    
    /** Item name.
     * @var string 
     * **/
    private $name;
    
    /** Sale date.
     * @var date 
     * **/
    private $saleDate;
    
    /** Item year.
     * @var integer 
     * **/
    private $year;
    
    /** Item author.
     * @var string 
     * **/
    private $author;
    
    /** Item description.
     * @var string 
     * **/
    private $description;
    
    /** Item price.
     * @var double 
     * **/
    private $price;
    
    /** Item image.
     * @var integer 
     * **/
    private $image;
    
    /** Iteam Type.
     * @var \AgnamStore\Domaine\Type 
     * **/
    private $type;
    
    /** Iteam Type.
     * @var array \AgnamStore\Domaine\Genre 
     * **/
    private $genres;
    
    public function getId() {
        return $this->id;
    }

    public function getSaleDate() {
        return $this->sale;
    }

    public function getYear() {
        return $this->year;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }
    
    public function getPriceHt() {
        return round($this->price / ( 1+ 0.20),2);
    }

    public function getImage() {
        return $this->image;
    }

    public function getType() {
        return $this->type;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSaleDate($sale) {
        $this->sale = $sale;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getName() {
        return $this->name;
    }

    public function getGenres() {
        return $this->genres;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setGenres($genres) {
        $this->genres = $genres;
    }
}
