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

    public function updateItem($itemId, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE item
            SET
                name = ?,
                manufacturer = ?,
                description = ?,
                category_id = ?,
                gender = ?,
                price = ?,
                sale_price = ?,
                image = COALESCE(?, image),
                listed = ?
            WHERE item_id = ?"
        );

        return $stmt->execute([
            $data['name'],
            $data['manufacturer'],
            $data['description'],
            $data['category'],
            $data['gender'],
            $data['price'],
            $data['sale_price'],
            $data['image'],
            $data['listed'],
            $itemId
        ]);
    }

    public function deleteItem($itemId)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM item
            WHERE item_id = ?"
        );

        return $stmt->execute([$itemId]);
    }

    public function insertItem($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO item (
                name,
                manufacturer,
                description,
                category_id,
                gender,
                price,
                sale_price,
                image,
                listed,
                reviews,
                rating
            )
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )"
        );

        $rating = 0;
        $reviews = 0;

        $stmt->execute([
            $data['name'],
            $data['manufacturer'],
            $data['description'],
            $data['category'],
            $data['gender'],
            $data['price'],
            $data['sale_price'],
            $data['image'],
            $data['listed'],
            $reviews,
            $rating,
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getItemadminSnapshot()
    {
        $stmt = $this->pdo->query('SELECT item_id, name, manufacturer FROM item');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemadminDetailed($itemId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT item.*, 
            inventory.*,
            category.name AS category
            FROM item

            JOIN category
            ON item.category_id = category.category_id 
            
            JOIN inventory 
            ON inventory.item_id = item.item_id

            WHERE item.item_id = ?"
        );

        $stmt->execute([$itemId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $item = null;

        foreach ($rows as $row) {

            if ($item === null) {
                $item = [
                    'item_id' => $row['item_id'],
                    'name' => $row['name'],
                    'manufacturer' => $row['manufacturer'],
                    'description' => $row['description'],
                    'category' => $row['category'],
                    'gender' => $row['gender'],
                    'sale_price' => $row['sale_price'],
                    'price' => $row['price'],
                    'image' => $row['image'],
                    'listed' => $row['listed'],

                    'inventory' => [],
                ];
            }

            $item['inventory'][] = [
                'unit_id' => $row['unit_id'],
                'size' => $row['size'],
                'quantity' => $row['quantity'],
            ];
        }

    return $item;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM item');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFiltered($filters)
    {
        $sql = "
            SELECT item.*, category.name AS category
            FROM item
            JOIN category 
            ON item.category_id = category.category_id
            WHERE item.listed = true
        ";

        $params = [];

        // Category filter
        if (!empty($filters['category'])) {

            $placeholders = implode(',', array_fill(0, count($filters['category']), '?'));

            $sql .= " AND category.name IN ($placeholders)";

            foreach ($filters['category'] as $category) {
                $params[] = $category;
            }
        }

        // Search filter
        if (!empty($filters['search'])) {
            $sql .= " AND item.name ILIKE ?";
            $params[] = '%' . $filters['search'] . '%';
        }

        // Price filter
        if (
            isset($filters['max_price']) &&
            $filters['max_price'] !== 'any'
        ) {
            $sql .= " AND item.sale_price <= ?";
            $params[] = $filters['max_price'];
        }

        $sortType = $filters['sort_type'] ?? 'name';

        switch ($sortType) {

            case 'popularity':
                $sql .= " ORDER BY rating * LOG(reviews + 1) DESC";
                break;

            case 'reviews':
                $sql .= " ORDER BY reviews DESC";
                break;

            case 'price_ascending':
                $sql .= " ORDER BY price ASC";
                break;

            case 'price_descending':
                $sql .= " ORDER BY price DESC";
                break;

            case 'name':
            default:
                $sql .= " ORDER BY item_id DESC";
                break;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT item.*, 
            category.name AS category
            FROM item
            JOIN category
            ON item.category_id = category.category_id 
            WHERE item_id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInventoryByItemId($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM inventory WHERE item_id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPopularItems($itemLimit)
    {
        $stmt = $this->pdo->prepare("
            SELECT *,
                (rating * reviews) AS popularity
            FROM item
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
            FROM category c
            JOIN item i
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
            FROM item
            ORDER BY reviews ASC
            LIMIT ?
        ");

        $stmt->bindValue(1, $itemLimit, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertUnit($itemId, $size, $quantity)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO inventory (item_id, size, quantity) VALUES (?, ?, ?)
        ");

        return $stmt->execute([$itemId, $size, $quantity]);
    }

    public function updateUnitQuantity($unitId, $quantity)
    {
        $stmt = $this->pdo->prepare("
            UPDATE inventory
            SET quantity = ?
            WHERE unit_id = ?
        ");

        return $stmt->execute([
            $quantity,
            $unitId
        ]);
    }

}
