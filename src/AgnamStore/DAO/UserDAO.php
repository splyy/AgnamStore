<?php

namespace AgnamStore\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use AgnamStore\Domain\User;

class UserDAO extends DAO implements UserProviderInterface {

    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id
     *
     * @return \AgnamStore\Domain\User|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from user where user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    /**
     * Returns a list of all users, sorted by role and name.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from user order by user_role, user_email";
        $result = $this->getDb()->fetchAll($sql);
// Convert query result to an array of User objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['user_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Saves a user into the database.
     *
     * @param \AgnamStore\Domain\User $user The user to save
     */
    public function save(User $user) {
        $userData = array(
            'user_email' => $user->getUsername(),
            'user_salt' => $user->getSalt(),
            'user_password' => $user->getPassword(),
            'user_role' => $user->getRole(),
            'user_firstname' => $user->getFirstName(),
            'user_lastname' => $user->getLastName(),
            'user_address' => $user->getAddress(),
            'user_city' => $user->getCity(),
            'user_cp' => $user->getCp()
        );
        if ($user->getId()) {
// The user has already been saved : update it
            $this->getDb()->update('user', $userData, array('user_id' => $user->getId()));
        } else {
// The user has never been saved : insert it
            $this->getDb()->insert('user', $userData);
// Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
    }

    /**
     * Removes an user from the database.
     *
     * @param \AgnamStore\Domain\user $user The user to remove
     */
    public function delete($id) {
// Delete the user
        $this->getDb()->delete('user', array('user_id' => $id));
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username) {
        $sql = "select * from user where user_email=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {
        return 'AgnamStore\Domain\User' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \AgnamStore\Domain\User
     */
    protected function buildDomainObject($row) {
        $user = new User();
        $user->setId($row['user_id']);
        $user->setUsername($row['user_email']);
        $user->setPassword($row['user_password']);
        $user->setSalt($row['user_salt']);
        $user->setRole($row['user_role']);
        $user->setFirstName($row['user_firstname']);
        $user->setLastName($row['user_lastname']);
        $user->setAddress($row['user_address']);
        $user->setCity($row['user_city']);
        $user->setCp($row['user_cp']);
        //$user-($row['']);
        return $user;
    }

}
