<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Genre;

class GenreDAO {
    /**
     * Returns the list of all genre, sorted by name and first name.
     *
     * @return array The list of all genres.
     */
    public function findAll() {
        $sql = "select * from item_genre order by item_genre_label";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $genres = array();
        foreach ($result as $row) {
            $genreId = $row['item_genre_id'];
            $genres[$genreId] = $this->buildDomainObject($row);
        }
        return $genres;
    }

    /**
     * Returns the genre matching a given id.
     *
     * @param integer $id The genre id.
     *
     * @return \GSB\Domain\Genre|throws an exception if no genre is found.
     */
    public function find($id) {
        $sql = "select * from item_genre where item_genre_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No genre found for id " . $id);
    }

    /**
     * Creates a Genre instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Genre
     */
    protected function buildDomainObject($row) {
        $genre = new Genre();
        $genre->setId($row['item_genre_id']);
        $genre->setLabel($row['item_genre_label']);
        return $genre;
    }
}
