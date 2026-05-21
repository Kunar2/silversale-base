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
$router->get('/catalogue/item/:id', [ItemController::class, 'show']);

$router->get('/account', [AccountController::class, 'index']);

$router->get('/orders', [OrderController::class, 'index']);

$router->get('/customer-order', [OrderController::class, 'show']);
$router->get('/checkout', [OrderController::class, 'checkout']);

$router->get('/cart', [CartController::class, 'index']);
$router->post('/cart/insert', [FavouritesController::class, 'index']);

$router->get('/submit-query', [QueryController::class, 'index']);

// $router->post('/item', [UserController::class, 'item']);


$router->get('/admin/items', [AdminItemController::class, 'index']);
$router->get('/admin/items/:id', [AdminItemController::class, 'show']);

$router->get('/admin/users', [AdminUserController::class, 'index']);
$router->get('/admin/users/:id', [AdminUserController::class, 'show']);

$router->get('/admin/orders', [AdminOrderController::class, 'index']);
$router->get('/admin/orders/:id', [AdminOrderController::class, 'show']);

$router->dispatch($requestUri, $requestMethod);