<?php

namespace App\Models;

use PDO;

class Cart
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllByUserId($userId)
    {
        $cartId = $this->getCartId($userId);

        if (!$cartId) {
            return [];
        }

        return $this->getCartItemsId($cartId);
    }

    public function insertCart($userId)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO cart (user_id)
            VALUES (?)'
        );

        $stmt->execute([$userId]);

        return $this->pdo->lastInsertId();
    }

    public function getCartId($userId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT cart_id FROM cart
            WHERE user_id = ?
            LIMIT 1'
        );
        $stmt->execute([$userId]);

        return $stmt->fetchColumn();
    }

    public function getCartItemsId($cartId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT cart_item.quantity AS item_quantity, 
            ROUND((item.sale_price * cart_item.quantity)::numeric, 2) AS line_subtotal, * FROM cart_item
            
            JOIN inventory 
            ON cart_item.unit_id = inventory.unit_id

            JOIN item 
            ON inventory.item_id = item.item_id 

            WHERE cart_item.cart_id = ?'
        );
        $stmt->execute([$cartId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuantity($cartId, $unitId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT quantity FROM cart_item
            WHERE cart_id = ? AND unit_id = ?
            LIMIT 1'
        );
        $stmt->execute([$cartId, $unitId]);

        return $stmt->fetchColumn();
    }

    public function setByCartId($cartId, $unitId, $quantity)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cart_item
            SET quantity = ?
            WHERE cart_id = ? AND unit_id = ?'
        );

        return $stmt->execute([$quantity, $cartId, $itemId]);
    }

    public function insertByCartId($cartId, $unitId, $quantity = 1)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO cart_item VALUES (?, ?, ?)
            ON CONFLICT (cart_id, unit_id) DO NOTHING'
        );

        return $stmt->execute([$cartId, $unitId, $quantity]);
    }

    public function addCartUnit($cartId, $unitId)
    {
        if ($this->unitInCart($cartId, $unitId)) {
            return $this->incrementQuantity($cartId, $unitId);
        }

        return $this->insertByCartId($cartId, $unitId);
    }

    public function incrementQuantity($cartId, $unitId)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cart_item
            SET quantity = quantity + 1
            WHERE cart_id = ? AND unit_id = ?'
        );

        return $stmt->execute([$cartId, $unitId]);
    }
    
    public function decrementQuantity($cartId, $unitId)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cart_item
            SET quantity = quantity - 1
            WHERE cart_id = ? AND unit_id = ?'
        );

        return $stmt->execute([$cartId, $unitId]);
    }

    public function deleteCartUnit($cartId, $unitId)
    {
        if ($this->unitInCart($cartId, $unitId) && $this->getQuantity($cartId, $unitId) > 1 ) {
            return $this->decrementQuantity($cartId, $unitId);
        }

        return $this->deleteCartUnitFull($cartId, $unitId);
    }

    public function deleteCartUnitFull($cartId, $unitId)
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM cart_item 
            WHERE cart_id = ? AND unit_id = ?'
        );

        return $stmt->execute([$cartId, $unitId]);
    }

    public function eraseCart($cartId)
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM cart_item
            WHERE cart_id = ?'
        );

        return $stmt->execute([$cartId]);
    }

    public function itemInCart($cartId, $itemId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1
            FROM cart
            JOIN cart_item 
                ON cart.cart_id = cart_item.cart_id
            JOIN inventory
                ON cart_item.unit_id = inventory.unit_id
            WHERE cart.cart_id = ?
            AND inventory.item_id = ?
            LIMIT 1'
        );

        $stmt->execute([$cartId, $itemId]);

        return (bool) $stmt->fetchColumn();
    }

    public function unitInCart($cartId, $unitId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1
            FROM cart
            JOIN cart_item 
                ON cart.cart_id = cart_item.cart_id
            WHERE cart.cart_id = ?
            AND cart_item.unit_id = ?
            LIMIT 1'
        );

        $stmt->execute([$cartId, $unitId]);

        return (bool) $stmt->fetchColumn();
    }
}
