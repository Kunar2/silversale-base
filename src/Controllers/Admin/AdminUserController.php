<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;

class AdminUserController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle'   => 'Users',
            'currentPage' => 'admin-users'
        ];

        $this->render('admin-panel/users', $data);
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        $data = [
            'pageTitle'   => 'User Details',
            'currentPage' => 'admin-users',
            'userId'      => $id
        ];

        $this->render('admin-panel/users/user-data', $data);
    }
}