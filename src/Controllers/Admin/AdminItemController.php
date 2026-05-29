<?php
namespace App\Controllers\admin;

use App\Core\BaseController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Item;

class adminItemController extends BaseController
{
    private Cart $cart;
    private Order $order;
    private Address $address;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart($this->db);
        $this->order = new Order($this->db);
        $this->address = new Address($this->db);
        $this->item = new Item($this->db);
    }

    public function index()
    {
        $itemSnapshot = $this->item->getItemadminSnapshot();

        $data = [
            'pageTitle'   => 'Items',
            'currentPage' => 'admin-panel',
            'items' => $itemSnapshot
        ];

        $this->render('admin-panel/items', $data);
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        // Create
        if ($id === 0) {

            $data = [
                'pageTitle'   => 'Add item',
                'currentPage' => 'admin-panel',
                'items' => []
            ];

            $this->render('admin-panel/items/item-data', $data);
            return;
        }

        // Edit
        $itemDetailed = $this->item->getItemadminDetailed($id);

        $data = [
            'pageTitle'   => 'Item details',
            'currentPage' => 'admin-panel',
            'items' => $itemDetailed
        ];

        $this->render('admin-panel/items/item-data', $data);
    }

    public function addItem(array $params)
    {
        $name = trim($_POST['name'] ?? '');
        $manufacturer = trim($_POST['manufacturer'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $salePrice = trim($_POST['sale_price'] ?? '');
        $listed = trim($_POST['listed'] ?? '');
        $image = $_FILES['image'] ?? null;

        $imagePath = null;

        if ($image && $image['error'] === UPLOAD_ERR_OK) {

            $uploadDir = __DIR__ . '/../../../public/assets/items/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            $fileName = uniqid('item_', true) . '.' . $extension;

            move_uploaded_file(
                $image['tmp_name'],
                $uploadDir . $fileName
            );

            $imagePath = '/assets/items/' . $fileName;
        }

        // Insert item
        $itemId = $this->item->insertItem([
            'name' => $name,
            'manufacturer' => $manufacturer,
            'description' => $description,
            'category' => $category,
            'gender' => $gender,
            'price' => $price,
            'sale_price' => $salePrice,
            'listed' => $listed,
            'image' => $imagePath,
        ]);

        // Create default inventory rows
        $this->item->insertUnit($itemId, 's', 0);
        $this->item->insertUnit($itemId, 'm', 0);
        $this->item->insertUnit($itemId, 'l', 0);

        header('Location: /admin-panel/items/item-data/' . $itemId);
        exit;
    }

    public function updateItem(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            header('Location: /admin-panel/items');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $manufacturer = trim($_POST['manufacturer'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $salePrice = trim($_POST['sale_price'] ?? '');
        $listed = trim($_POST['listed'] ?? '');
        $image = $_FILES['image'] ?? null;

        $imagePath = null;

        if ($image && $image['error'] === UPLOAD_ERR_OK) {

            $uploadDir = __DIR__ . '/../../../public/assets/items/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            $fileName = uniqid('item_', true) . '.' . $extension;

            move_uploaded_file(
                $image['tmp_name'],
                $uploadDir . $fileName
            );

            $imagePath = '/assets/items/' . $fileName;
        }

        // Update item
        $this->item->updateItem($id, [
            'name' => $name,
            'manufacturer' => $manufacturer,
            'description' => $description,
            'category' => $category,
            'gender' => $gender,
            'price' => $price,
            'sale_price' => $salePrice,
            'listed' => $listed,
            'image' => $imagePath,
        ]);

        if (isset($_POST['inventory'])) {

            foreach ($_POST['inventory'] as $unitId => $unitData) {

                $quantity = (int)($unitData['quantity'] ?? 0);

                $this->item->updateUnitQuantity(
                    $unitId,
                    $quantity
                );
            }
        }

        header('Location: /admin-panel/items/item-data/' . $id);
        exit;
    }

    public function deleteItem(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            header('Location: /admin-panel/items');
            exit;
        }

        $this->item->deleteItem($id);

        header('Location: /admin-panel/items');
        exit;
    }
}