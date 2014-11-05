<?php

namespace AgnamStore\Domain;

class Item {
    /** Item id.
     * @var integer **/
    private $id;
    
    /** Sale date.
     * @var date **/
    private $saleDate;
    
    /** Item year.
     * @var integer **/
    private $year;
    
    /** Item author.
     * @var string **/
    private $author;
    
    /** Item description.
     * @var string **/
    private $description;
    
    /** Item thumbnails.
     * @var string **/
    private $thumbnails;
    
    /** Item image.
     * @var integer **/
    private $image;
    
    /** Iteam Type.
     * @var \AgnamStore\Domaine\Type **/
    private $type;
    
    /** Iteam Type.
     * @var array \AgnamStore\Domaine\Genre **/
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

    public function getThumbnails() {
        return $this->thumbnails;
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

    public function setSaleDate(date $sale) {
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

    public function setThumbnails($thumbnails) {
        $this->thumbnails = $thumbnails;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setType($type) {
        $this->type = $type;
    }


}
