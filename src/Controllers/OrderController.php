<?php
namespace App\Controllers;

use App\Core\BaseController;

class OrderController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Orders',
            'currentPage' => 'orders' 
        ];

        $this->render('orders', $data);
    }

    public function show()
    {
        $data = [
            'pageTitle' => 'Order data',
            'currentPage' => 'orders' 
        ];

        $this->render('customer-order', $data);
    }

    public function checkout()
    {
        $data = [
            'pageTitle' => 'Checkout',
            'currentPage' => 'checkout' 
        ];

        $this->render('checkout', $data);
    }

}