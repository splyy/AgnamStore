<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Type;

class TypeDAO extends DAO {

    /**
     * Returns the list of all type, sorted by name and first name.
     *
     * @return array The list of all types.
     */
    public function findAll() {
        $sql = "select * from item_type order by type_label";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $types = array();
        foreach ($result as $row) {
            $typeId = $row['item_type_id'];
            $types[$typeId] = $this->buildDomainObject($row);
        }
        return $types;
    }

    /**
     * Returns the type matching a given id.
     *
     * @param integer $id The type id.
     *
     * @return \AgnamStore\Domain\Type|throws an exception if no type is found.
     */
    public function find($id) {
        $sql = "select * from item_type where item_type_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No type found for id " . $id);
    }

    /**
     * Creates a Type instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \AgnamStore\Domain\Type
     */
    protected function buildDomainObject($row) {
        $type = new Type();
        $type->setId($row['item_type_id']);
        $type->setLabel($row['type_label']);
        return $type;
    }

}
