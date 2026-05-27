<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Item;
use App\Models\Favourite;
use App\Models\Cart;

class ItemController extends BaseController
{
    private Item $item;
    private Favourite $favourite;
    private Cart $cart;

    public function __construct()
    {
        parent::__construct();

        $this->item = new Item($this->db);
        $this->favourite = new Favourite($this->db);
        $this->cart = new Cart($this->db);
    }

    public function index()
    {

        $filters = [
            'category' => $_GET['category'] ?? null,
            'gender' => $_GET['gender'] ?? null,
            'max_price' => $_GET['max_price'] ?? null,
            'search' => $_GET['search'] ?? null,
        ];


        $items = $this->item->getFiltered($filters);
        $userId = $_SESSION['user_id'] ?? null;

        foreach ($items as &$item) {
            $item['is_favourited'] = false;
            $item['item_in_cart'] = false;

            if ($userId) {
                $item['is_favourited'] = $this->favourite->isFavourited(
                    $userId,
                    $item['item_id']
                );

                $item['item_in_cart'] = $this->cart->itemInCart(
                    $userId,
                    $item['item_id']
                );
            }
        }

        unset($item);

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

        if (!$item) {
            http_response_code(404);
            echo "Item not found";
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $inventory = $this->item->getInventoryByItemId($id);

        $item['is_favourited'] = false;

        if ($userId) {
            $item['is_favourited'] = $this->favourite->isFavourited(
                $userId,
                $item['item_id']
            );
        }

        foreach ($inventory as &$unit) {
            $unit['unit_in_cart'] = false;

            if ($userId) {
                $unit['unit_in_cart'] = $this->cart->unitInCart(
                    $userId,
                    $unit['unit_id']
                );
            }
        }

        unset($unit);

        $data = [
            'pageTitle'   => 'Item Details',
            'currentPage' => 'catalogue',
            'item'        => $item,
            'inventory'   => $inventory
        ];

        $this->render('catalogue/item', $data);
    }
}