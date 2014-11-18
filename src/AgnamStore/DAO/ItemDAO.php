<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Item;

class ItemDAO extends DAO {

    /**
     * @var \AgnamStore\DAO\PractitionerTypeDAO
     */
    private $genreDAO;

    public function setGenreDAO($genreDAO) {
        $this->genreDAO = $genreDAO;
    }

    /**
     * @var \AgnamStore\DAO\PractitionerTypeDAO
     */
    private $typeDAO;

    public function setTypeDAO($typeDAO) {
        $this->typeDAO = $typeDAO;
    }

    /**
     * Returns the list of all item, sorted by name and first name.
     *
     * @return array The list of all items.
     */
    public function findAll() {
        $sql = "select * from item order by name";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $items = array();
        foreach ($result as $row) {
            $itemId = $row['item_id'];
            $items[$itemId] = $this->buildDomainObject($row);
        }
        return $items;
    }
    
    public function findByType($typeId) {
        $sql = "select * from item where item_type_id=? order by name";
        $result = $this->getDb()->fetchAll($sql, array($typeId));

        // Converts query result to an array of domain objects
        $items = array();
        foreach ($result as $row) {
            $itemId = $row['item_id'];
            $items[$itemId] = $this->buildDomainObject($row);
        }
        return $items;
    }
    /**
     * Returns the item matching a given id.
     *
     * @param integer $id The item id.
     *
     * @return \AgnamStore\Domain\Item|throws an exception if no item is found.
     */
    public function find($id) {
        $sql = "select * from item where item_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No item found for id " . $id);
    }

    /**
     * Creates a Item instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\Item
     */
    protected function buildDomainObject($row) {
        $item = new Item();
        $type = $this->typeDAO->find($row['item_type_id']);
        //$genres = $this->genreDAO->findAllGenreForItem($row['item_id']);
        $item->setId($row['item_id']);
        $item->setSaleDate($row['sale_date']);
        $item->setYear($row['year']);
        $item->setAuthor($row['author']);
        $item->setDescription($row['description']);
       // $item->setPrice($row['price']);
        $item->setImage($row['image']);
        $item->setType($type);
        //$item->setGenres($genres);
        $item->setName($row['name']);
        return $item;
    }

}
