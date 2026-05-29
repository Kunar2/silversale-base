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

    public function testInsertOrder()
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

        $order = $this->order->getOrderItems($orderId);

        $this->assertNotFalse($order);
        $this->assertEquals($orderId, $order['order_id']);
    }

    public function testUpdateOrder()
    {
        $stmt = $this->pdo->query(
            "SELECT order_id
            FROM order_main
            LIMIT 1"
        );

        $orderId = $stmt->fetchColumn();

        $this->assertNotFalse($orderId);

        $this->order->updateOrder($orderId, [
            'status' => 'shipped',
            'shipping_agent' => 'FedEx',
            'waybill_number' => 'UPDATED123',
            'estimated_delivery' => date('Y-m-d'),
            'delivered_at' => null
        ]);

        $order = $this->order->getOrderAdminDetailed($orderId);

        $this->assertNotFalse($order);
        $this->assertEquals('shipped', $order['status']);
    }

    public function testGetOrder()
    {
        $stmt = $this->pdo->query(
            "SELECT order_id
            FROM order_main
            LIMIT 1"
        );

        $orderId = $stmt->fetchColumn();

        $this->assertNotFalse($orderId);

        $order = $this->order->getOrderAdminDetailed($orderId);

        $this->assertNotFalse($order);
        $this->assertEquals($orderId, $order['order_id']);
    }

    public function testDeleteOrder()
    {
        $stmt = $this->pdo->query(
            "SELECT order_id
            FROM order_main
            LIMIT 1"
        );

        $orderId = $stmt->fetchColumn();

        $this->assertNotFalse($orderId);

        $stmt = $this->pdo->prepare(
            "DELETE FROM order_main
            WHERE order_id = ?"
        );

        $stmt->execute([$orderId]);

        $stmt = $this->pdo->prepare(
            "SELECT *
            FROM order_main
            WHERE order_id = ?"
        );

        $stmt->execute([$orderId]);

        $order = $stmt->fetch();

        $this->assertFalse($order);
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
    }
}
