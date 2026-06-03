<?php

namespace App\Models;

use PDO;

class Query
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertQuery($data)
    {
        $stmt = $this->pdo->prepare(
        'INSERT INTO query (user_email, category, message) 
        VALUES (?, ?, ?)'
        );
        
        $stmt->execute([
            $data['user_email'],
            $data['category'],
            $data['message']
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
