<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Item;
use App\Models\Favourite;
use App\Models\Cart;

class HomeController extends BaseController
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
        $userId = $_SESSION['user_id'] ?? null;

        $popularItems = $this->item->getPopularItems(3);

        foreach ($popularItems as &$item) {

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

        $popularCategories = $this->item->getPopularCategories(3);

        foreach ($popularCategories as &$item) {

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

        $recentItems = $this->item->getRecentItems(3);

        foreach ($recentItems as &$item) {

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

        $data = [
            'pageTitle' => 'Home',
            'popularItems' => $popularItems,
            'popularCategories' => $popularCategories,
            'recentItems' => $recentItems,
            'currentPage' => 'home'
        ];

        $this->render('home', $data);
    }

    public function aboutUs()
    {
        $data = [
            'pageTitle' => 'Home',
            'currentPage' => 'home'
        ];

        $this->render('about-us', $data);
    }
}
