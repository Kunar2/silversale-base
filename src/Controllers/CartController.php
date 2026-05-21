<?php
namespace App\Controllers;

use App\Core\BaseController;

class CartController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Cart',
            'currentPage' => 'cart' 
        ];

        $this->render('cart', $data);
    }
}
