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

use App\Controllers\admin\adminPanelController;
use App\Controllers\admin\adminItemController;
use App\Controllers\admin\adminOrderController;
use App\Controllers\admin\adminStatisticsController;
use App\Controllers\admin\adminUserController;

$router = new MainRouter(); 

$router->get('/', [HomeController::class, 'index']);
$router->get('/home', [HomeController::class, 'index']);
$router->get('/about-us', [HomeController::class, 'aboutUs']);
$router->get('/favourites', [FavouritesController::class, 'index']);
$router->post('/favourites/insert/:id', [FavouritesController::class, 'addFavourite']);
$router->post('/favourites/remove/:id', [FavouritesController::class, 'removeFavourite']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'createAccount']);

$router->post('/account/update-user', [AccountController::class, 'updateUsercustomer']);

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
$router->get('/orders/order-data/:id', [orderController::class, 'show']);

$router->get('/submit-query', [QueryController::class, 'index']);
$router->post('/submit-query', [QueryController::class, 'addQuery']);

if (($_SESSION['role'] ?? '') === "admin") {
    $router->get('/admin-panel', [adminPanelController::class, 'index']);

    $router->get('/admin-panel/statistics', [adminStatisticsController::class, 'index']);

    $router->get('/admin-panel/items', [adminItemController::class, 'index']);
    $router->get('/admin-panel/items/item-data/:id', [adminItemController::class, 'show']);
    $router->post('/admin-panel/items/insert', [adminItemController::class, 'addItem']);
    $router->post('/admin-panel/items/update/:id', [adminItemController::class, 'updateItem']);
    $router->post('/admin-panel/items/delete/:id', [adminItemController::class, 'deleteItem']);

    $router->get('/admin-panel/users', [adminUserController::class, 'index']);
    $router->get('/admin-panel/users/user-data/:id', [adminUserController::class, 'show']);
    $router->post('/admin-panel/users/insert', [adminUserController::class, 'addUser']);
    $router->post('/admin-panel/users/update/:id', [adminUserController::class, 'updateUser']);
    $router->post('/admin-panel/users/delete/:id', [adminUserController::class, 'deleteUser']);

    $router->get('/admin-panel/orders', [adminOrderController::class, 'index']);
    $router->get('/admin-panel/orders/order-data/:id', [adminOrderController::class, 'show']);
}

$router->dispatch($requestUri, $requestMethod);