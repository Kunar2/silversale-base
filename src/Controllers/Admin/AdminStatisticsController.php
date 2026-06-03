<?php
namespace App\Controllers\admin;

use App\Core\BaseController;
use App\Models\Statistics;

class adminStatisticsController extends BaseController
{
    private Statistics $statistics;
    private Address $address;
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->statistics = new Statistics($this->db);
    }

    public function index()
    {
        $timeframe = $_GET['timeframe'] ?? 'all';

        $data = [
            'pageTitle' => 'Admin Statistics',
            'currentPage' => 'admin-panel',

            'totalUsers' => $this->statistics->getTotalUsers(),

            'totalItems' => $this->statistics->getTotalItems(),

            'totalOrders' => $this->statistics->getTotalOrders($timeframe),

            'totalItemsSold' => $this->statistics->getTotalItemsSold($timeframe),

            'revenue' => $this->statistics->getRevenue($timeframe),

            'statusCounts' => $this->statistics->getStatusCounts($timeframe),

            'timeframe' => $timeframe
        ];

        $this->render('admin-panel/statistics', $data);
    }
}
