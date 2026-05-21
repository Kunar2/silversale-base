<?php

namespace App\Models;

use PDO;

class Item
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM silversale.item');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT silversale.item.*, 
            silversale.category.name AS category
            FROM silversale.item
            JOIN silversale.category
            ON silversale.item.category_id = silversale.category.category_id 
            WHERE item_id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInventoryByItemId($id)
    {
        $stmt = $this->pdo->prepare(
        "SELECT * FROM silversale.inventory WHERE item_id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPopularItems($itemLimit)
    {
        $stmt = $this->pdo->prepare("
            SELECT *,
                (rating * reviews) AS popularity
            FROM silversale.item
            ORDER BY popularity DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $itemLimit, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPopularCategories($itemLimit)
    {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT ON (c.category_id)
                c.category_id,
                c.name,
                i.*,
                (i.rating * i.reviews) AS popularity
            FROM silversale.category c
            JOIN silversale.item i
                ON c.category_id = i.category_id
            ORDER BY
                c.category_id,
                popularity DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $itemLimit, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRecentItems($itemLimit)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM silversale.item
            ORDER BY reviews ASC
            LIMIT ?
        ");

        $stmt->bindValue(1, $itemLimit, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
