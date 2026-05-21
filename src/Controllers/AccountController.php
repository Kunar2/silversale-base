<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;

class AccountController extends BaseController
{

    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User($this->db);
    }

    public function index()
    {
        $username = $_SESSION['username'] ?? '';
        $user = $this->users->getByUsername($username);

        $data = [
            'pageTitle'   => 'Account',
            'currentPage' => 'account',
            'user' => $user
        ];

        $this->render('account', $data);
    }

    public function changePassword()
    {
    
    }
}
