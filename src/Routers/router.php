<?php

use App\Core\MainRouter;
use App\Controllers\HomeController;
use App\Controllers\ItemController;
use App\Controllers\FavouritesController;
use App\Controllers\AccountController;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\OrderController;
use App\Controllers\CheckoutController;
use App\Controllers\QueryController;

use App\Controllers\Admin\AdminPanelController;
use App\Controllers\Admin\AdminItemController;
use App\Controllers\Admin\AdminOrderController;
use App\Controllers\Admin\AdminStatisticsController;
use App\Controllers\Admin\AdminUserController;

$router = new MainRouter(); 

$router->get('/', [HomeController::class, 'index']);
$router->get('/home', [HomeController::class, 'index']);
$router->get('/favourites', [FavouritesController::class, 'index']);
$router->post('/favourites/insert/:id', [FavouritesController::class, 'addFavourite']);
$router->post('/favourites/remove/:id', [FavouritesController::class, 'removeFavourite']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'createAccount']);

$router->get('/catalogue', [ItemController::class, 'index']);
$router->get('/catalogue/filter', [ItemController::class, 'index']);
$router->get('/catalogue/item/:id', [ItemController::class, 'show']);

$router->get('/account', [AccountController::class, 'index']);

$router->post('/order/submit', [OrderController::class, 'addOrder']);
$router->get('/orders', [OrderController::class, 'index']);

$router->get('/customer-order', [OrderController::class, 'show']);
$router->get('/checkout', [OrderController::class, 'checkout']);

$router->get('/cart', [CartController::class, 'index']);
$router->post('/cart/insert/:id', [CartController::class, 'addCart']);
$router->post('/cart/delete/:id', [CartController::class, 'deleteCart']);
$router->post('/cart/delete-full/:id', [CartController::class, 'deleteCartFull']);

$router->get('/submit-query', [QueryController::class, 'index']);

// $router->post('/item', [UserController::class, 'item']);

if (($_SESSION['role'] ?? '') === "admin") {
    $router->get('/admin-panel', [AdminPanelController::class, 'index']);

    $router->get('/admin-panel/statistics', [AdminStatisticsController::class, 'index']);

    $router->get('/admin-panel/items', [AdminItemController::class, 'index']);
    $router->get('/admin-panel/items/item-data/:id', [AdminItemController::class, 'show']);
    $router->post('/admin-panel/items/insert', [AdminItemController::class, 'addItem']);
    $router->post('/admin-panel/items/update/:id', [AdminItemController::class, 'updateItem']);
    $router->post('/admin-panel/items/delete/:id', [AdminItemController::class, 'deleteItem']);

    $router->get('/admin-panel/users', [AdminUserController::class, 'index']);
    $router->get('/admin-panel/users/user-data/:id', [AdminUserController::class, 'show']);
    $router->post('/admin-panel/users/insert', [AdminUserController::class, 'addUser']);
    $router->post('/admin-panel/users/update/:id', [AdminUserController::class, 'updateUser']);
    $router->post('/admin-panel/users/delete/:id', [AdminUserController::class, 'deleteUser']);

    $router->get('/admin-panel/orders', [AdminOrderController::class, 'index']);
    $router->get('/admin-panel/orders/order-data/:id', [AdminOrderController::class, 'show']);
}

$router->dispatch($requestUri, $requestMethod);