<?php
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

use App\Models\User;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Item;
use App\Models\Favourite;

class MainTest extends TestCase
{
    private PDO $pdo;

    private User $users;
    private Address $address;
    private Cart $cart;
    private Order $order;
    private Item $item;
    private Favourite $favourite;

    private $username;
    private $password;
    private $email;
    private $phone;

    private $username2;
    private $password2;
    private $email2;
    private $phone2;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $ssl = $_ENV['DB_SSLMODE'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$ssl";

        $this->pdo = new PDO(
            $dsn,
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );

        $this->pdo->exec("SET search_path TO silversale, public");

        $this->users = new User($this->pdo);
        $this->address = new Address($this->pdo);
        $this->cart = new Cart($this->pdo);
        $this->order = new Order($this->pdo);
        $this->item = new Item($this->pdo);
        $this->favourite = new Favourite($this->pdo);

        $this->username = 'test_user';
        $this->password = 'test_password';
        $this->email = 'test@test.com';
        $this->phone = '123456789';

        $this->username2 = 'test_user2';
        $this->password2 = 'test_password2';
        $this->email2 = 'test2@test.com';
        $this->phone2 = '124567892';


        $this->pdo->exec(
            "DELETE FROM users
            WHERE username = 'test_user'"
        );

        $this->pdo->exec(
            "DELETE FROM users
            WHERE username = 'test_user2'"
        );

        $this->users->insertUser($this->username, $this->password, $this->email);
        $this->users->insertUser($this->username2, $this->password2, $this->email2);
    }

    public function testInsertUser()
    {
        $this->pdo->exec(
            "DELETE FROM users
            WHERE username = 'test_user'"
        );

        $users = $this->users->getByUsername(
            $this->username
        );

        $this->assertFalse($users);

        $this->users->insertUser($this->username, $this->password, $this->email);

        $users = $this->users->getByUsername(
            $this->username
        );

        $this->assertNotFalse($users);

        $this->assertEquals(
            $this->email,
            $users['email']
        );
    }

    public function testUpdateUser()
    {
        $user = $this->users->getByUsername($this->username);

        $this->assertNotFalse($user);

        $userId = $user['user_id'];

        $newUsername = 'te144stt_user5f3';
        $newEmail = 'te124fgdtst5k3@t4est.com';

        $this->users->updateUserAdmin($userId, [
            'username' => $newUsername,
            'email' => $newEmail,
            'password' => null,
            'role' => $user['role'],
            'image' => null
        ]);

        $updatedUser = $this->users->getByUsername($newUsername);

        $this->assertNotFalse($updatedUser);
        $this->assertEquals($newUsername, $updatedUser['username']);
        $this->assertEquals($newEmail, $updatedUser['email']);

        $stmt = $this->pdo->prepare(
            "DELETE FROM users WHERE username = ?"
        );

        $stmt->execute([$newUsername]);
    }

    public function testGetUser()
    {
        $user = $this->users->getByUsername($this->username);

        $this->assertNotFalse($user);

        $user = $this->users->getById($user['user_id']);

        $this->assertNotFalse($user);

        $this->assertEquals($this->username, $user['username']);
    }

    public function testDeleteUser()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $user = $this->users->deleteUser($user['user_id']);

