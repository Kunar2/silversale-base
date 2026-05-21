<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Item;

class HomeController extends BaseController
{

    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->item = new Item($this->db);
    }

    public function index()
    {
        $item = [];

        $popularItems = $items = $this->item->getPopularItems(3);

        $popularCategories = $items = $this->item->getPopularCategories(3);

        $recentItems = $items = $this->item->getRecentItems(3);


        $data = [
            'pageTitle' => 'Home',
            'popularItems' => $popularItems,
            'popularCategories' => $popularCategories,
            'recentItems' => $recentItems,
            'currentPage' => 'home'
        ];

        $this->render('home', $data);
    }
}
