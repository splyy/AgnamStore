<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Genre;

class GenreDAO {
    /**
     * Returns the list of all genre, sorted by name and first name.
     *
     * @return array The list of all practitioners.
     */
    public function findAll() {
        $sql = "select * from genre order by label";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $practitioners = array();
        foreach ($result as $row) {
            $practitionerId = $row['practitioner_id'];
            $practitioners[$practitionerId] = $this->buildDomainObject($row);
        }
        return $practitioners;
    }

    /**
     * Returns the list of all practitioners for a given type, sorted by name and first name.
     *
     * @param integer $typeId The practitioner type id.
     *
     * @return array The list of practitioners.
     */
    public function findAllByType($typeId) {
        $sql = "select * from practitioner where practitioner_type_id=? order by practitioner_name, practitioner_first_name";
        $result = $this->getDb()->fetchAll($sql, array($typeId));
        
        // Convert query result to an array of domain objects
        $practitioners = array();
        foreach ($result as $row) {
            $practitionerId = $row['practitioner_id'];
            $practitioners[$practitionerId] = $this->buildDomainObject($row);
        }
        return $practitioners;
    }

    /**
     * Returns the list of all practitioners matching a name and/or a city, sorted by name and first name.
     *
     * @param string $name The name.
     * @param string $city The city.
     *
     * @return array The list of practitioners.
     */
    public function findAllByNameAndCity($name, $city) {
        $sql = "select * from practitioner where practitioner_name like ? and practitioner_city like ? 
            order by practitioner_name, practitioner_first_name";
        // If $name and $city are undefined, the SQL query returns all names (%%) and all cities (%%)
        $result = $this->getDb()->fetchAll($sql, array('%' . $name . '%', '%' . $city . '%'));
        
        // Convert query result to an array of domain objects
        $practitioners = array();
        foreach ($result as $row) {
            $practitionerId = $row['practitioner_id'];
            $practitioners[$practitionerId] = $this->buildDomainObject($row);
        }
        return $practitioners;
    }

    /**
     * Returns the practitioner matching a given id.
     *
     * @param integer $id The practitioner id.
     *
     * @return \GSB\Domain\Practitioner|throws an exception if no practitioner is found.
     */
    public function find($id) {
        $sql = "select * from practitioner where practitioner_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No Practitioner found for id " . $id);
    }

    /**
     * Creates a Practitioner instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Practitioner
     */
    protected function buildDomainObject($row) {
        $typeId = $row['practitioner_type_id'];
        $type = $this->practitionerTypeDAO->find($typeId);

        $practitioner = new Practitioner();
        $practitioner->setId($row['practitioner_id']);
        $practitioner->setName($row['practitioner_name']);
        $practitioner->setFirstName($row['practitioner_first_name']);
        $practitioner->setAddress($row['practitioner_address']);
        $practitioner->setZipCode($row['practitioner_zip_code']);
        $practitioner->setCity($row['practitioner_city']);
        $practitioner->setNotorietyCoefficient($row['notoriety_coefficient']);
        $practitioner->setType($type);
        return $practitioner;
    }
}
