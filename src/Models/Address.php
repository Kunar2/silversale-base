<?php

namespace App\Models;

use PDO;

class Address
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAddressAccount($userId)
    {
        $stmt = $this->pdo->prepare(
        'SELECT * FROM user_address
        WHERE user_id = ?'
        );
            
        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAddressCheckout($userId)
    {
        if ($this->hasAutofill($userId))
        {
            $stmt = $this->pdo->prepare(
            'SELECT * FROM user_address
            WHERE user_id = ?'
            );
                
            $stmt->execute([$userId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function hasAutofill($userId)
    {
        $stmt = $this->pdo->prepare(
        'SELECT 1
        FROM user_address
        WHERE user_id = ? AND autofill = ?
        LIMIT 1'
    );

    $stmt->execute([$userId, TRUE]);

    return (bool) $stmt->fetchColumn();
    }

    public function getOrderAddress($orderId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM order_address
            WHERE order_id = ?'
        );
        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertUserAddress($data)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO user_address (
                user_id,
                recipient_name,
                recipient_phone,
                country,
                city,
                address_line_1,
                address_line_2,
                postal_code,
                autofill
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['user_id'],
            $data['recipient_name'],
            $data['recipient_phone'],
            $data['country'],
            $data['city'],
            $data['address_line_1'],
            $data['address_line_2'],
            $data['postal_code'],
            $data['autofill']
        ]);

        return $this->pdo->lastInsertId();
    }

    public function updateUserAddress($data)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE user_address
            SET
                recipient_name = ?,
                recipient_phone = ?,
                country = ?,
                city = ?,
                address_line_1 = ?,
                address_line_2 = ?,
                postal_code = ?,
                autofill = ?
            WHERE user_id = ?'
        );

        return $stmt->execute([
            $data['recipient_name'],
            $data['recipient_phone'],
            $data['country'],
            $data['city'],
            $data['address_line_1'],
            $data['address_line_2'],
            $data['postal_code'],
            $data['autofill'],
            $data['user_id']
        ]);
    }

    public function insertOrderAddress($data)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO order_address (
                order_id,
                recipient_name,
                recipient_phone,
                country,
                city,
                address_line_1,
                address_line_2,
                postal_code
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['order_id'],
            $data['recipient_name'],
            $data['recipient_phone'],
            $data['country'],
            $data['city'],
            $data['address_line_1'],
            $data['address_line_2'],
            $data['postal_code']
        ]);

        return $this->pdo->lastInsertId();
    }


}