        $user = $this->users->getByUsername($this->username);
        $this->assertFalse($user);
    }

        public function testInsertItem()
    {
        $this->pdo->exec(
            "DELETE FROM item
            WHERE name = 'test_item'"
        );

        $itemId = $this->item->insertItem([
            'name' => 'test_item',
            'manufacturer' => 'test_manufacturer',
            'description' => 'test_description',
            'category' => 1,
            'gender' => 'unisex',
            'price' => 50,
            'sale_price' => 40,
            'image' => '/assets/items/test.png',
            'listed' => 1
        ]);

        $this->assertNotFalse($itemId);

        $stmt = $this->pdo->prepare(
            "SELECT *
            FROM item
            WHERE item_id = ?"
        );

        $stmt->execute([$itemId]);

        $item = $stmt->fetch();

        $this->assertNotFalse($item);
        $this->assertEquals('test_item', $item['name']);
    }

    public function testUpdateItem()
    {
        $itemId = $this->item->insertItem([
            'name' => 'test_item',
            'manufacturer' => 'test_manufacturer',
            'description' => 'test_description',
            'category' => 1,
            'gender' => 'unisex',
            'price' => 50,
            'sale_price' => 40,
            'image' => '/assets/items/test.png',
            'listed' => 1
        ]);

        $this->item->updateItem($itemId, [
            'name' => 'updated_test_item',
            'manufacturer' => 'updated_manufacturer',
            'description' => 'updated_description',
            'category' => 1,
            'gender' => 'unisex',
            'price' => 60,
            'sale_price' => 45,
            'image' => null,
            'listed' => 1
        ]);

        $stmt = $this->pdo->prepare(
            "SELECT *
            FROM item
            WHERE item_id = ?"
        );

        $stmt->execute([$itemId]);

        $item = $stmt->fetch();

        $this->assertNotFalse($item);
        $this->assertEquals('updated_test_item', $item['name']);
        $this->assertEquals(60, $item['price']);
    }

    public function testGetItem()
    {
        $itemId = $this->item->insertItem([
            'name' => 'test_item',
            'manufacturer' => 'test_manufacturer',
            'description' => 'test_description',
            'category' => 1,
            'gender' => 'unisex',
            'price' => 50,
            'sale_price' => 40,
            'image' => '/assets/items/test.png',
            'listed' => 1
        ]);

        $this->assertNotFalse($itemId);

        $stmt = $this->pdo->prepare(
            "INSERT INTO inventory (item_id, size, quantity)
            VALUES (?, ?, ?)"
        );

        $stmt->execute([$itemId, 'M', 10]);

        $item = $this->item->getItemAdminDetailed($itemId);

        $this->assertNotFalse($item);
        $this->assertEquals('test_item', $item['name']);
    }

    public function testDeleteItem()
    {
        $itemId = $this->item->insertItem([
            'name' => 'test_item',
            'manufacturer' => 'test_manufacturer',
            'description' => 'test_description',
            'category' => 1,
            'gender' => 'unisex',
            'price' => 50,
            'sale_price' => 40,
            'image' => '/assets/items/test.png',
            'listed' => 1
        ]);

        $this->item->deleteItem($itemId);

        $stmt = $this->pdo->prepare(
            "SELECT *
            FROM item
            WHERE item_id = ?"
        );

        $stmt->execute([$itemId]);

        $item = $stmt->fetch();

        $this->assertFalse($item);
    }


    private function createTestOrder()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $orderId = $this->order->insertMainOrder([
            'user_id' => $user['user_id'],
            'status' => 'processing',
            'total_price' => 100,
            'shipping_agent' => 'DHL',
            'waybill_number' => 'TEST123',
            'estimated_delivery' => date('Y-m-d'),
            'date_ordered' => date('Y-m-d'),
            'delivered_at' => null
        ]);

        $this->assertNotFalse($orderId);

        return $orderId;
    }

    public function testInsertOrder()
    {
        $orderId = $this->createTestOrder();

        $stmt = $this->pdo->prepare(
            "SELECT * FROM order_main WHERE order_id = ?"
        );
        $stmt->execute([$orderId]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($order);
        $this->assertEquals($orderId, $order['order_id']);
    }

    public function testUpdateOrder()
    {
        $orderId = $this->createTestOrder();

        $stmt = $this->pdo->prepare(
            "UPDATE order_main
            SET status = ?,
                shipping_agent = ?,
                waybill_number = ?,
                estimated_delivery = ?,
                delivered_at = ?
            WHERE order_id = ?"
        );

        $stmt->execute([
            'shipped',
            'FedEx',
            'UPDATED123',
            date('Y-m-d'),
            null,
            $orderId
        ]);

        $stmt = $this->pdo->prepare(
            "SELECT * FROM order_main WHERE order_id = ?"
        );
        $stmt->execute([$orderId]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($order);
        $this->assertEquals('shipped', $order['status']);
        $this->assertEquals('FedEx', $order['shipping_agent']);
        $this->assertEquals('UPDATED123', $order['waybill_number']);
    }

    public function testGetOrder()
    {
        $orderId = $this->createTestOrder();

        $stmt = $this->pdo->prepare(
            "SELECT * FROM order_main WHERE order_id = ?"
        );
        $stmt->execute([$orderId]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC); 

        $this->assertNotFalse($order);
        $this->assertEquals($orderId, $order['order_id']);
    }

    public function testDeleteOrder()
    {
        $orderId = $this->createTestOrder();

        $stmt = $this->pdo->prepare(
            "DELETE FROM order_main WHERE order_id = ?"
        );
        $stmt->execute([$orderId]);

        $stmt = $this->pdo->prepare(
            "SELECT * FROM order_main WHERE order_id = ?"
        );
        $stmt->execute([$orderId]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($order);
    }
    
    public function testInsertCart()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $this->pdo->prepare(
            "DELETE FROM cart WHERE user_id = ?"
        )->execute([$user['user_id']]);

        $cartId = $this->cart->insertCart($user['user_id']);

        $this->assertNotFalse($cartId);

        $foundCartId = $this->cart->getCartId($user['user_id']);

        $this->assertEquals($cartId, $foundCartId);
    }

    public function testInsertCartItem()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $cartId = $this->cart->getCartId($user['user_id']);

        if (!$cartId) {
            $cartId = $this->cart->insertCart($user['user_id']);
        }

        $stmt = $this->pdo->query(
            "SELECT unit_id
            FROM inventory
            LIMIT 1"
        );

        $unitId = $stmt->fetchColumn();
        $this->assertNotFalse($unitId);

        $this->cart->insertByCartId($cartId, $unitId, 1);

        $this->assertTrue(
            $this->cart->unitInCart($cartId, $unitId)
        );

        $this->assertEquals(
            1,
            $this->cart->getQuantity($cartId, $unitId)
        );
    }

    public function testIncrementCartItemQuantity()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $cartId = $this->cart->getCartId($user['user_id']);

        if (!$cartId) {
            $cartId = $this->cart->insertCart($user['user_id']);
        }

        $unitId = $this->pdo->query(
            "SELECT unit_id FROM inventory LIMIT 1"
        )->fetchColumn();

        $this->assertNotFalse($unitId);

        $this->cart->insertByCartId($cartId, $unitId, 1);
        $this->cart->incrementQuantity($cartId, $unitId);

        $this->assertEquals(
            2,
            $this->cart->getQuantity($cartId, $unitId)
        );
    }

    public function testDeleteCartItem()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $cartId = $this->cart->getCartId($user['user_id']);

        if (!$cartId) {
            $cartId = $this->cart->insertCart($user['user_id']);
        }

        $unitId = $this->pdo->query(
            "SELECT unit_id FROM inventory LIMIT 1"
        )->fetchColumn();

        $this->assertNotFalse($unitId);

        $this->cart->insertByCartId($cartId, $unitId, 1);

        $this->assertTrue(
            $this->cart->unitInCart($cartId, $unitId)
        );

        $this->cart->deleteCartUnitFull($cartId, $unitId);

        $this->assertFalse(
            $this->cart->unitInCart($cartId, $unitId)
        );
    }

    public function testAddFavourite()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $itemId = $this->pdo->query(
            "SELECT item_id FROM item LIMIT 1"
        )->fetchColumn();

        $this->assertNotFalse($itemId);

        $this->favourite->deleteByUserId($user['user_id'], $itemId);

        $this->assertFalse(
            $this->favourite->isFavourited($user['user_id'], $itemId)
        );

        $this->favourite->insertByUserId($user['user_id'], $itemId);

        $this->assertTrue(
            $this->favourite->isFavourited($user['user_id'], $itemId)
        );
    }

    public function testRemoveFavourite()
    {
        $user = $this->users->getByUsername($this->username);
        $this->assertNotFalse($user);

        $itemId = $this->pdo->query(
            "SELECT item_id FROM item LIMIT 1"
        )->fetchColumn();

        $this->assertNotFalse($itemId);

        $this->favourite->insertByUserId($user['user_id'], $itemId);

        $this->assertTrue(
            $this->favourite->isFavourited($user['user_id'], $itemId)
        );

        $this->favourite->deleteByUserId($user['user_id'], $itemId);

        $this->assertFalse(
            $this->favourite->isFavourited($user['user_id'], $itemId)
        );
    }


    protected function tearDown(): void
    {
        $this->pdo->exec(
            "DELETE FROM users
            WHERE username = 'test_user'"
        );

        $this->pdo->exec(
            "DELETE FROM users
            WHERE username = 'test_user2'"
        );

        $this->pdo->exec(
            "DELETE FROM item
            WHERE name IN ('test_item', 'updated_test_item')"
        );

        $this->pdo->exec(
            "DELETE FROM cart_item
            WHERE cart_id IN (
                SELECT cart_id FROM cart
                WHERE user_id IN (
                    SELECT user_id FROM users
                    WHERE username IN ('test_user', 'test_user2')
                )
            )"
        );

        $this->pdo->exec(
            "DELETE FROM cart
            WHERE user_id IN (
                SELECT user_id FROM users
                WHERE username IN ('test_user', 'test_user2')
            )"
        );

        $this->pdo->exec(
            "DELETE FROM users
            WHERE username IN ('test_user', 'test_user2')"
        );

        $this->pdo->exec(
        "DELETE FROM favourite
        WHERE user_id IN (
            SELECT user_id FROM users
            WHERE username IN ('test_user', 'test_user2')
        )"
    );
    }
}
