<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;

class AdminItemController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle'   => 'Items',
            'currentPage' => 'admin-items'
        ];

        $this->render('admin-panel/items', $data);
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        $data = [
            'pageTitle'   => 'Item Details',
            'currentPage' => 'admin-items',
            'itemId'      => $id
        ];

        $this->render('admin-panel/items/item-data', $data);
    }
}