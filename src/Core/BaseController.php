<?php

namespace App\Core;
use App\Config\Database;

use PDO;
class BaseController
{

    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Render a view file and pass data to it
     */
    protected function render(string $view, array $data = [])
    {

        // Automatically add common variables to every view
        
        $data['isLoggedIn']  = isset($_SESSION['user_id']) || isset($_SESSION['user']);
        $data['username']    = $_SESSION['username'] ?? null;
        $data['currentPage'] = $data['currentPage'] ?? 'home';
        $data['items'] = $data['items'] ?? [];
        $data['item'] = $data['item'] ?? [];
        $data['inventory'] = $data['inventory'] ?? [];

        $data['popularItems'] = $data['popularItems'] ?? [];
        $data['popularCategories'] = $data['popularCategories'] ?? [];
        $data['recentItems'] = $data['recentItems'] ?? [];

        $data['user'] = $data['user'] ?? [];
        $data['error'] = $data['error'] ?? [];

        $data['favourites'] = $data['favourites'] ?? [];
        $data['cartItems'] = $data['cartItems'] ?? [];
        $data['address'] = $data['address'] ?? [];
        $data['userOrders'] = $data['userOrders'] ?? [];

        $data['totalUsers'] = $data['totalUsers'] ?? 0;
        $data['totalOrders'] = $data['totalOrders'] ?? 0;
        $data['totalItemsSold'] = $data['totalItemsSold'] ?? 0;
        $data['revenue'] = $data['revenue'] ?? 0;
        $data['statusCounts'] = $data['statusCounts'] ?? [];
        $data['timeframe'] = $data['timeframe'] ?? 'all';

        // Make all $data variables available directly in the view
        extract($data);

        // Build the full path to the view file
        $viewPath = __DIR__ . '/../Views/' . $view . '/index.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            http_response_code(500);
            echo "View not found: " . $viewPath;
        }
    }

    /**
     * Redirect to another page
     */
    protected function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']) || isset($_SESSION['user']);
    }

    /**
     * Simple flash message (optional but very useful)
     */
    protected function setFlash(string $message, string $type = 'success')
    {
        $_SESSION['flash'] = [
            'message' => $message,
            'type'    => $type
        ];
    }
}