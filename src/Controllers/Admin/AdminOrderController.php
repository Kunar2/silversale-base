<?php
namespace App\Controllers\Admin;

use App\Core\BaseController;

class AdminOrderController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle'   => 'Orders',
            'currentPage' => 'admin-orders'
        ];

        $this->render('admin-panel/orders', $data);
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        $data = [
            'pageTitle'   => 'Order Details',
            'currentPage' => 'admin-orders',
            'orderId'     => $id
        ];

        $this->render('admin-panel/orders/order-data', $data);
    }
}