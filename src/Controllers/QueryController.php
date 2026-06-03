<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Query;

class QueryController extends BaseController
{

    private Query $query;

    public function __construct()
    {
        parent::__construct();
        $this->query = new Query($this->db);
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Query',
            'currentPage' => 'submit-query',
            'user' => $_SESSION['email'] ?? ''
        ];

        $this->render('submit-query', $data);
    }

    public function addQuery()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $data = [
            'user_email' => $_SESSION['email'] ?? '',
            'category' => $_POST['category'] ?? '',
            'message' => $_POST['message'] ?? ''
        ];

        $this->query->insertQuery[$data];

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}
