<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Cart;

class CartController extends BaseController
{
    private Cart $cart;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart($this->db);
    }

    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $cartItems = $this->cart->getAllByUserId($userId);

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $data = [
            'pageTitle' => 'Cart',
            'currentPage' => 'cart',
            'cartItems' => $cartItems
        ];

        $this->render('cart', $data);
    }

    public function addCart($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $unitId = $params['id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $cartId = $this->cart->getCartId($userId);

        $this->cart->addCartUnit($cartId, $unitId);

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    public function deleteCart($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $unitId = $params['id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $cartId = $this->cart->getCartId($userId);

        $this->cart->deleteCartUnit($cartId, $unitId);

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    public function deleteCartFull($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $unitId = $params['id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $cartId = $this->cart->getCartId($userId);

        $this->cart->deleteCartUnitFull($cartId, $unitId);

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

}
