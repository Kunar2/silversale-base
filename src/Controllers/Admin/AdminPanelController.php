<?php
namespace App\Controllers\Admin;

use App\Core\BaseController;

class AdminPanelController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Admin',
            'currentPage' => 'admin-panel' 
        ];

        $this->render('admin-panel', $data);
    }
}
