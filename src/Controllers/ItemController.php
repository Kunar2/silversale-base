<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Item;
use App\Models\Favourite;

class ItemController extends BaseController
{
    private Item $item;
    private Favourite $favourite;

    public function __construct()
    {
        parent::__construct();
        $this->item = new Item($this->db);
        $this->favourite = new Favourite($this->db);
    }

    public function index()
    {
        $items = $this->item->getAll();

        $userId = $_SESSION['user_id'] ?? null;

        foreach ($items as &$item) {

            $item['is_favourited'] = false;

            if ($userId) {
                $item['is_favourited'] = $this->favourite->isFavourited(
                    $userId,
                    $item['item_id']
                );
            }
        }

        $data = [
            'pageTitle'   => 'Catalogue Page',
            'currentPage' => 'catalogue',
            'items'       => $items
        ];

        $this->render('catalogue', $data);
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            http_response_code(404);
            echo "Item not found";
            return;
        }

        $item = $this->item->getItem($id);
        $inventory = $this->item->getInventoryByItemId($id);
        $userId = $_SESSION['user_id'] ?? null;

        if ($item === []) {
            http_response_code(404);
            echo "Item not found";
            return;
        }

        if ($userId) {
            $item['is_favourited'] = $this->favourite->isFavourited(
                $userId,
                $item['item_id']
            );
        }

        $data = [
            'pageTitle' => 'Item Details',
            'currentPage' => 'catalogue',
            'item' => $item,
            'inventory' => $inventory
        ];

        $this->render('catalogue/item', $data);
    }
}