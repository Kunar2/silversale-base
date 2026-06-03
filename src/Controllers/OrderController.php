<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;

class OrderController extends BaseController
{

    private Cart $cart;
    private Order $order;
    private Address $address;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart($this->db);
        $this->order = new Order($this->db);
        $this->address = new Address($this->db);
    }

    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $timeframe = $_GET['timeframe'] ?? 'all';

        $orderSnapshot = $this->order->getOrderSnapshot(
            $userId,
            $timeframe
        );

        $data = [
            'pageTitle' => 'Orders',
            'currentPage' => 'orders',
            'userOrders' => $orderSnapshot,
            'timeframe' => $timeframe
        ];

        $this->render('orders', $data);
    }

    public function show(array $params)
    {
        $orderId = $params['id'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $order = $this->order->getOrderDetailed($orderId);

        if (!$order || $order['user_id'] != $userId) {
            http_response_code(403);
            die('Access denied');
        }

        $this->render('orders/order-data', [
            'pageTitle' => 'Order details',
            'currentPage' => 'orders',
            'userOrders'  => $order
        ]);
    }

    public function checkout()
    {
        $userId = $_SESSION['user_id'] ?? null;

        $cartItems = $this->cart->getAllByUserId($userId);
        $address = $this->address->getAddressCheckout($userId);

        $data = [
            'pageTitle' => 'Checkout',
            'currentPage' => 'cart',
            'cartItems' => $cartItems,
            'address' => $address
        ];

        $this->render('checkout', $data);
    }

    public function addOrder($params)
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) 
        {
            header('Location: /login');
            exit;
        }

        $cartItems = $this->cart->getAllByUserId($userId);

        $total = 0;

        foreach ($cartItems as $cartItem):
            $total = $total + $cartItem['line_subtotal'];
        endforeach; 

        $shipping = 20;
        $total = $total + $shipping;

        $recipientName = trim($_POST['recipient_name'] ?? '');
        $recipientPhone = trim($_POST['recipient_phone'] ?? '');
        $country = trim($_POST['country'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $addressLine1 = trim($_POST['address_line_1'] ?? '');
        $addressLine2 = trim($_POST['address_line_2'] ?? '');
        $postalCode = trim($_POST['postal_code'] ?? '');

        if (
            empty($recipientName) ||
            empty($recipientPhone) ||
            empty($country) ||
            empty($city) ||
            empty($addressLine1) ||
            empty($postalCode)
        ) {
            $_SESSION['error'] = 'Please fill in all required fields.';
            header('Location: /checkout');
            exit;
        }

        $addressData = [
            'recipient_name' => $recipientName,
            'recipient_phone' => $recipientPhone,
            'country' => $country,
            'city' => $city,
            'address_line_1' => $addressLine1,
            'address_line_2' => $addressLine2,
            'postal_code' => $postalCode
        ];

        $orderData = [
            'user_id' => $userId,
            'total_price' => $total
        ];

        $orderId = $this->order->insertMainOrder($orderData);

        foreach ($cartItems as &$cartItem) {
            $cartItem['order_id'] = $orderId;
        }
        unset($cartItem);

        $addressData['order_id'] = $orderId;
        $cartId = $this->cart->getCartId($userId);

        $this->order->insertOrderItems($cartItems);
        $this->cart->eraseCart($cartId);

        $this->address->insertOrderAddress($addressData);
        error_log('Order inserted successfully');

        $this->index();
    }
}