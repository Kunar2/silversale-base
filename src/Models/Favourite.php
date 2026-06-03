<?php

namespace App\Models;

use PDO;

class Favourite
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByUserId($userId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM favourite
            JOIN item 
            ON favourite.item_id = item.item_id
            WHERE user_id = ?'
        );
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertByUserId($userId, $itemId)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO favourite VALUES (?, ?)
            ON CONFLICT (user_id, item_id) DO NOTHING'
        );

        return $stmt->execute([$userId, $itemId]);
    }

    public function deleteByUserId($userId, $itemId)
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM favourite
            WHERE user_id = ? AND item_id = ?'
        );

        return $stmt->execute([$userId, $itemId]);
    }

    public function isFavourited($userId, $itemId)
    {
        $stmt = $this->pdo->prepare(
        'SELECT 1
        FROM favourite
        WHERE user_id = ? AND item_id = ?
        LIMIT 1'
    );

    $stmt->execute([$userId, $itemId]);

    return (bool) $stmt->fetchColumn();
    }



}
