<?php

namespace App\Models;

use PDO;

class Statistics
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function getTimeframeCondition($timeframe)
    {
        switch ($timeframe) {
            case 'week':
                return "date_ordered >= CURRENT_DATE - INTERVAL '7 days'";

            case 'month':
                return "date_ordered >= CURRENT_DATE - INTERVAL '1 month'";

            case 'year':
                return "date_ordered >= CURRENT_DATE - INTERVAL '1 year'";

            case 'all':
            default:
                return "1 = 1";
        }
    }

    public function getTotalItems()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM item");
        return $stmt->fetchColumn();
    }

    public function getTotalUsers()
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM users');
        return $stmt->fetchColumn();
    }

    public function getTotalOrders($timeframe = 'all')
    {
        $condition = $this->getTimeframeCondition($timeframe);

        $stmt = $this->pdo->query(
            "SELECT COUNT(*)
            FROM order_main
            WHERE $condition"
        );

        return $stmt->fetchColumn();
    }

    public function getTotalItemsSold($timeframe = 'all')
    {
        $condition = $this->getTimeframeCondition($timeframe);

        $stmt = $this->pdo->query(
            "SELECT COALESCE(SUM(order_item.quantity), 0)
            FROM order_item
            JOIN order_main
            ON order_item.order_id = order_main.order_id
            WHERE $condition"
        );

        return $stmt->fetchColumn();
    }

    public function getRevenue($timeframe = 'all')
    {
        $condition = $this->getTimeframeCondition($timeframe);

        $stmt = $this->pdo->query(
            "SELECT COALESCE(SUM(total_price), 0)
            FROM order_main
            WHERE $condition"
        );

        return $stmt->fetchColumn();
    }

    public function getStatusCounts($timeframe = 'all')
    {
        $condition = $this->getTimeframeCondition($timeframe);

        $stmt = $this->pdo->query(
            "SELECT status, COUNT(*) as quantity
            FROM order_main
            WHERE $condition
            GROUP BY status"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
