<?php
namespace App\Controllers;

use App\Core\BaseController;

class QueryController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Query',
            'currentPage' => 'submit-query' 
        ];

        $this->render('submit-query', $data);
    }
}
