<?php
namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;

class AdminOrderController extends BaseController
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
        $orderSnapshot = $this->order->getOrderAdminSnapshot();

        $data = [
            'pageTitle'   => 'Orders',
            'currentPage' => 'admin-panel',
            'userOrders' => $orderSnapshot
        ];

        $this->render('admin-panel/orders', $data);
    }

    public function show(array $params)
    {   
        $id = $params['id'] ?? null;

        $orderDetailed = $this->order->getOrderAdminDetailed($id);

        $data = [
            'pageTitle'   => 'Order Details',
            'currentPage' => 'admin-panel',
            'userOrders'  => $orderDetailed
        ];

        $this->render('admin-panel/orders/order-data', $data);
    }
}