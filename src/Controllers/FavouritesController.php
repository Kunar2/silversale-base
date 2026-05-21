<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Favourite;


class FavouritesController extends BaseController
{

    private Favourite $favourite;

    public function __construct()
    {
        parent::__construct();
        $this->favourite = new Favourite($this->db);
    }

    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        $favourites = $this->favourite->getByUserId($userId);

        $data = [
            'pageTitle' => 'Favourites',
            'currentPage' => 'favourites',
            'favourites' => $favourites
        ];

        $this->render('favourites', $data);
    }

    public function addFavourite($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $itemId = $params['id'] ?? null;

        if ($userId && $itemId) {
            $this->favourite->insertByUserId($userId, $itemId);
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    public function removeFavourite($params)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $itemId = $params['id'] ?? null;

        if ($userId && $itemId) {
            $this->favourite->deleteByUserId($userId, $itemId);
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}
