<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\ItemCart;
use AgnamStore\Domain\User;

class ItemCartDAO extends DAO {

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



    /**
     * Returns the item matching a given id.
     *
     * @param integer $id The item id.
     *
     * @return \AgnamStore\Domain\Item|throws an exception if no item is found.
     */
    private function findItemCart($userId, $itemId) {
        $sql = "select * "
                . " from line_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where user_id=? and item_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($userId, $itemId));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No item found for userId and itemId " . $id);
    }
    
    /**
     * Returns the item matching a given id.
     *
     * @param integer $id The item id.
     *
     * @return \AgnamStore\Domain\Item|throws an exception if no item is found.
     */
    private function existItemCart($userId, $itemId) {
        $sql = "select * "
                . " from line_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where user_id=? and i.item_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($userId, $itemId));

        if ($row)
            return TRUE;
        else
            return FALSE;
    }
    /* *
     * Returns the cart matching a given id.
     *
     * @param integer $id The cart id.
     *
     * @return \AgnamStore\Domain\Cart|throws an exception if no cart is found.
     */
    public function findAllItemCartByuser(User $user) {
        $sql = $sql = "select * "
                . " from line_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where user_id=?";
        
        $result = $this->getDb()->fetchAll($sql, array($user->getId()));

        $itemCarts = array();
        foreach ($result as $row) {
            $itemId = $row['item_id'];
            $itemCarts[$itemId] = $this->buildDomainObject($row,$user);
        }
        return $itemCarts;
    }

    /**
     * Creates a Item instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\ItemCart
     */
    protected function buildDomainObject($row,User $user = null) {
        $itemCart = new ItemCart();
        if ($user)
            $itemCart->setUser($user);
        else
            $itemCart->setUser($this->userDAO->find($row['user_id'])); 
        $itemCart->setQte($row['qte']);
        $item = $this->itemDAO->buildDomainObject($row);
        $itemCart->setItem($item);
        return $itemCart;
    }   


    /**
     * Saves a ItemCart into the database.
     *
     * @param \AgnamStore\Domain\ItemCart $itemCart The ItemCart to save
     */
    public function save(ItemCart $itemCart) {
        $userId = $itemCart->getUser()->getId(); 
        $itemId = $itemCart->getItem()->getId();
        $exist = $this->existItemCart($userId, $itemId);
        $itemCartData = array(
            'qte' => $itemCart->getQte()
        );
        if($exist)
            $this->getDb()->update('line_cart', $itemCartData, array('item_id' => $itemId, 'user_id' => $userId));
        else {
            $itemCartData['user_id']= $userId;
            $itemCartData['item_id']= $itemId;
            $this->getDb()->insert('line_cart', $itemCartData);
        }
        
    }

    /**
     * Removes an ItemCart from the database.
     *
     * @param \AgnamStore\Domain\ItemCart $itemCart The ItemCart to remove
     */
    public function delete(ItemCart $itemCart) {
        $userId = $itemCart->getUser()->getId(); 
        $itemId = $itemCart->getItem()->getId();
        // Delete the item
        $this->getDb()->delete('line_cart', array('item_id' => $itemId, 'user_id' => $userId));
    }
    
    /**
     * Removes an ItemCart from the database.
     *
     * @param \AgnamStore\Domain\ItemCart $itemCart The ItemCart to remove
     */
    public function deleteUserItemCart(User $user) {
        $userId = $user->getId(); 
        // Delete the item
        $this->getDb()->delete('line_cart', array('user_id' => $userId));
    }

    

}
