<?php

ini_set('max_execution_time', 360);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use PDOException;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$db = Database::getConnection();

// CSV imports
$csvImports = [
    // ['/csv/item.csv',           'silversale.item'],
    // ['/csv/users.csv',          'silversale.users'],
    // ['/csv/user_address.csv',   'silversale.user_address'],
    // ['/csv/inventory.csv',      'silversale.inventory'],
    // ['/csv/favourite.csv',      'silversale.favourite'],
    // ['/csv/cart.csv',           'silversale.cart'],
    // ['/csv/cart_item.csv',      'silversale.cart_item'],
    // ['/csv/order_main.csv',     'silversale.order_main'],
    // ['/csv/order_item.csv',     'silversale.order_item'],
    // ['/csv/order_address.csv',  'silversale.order_address'],
    // ['/csv/query.csv',          'silversale.query'],
    // ['/csv/category.csv',       'silversale.category'],
];

foreach ($csvImports as [$file, $table]) {
    importCsvFile($db, __DIR__ . $file, $table);
}

function importCsvFile($db, $csvFile, $tableName) {

    if (!file_exists($csvFile)) {
        die("CSV file not found");
    }

    $idColumns = [
        'silversale.users'         => 'user_id',
        'silversale.category'      => 'category_id',
        'silversale.item'          => 'item_id',
        'silversale.inventory'     => 'unit_id',
        'silversale.cart'          => 'cart_id',
        'silversale.order_main'    => 'order_id',
        'silversale.order_address' => 'address_id',
        'silversale.query'         => 'query_id',
        'silversale.user_address'  => 'address_id',
    ];

    $db->exec("TRUNCATE TABLE $tableName RESTART IDENTITY CASCADE;");
    echo "Table cleared. Starting fresh import...\n";

    $db->beginTransaction();

    $handle = fopen($csvFile, 'r');
    $header = fgetcsv($handle);

    $rowCount = 0;

    while (($row = fgetcsv($handle)) !== false) {
        if (empty(array_filter($row, fn($val) => $val !== null && $val !== ''))) {
            continue;
        }

        $cleanRow = array_map(function($value) {
            $trimmed = trim($value ?? '');
            return ($trimmed === '') ? null : $trimmed;
        }, $row);

        $placeholders = array_fill(0, count($row), '?');

        $sql = "INSERT INTO $tableName (" . implode(', ', $header) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $db->prepare($sql);
        $stmt->execute($cleanRow);

        $rowCount++;
    }

    fclose($handle);
    $db->commit();

    if (isset($idColumns[$tableName])) {
        $idColumn = $idColumns[$tableName];

        $db->query("
            SELECT setval(
                pg_get_serial_sequence('$tableName', '$idColumn'),
                COALESCE((SELECT MAX($idColumn) FROM $tableName), 1)
            );
        ");
    }

    echo "Successfully imported $rowCount rows!\n";
}