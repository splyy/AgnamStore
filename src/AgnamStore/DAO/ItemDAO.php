<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Item;

class ItemDAO {
    
    
    /**
     * Returns the list of all item, sorted by name and first name.
     *
     * @return array The list of all items.
     */
    public function findAll() {
        $sql = "select * from item order by item_label";
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
     * Returns the item matching a given id.
     *
     * @param integer $id The item id.
     *
     * @return \GSB\Domain\Item|throws an exception if no item is found.
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
     * @return \GSB\Domain\Item
     */
    protected function buildDomainObject($row) {
        
        $item = new Item();
        $item->setId($row['item_id']);
        $item->setSaleDate($row['item_sale_date']);
        $item->setYear($row['year']);
        $item->setAuthor($row['author']);
        $item->setDescription($row['description ']);
        $item->setThumbnails($row['thumbnails ']);
        $item->setImage($row['image']);
        $item->setType();
        $item->setGenres();
        return $item;
    }
}