<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Item;

class ItemDAO extends DAO {

    /**
     * @var \AgnamStore\DAO\GenreDAO
     */
    private $genreDAO;

    public function setGenreDAO($genreDAO) {
        $this->genreDAO = $genreDAO;
    }

    /**
     * @var \AgnamStore\DAO\TypeDAO
     */
    private $typeDAO;

    public function setTypeDAO($typeDAO) {
        $this->typeDAO = $typeDAO;
    }

    /**
     * Returns the list of all item, sorted by name.
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

    /**
     * Returns the list of all item matching by type id sorted by name.
     *
     * @param integer $typeId The type id. 
     * 
     * @return array The list of all items.
     */
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

    // Attention ne pas oublier de remplacer par sale_date lorsque les date de vente seront mise en place
    /**
     * Returns the list of three last item matching by type id .
     *
     * @param integer $typeId The type id. 
     * 
     * @return array The list of items.
     */
    public function findByTypeThreeLast($typeId) {
        $sql = "select * from item where item_type_id=? order by item_id limit 3";
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
     * Saves a item into the database.
     *
     * @param \AgnamStore\Domain\Item $item The item to save
     */
    public function save(Item $item, $option = null) {
        $itemData = array(
            'price' => $item->getPrice(),
            'name' => $item->getName(),
            'sale_date' => $item->getSaleDate(),
            'year' => $item->getYear(),
            'author' => $item->getAuthor(),
            'description' => $item->getDescription(),
            'image' => $item->getImage(),
            'item_type_id' => $item->getType()->getId(),
        );
        if ($item->getId()) {
            // The item has already been saved : update it
            $this->getDb()->update('item', $itemData, array('item_id' => $item->getId()));
        } else {
            // The item has never been saved : insert it
            $this->getDb()->insert('item', $itemData);
            // Get the id of the newly created item and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $item->setId($id);
        }
    }

    /**
     * Removes an item from the database.
     *
     * @param \AgnamStore\Domain\Item $item The item to remove
     */
    public function delete($id) {
        // Delete the item
        $this->getDb()->delete('item', array('item_id' => $id));
    }

    /**
     * Creates a Item instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\Item
     */
    public function buildDomainObject($row) {
        $item = new Item();
        $type = $this->typeDAO->find($row['item_type_id']);
        //$genres = $this->genreDAO->findAllGenreForItem($row['item_id']);
        $item->setId($row['item_id']);
        $item->setSaleDate($row['sale_date']);
        $item->setYear($row['year']);
        $item->setAuthor($row['author']);
        $item->setDescription($row['description']);
        $item->setPrice($row['price']);
        $item->setImage($row['image']);
        $item->setType($type);
        $item->setName($row['name']);
        return $item;
    }

}
