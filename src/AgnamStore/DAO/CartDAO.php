<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Cart;
use AgnamStore\Domain\ItemCart;
use AgnamStore\Domain\User;

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

    /*     *
     * Returns the cart matching a given id.
     *
     * @param integer $id The cart id.
     *
     * @return \AgnamStore\Domain\Cart|throws an exception if no cart is found.
     */

    public function find($id) {
        $sql = "select * from cart where cart_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No cart found for id " . $id);
    }

    /*     *
     * Returns the cart matching a given id.
     *
     * @param integer $id The cart id.
     *
     * @return \AgnamStore\Domain\Cart|throws an exception if no cart is found.
     */

    public function findByUser(User $user) {
        $sql = "select * "
                . " from cart"
                . " where user_id=?"
                . " order by cart_id desc"
                . " limit 0,1";
        $row = $this->getDb()->fetchAssoc($sql, array($user->getId()));

        if ($row)
            return $this->buildDomainObject($row, $user);
        else
            throw new \Exception("No cart found for user id " . $user->getId());
    }

    /*     *
     * Saves a Cart into the database.
     *
     * @param 
     * +\AgnamStore\Domain\Cart $cart The Cart to save
     */

    public function save(Cart $cart) {
        $datetimeNow = new \DateTime();
        $datetimeNow = $datetimeNow->format('Y-m-d H:i:s');
        $cartData = array(
            'user_id' => $cart->getUser()->getId(),
            'date_update' => $datetimeNow
        );
        if ($cart->getId()) {
            // The item has already been saved : update it
            $this->getDb()->update('cart', $cartData, array('cart_id' => $cart->getId()));
        } else {
            $cartData['date_creation'] = $datetimeNow;
            // The item has never been saved : insert it
            $this->getDb()->insert('cart', $cartData);
            // Get the id of the newly created item and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $cart->setId($id);
        }
    }
    
    /**
     * Removes an Cart from the database.
     *
     * @param \AgnamStore\Domain\ItemCart $itemCart The ItemCart to remove
     */
    public function delete(Cart $cart) {
        $this->getDb()->delete('item_cart', array('cart_id' => $itemCart->getCartId()));
        $this->getDb()->delete('cart', array('cart_id' => $itemCart->getItem->getId(), 'cart_id' => $itemCart->getCartId()));
    }

    /**
     * Creates a Cart instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\Cart
     */
    protected function buildDomainObject($row, User $user = null) {
        $cart = new Cart();
        $cart->setId($row['cart_id']);
        if ($user)
            $cart->setUser($user);
        else
            $cart->setUser($this->userDAO->find($row['user_id']));

        $cart->setDateCreate($row['date_creation']);
        $cart->setDateUpdate($row['date_update']);
        $cart->setItems($this->findAllItemCart($row['cart_id']));
        return $cart;
    }

    /**
     * Returns the list of all item, sorted by name.
     *
     * @return array The list of all items.
     */
    public function findAllItemCart($cartId) {
        $sql = "select * "
                . " from item_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where cart_id=? order by name";
        $result = $this->getDb()->fetchAll($sql, array($cartId));

        // Converts query result to an array of domain objects
        $itemCarts = array();
        foreach ($result as $row) {
            $itemCarts[] = $this->buildItemCart($row);
        }
        return $itemCarts;
    }

    /**
     * Returns the item matching a given id.
     *
     * @param integer $id The item id.
     *
     * @return \AgnamStore\Domain\Item|throws an exception if no item is found.
     */
    private function findItemCart($cartId, $itemId) {
        $sql = "select * "
                . " from item_cart ic join item i"
                . " on i.item_id = ic.item_id"
                . " where cart_id=? and item_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($cartId, $itemId));

        if ($row)
            return $this->buildItemCart($row);
        else
            throw new \Exception("No item found for id " . $id);
    }

    public function addItemCart($cartId, $itemId, $qte = 1) {
        $itemCartData = array(
            'qte' => $item->getQte(),
            'cart_id' => $cartId,
            'item_id' => $itemId,
        );
        $this->getDb()->insert('item', $itemCartData);
    }

    /**
     * Saves a ItemCart into the database.
     *
     * @param \AgnamStore\Domain\ItemCart $itemCart The ItemCart to save
     */
    public function saveItemCart(ItemCart $itemCart) {
        $itemCartData = array(
            'qte' => $item->getQte()
        );
        $this->getDb()->update('item', $itemCartData, array('item_id' => $itemCart->getItem->getId(), 'cart_id' => $itemCart->getCartId()));
    }

    /**
     * Removes an ItemCart from the database.
     *
     * @param \AgnamStore\Domain\ItemCart $itemCart The ItemCart to remove
     */
    public function deleteItemCart(ItemCart $itemCart) {
        // Delete the item
        $this->getDb()->delete('item_cart', array('item_id' => $itemCart->getItem->getId(), 'cart_id' => $itemCart->getCartId()));
    }

    /**
     * Creates a Item instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\ItemCart
     */
    protected function buildItemCart($row) {
        $itemCart = new ItemCart();
        $itemCart->setQte($row['qte']);
        $item = $this->itemDAO->buildDomainObject($row);
        $itemCart->setItem($item);
        return $itemCart;
    }

}
