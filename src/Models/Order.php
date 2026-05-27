<?php

namespace App\Models;

use PDO;

class Order
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getOrderAdminSnapshot()
    {
        $stmt = $this->pdo->query(
            'SELECT 
                order_main.order_id,
                order_main.user_id,
                users.username,
                users.email,
                order_main.date_ordered,
                order_main.total_price,
                order_main.status

            FROM order_main

            JOIN users
            ON users.user_id = order_main.user_id

            ORDER BY order_main.date_ordered DESC'
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    public function getOrderAdminDetailed($orderId)
    {
        $stmt = $this->pdo->prepare(
        'SELECT order_main.*, 
        order_item.*, 
        order_address.*,
        item.*,
        inventory.*,
        users.user_id,
        users.username,
        users.email

        FROM order_main

        JOIN order_address
        ON order_address.order_id = order_main.order_id

        JOIN order_item
        ON order_item.order_id = order_main.order_id
        
        JOIN inventory
        ON order_item.unit_id = inventory.unit_id

        JOIN item
        ON item.item_id = order_item.item_id

        JOIN users
        ON order_main.user_id = users.user_id
        
        WHERE order_main.order_id = ?
        '
    );
    $stmt->execute([$orderId]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $order = null;

    foreach ($rows as $row) {

        if ($order === null) {
            $order = [
                'order_id' => $row['order_id'],
                'status' => $row['status'],
                'date_ordered' => $row['date_ordered'],
                'total_price' => $row['total_price'],
                'recipient_name' => $row['recipient_name'],
                'recipient_phone' => $row['recipient_phone'],
                'country' => $row['country'],
                'city' => $row['city'],
                'address_line_1' => $row['address_line_1'],
                'address_line_2' => $row['address_line_2'],
                'postal_code' => $row['postal_code'],
                'username' => $row['username'],
                'email' => $row['email'],
                'shipping_agent' => $row['shipping_agent'],
                'waybill_number' => $row['waybill_number'],
                'estimated_delivery' => $row['estimated_delivery'],
                'delivered_at' => $row['delivered_at'],
                'user_id' => $row['user_id'],
                'items' => [],
            ];
        }

        $order['items'][] = [
            'item_id' => $row['item_id'],
            'name' => $row['name'],
            'size' => $row['size'],
            'unit_id' => $row['unit_id'],
            'quantity' => $row['quantity'],
            'unit_price_snapshot' => $row['unit_price_snapshot']
        ];
    }

    return $order;
    }

    public function getOrderSnapshot($userId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT order_main.*, 
            order_item.*, 
            order_address.address_line_1,
            order_item.item_id AS order_item_id,
            inventory.size,
            item.name, 
            item.price, 
            item.image

            FROM order_main

            JOIN order_address
            ON order_address.order_id = order_main.order_id

            JOIN order_item
            ON order_item.order_id = order_main.order_id
            
            JOIN inventory
            ON order_item.unit_id = inventory.unit_id

            JOIN item
            ON item.item_id = order_item.item_id

            WHERE order_main.user_id = ?'
        );

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($itemId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM items WHERE order.item_id = item.item_id'
        );

        $stmt->execute([ $itemId ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertMainOrder($data)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO order_main (
                user_id,
                status,
                total_price,
                shipping_agent,
                waybill_number,
                estimated_delivery,
                date_ordered,
                delivered_at
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['user_id'],
            'Processing',
            $data['total_price'],
            'FedEx',
            strtoupper(bin2hex(random_bytes(5))),
            (new \DateTime())->modify('+20 days')->format('Y-m-d'),
            date('Y-m-d H:i:s'),
            null
        ]);

        error_log('Main inserted successfully');

        return $this->pdo->lastInsertId();
    }

    public function insertOrderItems($cartItems)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO order_item (
                order_id,
                item_id,
                unit_id,
                quantity,
                unit_price_snapshot
            )
            VALUES (?, ?, ?, ?, ?)'
        );

        foreach ($cartItems as $cartItem) {
            $stmt->execute([
                $cartItem['order_id'],
                $cartItem['item_id'],
                $cartItem['unit_id'],
                $cartItem['item_quantity'],
                $cartItem['sale_price']
            ]);
        }

        error_log('Order items inserted successfully');

        return true;
    }

}
