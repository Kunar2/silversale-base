<?php
namespace App\Controllers\admin;

use App\Core\BaseController;

class adminPanelController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'admin',
            'currentPage' => 'admin-panel' 
        ];

        $this->render('admin-panel', $data);
    }
}
