<?php

namespace AgnamStore\DAO;

use AgnamStore\Domain\Genre;

class GenreDAO extends DAO {

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
     * Returns all genre of one item.
     *
     * @param integer $id The item id.
     *
     * @return List of \AgnamStore\Domain\Genre.
     */
    public function findAllGenreForItem($itemId) {
        $sql = "select ig.* from item_genre ig join possede_genre pg on ig.item_genre_id = pg.item_genre_id where pg.item_id=? order by ig.item_genre_label";
        $result = $this->getDb()->fetchAll($sql, array($itemId));

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
     * @return \AgnamStore\Domain\Genre|throws an exception if no genre is found.
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
     * @return \AgnamStore\Domain\Genre
     */
    protected function buildDomainObject($row) {
        $genre = new Genre();
        $genre->setId($row['item_genre_id']);
        $genre->setName($row['item_genre_label']);
        return $genre;
    }

}
