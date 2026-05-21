<?php
namespace App\Controllers\Admin;

use App\Core\BaseController;

class AdminStatisticsController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Admin Statistics ',
            'currentPage' => 'admin-panel' 
        ];

        $this->render('admin-panel/statistics', $data);
    }
}
