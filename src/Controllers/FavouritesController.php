<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Favourite;
use App\Models\Cart;



class FavouritesController extends BaseController
{

    private Favourite $favourite;
    private Cart $cart;

    public function __construct()
    {
        parent::__construct();
        $this->favourite = new Favourite($this->db);
        $this->cart = new Cart($this->db);
    }

    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $favourites = $this->favourite->getByUserId($userId);

        foreach ($favourites as &$favourite) {
            $favourite['is_favourited'] = false;
            $favourite['item_in_cart'] = false;

            if ($userId) {
                $favourite['is_favourited'] = $this->favourite->isFavourited(
                    $userId,
                    $favourite['item_id']
                );

                $favourite['item_in_cart'] = $this->cart->itemInCart(
                    $userId,
                    $favourite['item_id']
                );
            }
        }

        $data = [
            'pageTitle' => 'Favourites',
            'currentPage' => 'favourites',
            'favourites' => $favourites
        ];

        $this->render('favourites', $data);
    }

    public function addFavourite($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $itemId = $params['id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        if ($userId && $itemId) {
            $this->favourite->insertByUserId($userId, $itemId);
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    public function removeFavourite($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $itemId = $params['id'] ?? null;

        if ($userId && $itemId) {
            $this->favourite->deleteByUserId($userId, $itemId);
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}
