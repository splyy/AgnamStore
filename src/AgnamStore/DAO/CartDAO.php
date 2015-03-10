<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Cart;
use AgnamStore\Domain\ItemCart;

class CartDAO extends DAO {

    /**
     * @var \AgnamStore\DAO\ItemDAO
     */
    private $itemDAO;
    
    /**
     * @var \AgnamStore\DAO\UserDAO
     */
    private $userDAO;
    
    public function setItemDAO($itemDAO) {
        $this->itemDAO = $itemDAO;
    }

    public function setUserDAO($userDAO) {
        $this->userDAO = $userDAO;
    }

        
    /* *
     * Returns the cart matching a given id.
     *
     * @param integer $id The cart id.
     *
     * @return \AgnamStore\Domain\Cart|throws an exception if no cart is found.
     */
    public function find($id) {
        $sql = "select * from item_cart where cart_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No cart found for id " . $id);
    }
    
    /* *
     * Returns the cart matching a given id.
     *
     * @param integer $id The cart id.
     *
     * @return \AgnamStore\Domain\Cart|throws an exception if no cart is found.
     */
    public function findByUser($userId) {
        $sql = "select * from item_cart where user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($userId));
        
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No cart found for user id " . $userId);
    }
    
    /**
     * Creates a Cart instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\Cart
     */
    protected function buildDomainObject($row) {
        $cart = new Cart();
        $cart->setId($row['cart_id']);
        $cart->setUser($this->userDAO->find($row['user_id']));
        $cart->setDateCreate($row['date_creation']);
        $cart->setItems($this->findAllItemCart($row['cart_id']));
        return $cart;
    }
    
    /**
     * Returns the list of all item, sorted by name.
     *
     * @return array The list of all items.
     */
    public function findAllItem($cartId) {
        $sql = "select * "
                . " from item_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where cart_id=? order by name";
        $result = $this->getDb()->fetchAll($sql,array($cartId));

        // Converts query result to an array of domain objects
        $itemCarts = array();
        foreach ($result as $row) {
            $itemCarts[] = $this->buildItemCart($row);
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
    private function findItemCart($cartId,$itemId) {
        $sql = "select * "
                . " from item_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where cart_id=? and item_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($cartId,$itemId));

        if ($row)
            return $this->buildItemCart($row);
        else
            throw new \Exception("No item found for id " . $id);
    }


    /**
     * Saves a item into the database.
     *
     * @param \AgnamStore\Domain\Item $item The item to save
     */
    public function save(ItemCart $item) {
        $itemData = array(
            'qte' => $item->getQte()
        );
        if ($item->getId()) {
            // The item has already been saved : update it
            $this->getDb()->update('item', $itemData, array('item_id' => $item->getId()));
        } else {
            $itemData['cart_id'] = $item->setCartId($cartId);
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
    protected function buildItemCart($row) {
       
        $itemCart = new ItemCart();
        $itemCart->setQte($row['qte']);
        $item = $this->itemDAO->buildDomainObject($row);
        $itemCart->setItem($item);
        return $itemCart;
    }


}
