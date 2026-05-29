<?php
namespace App\Controllers;

use App\Core\BaseController;

class AddressController extends BaseController
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
        // $data = [
        //     'pageTitle' => 'Address ',
        //     'currentPage' => 'address' 
        // ];

        // $this->render('address', $data);
    }

    public function updateUserAddress($data)
    {

    }
}
