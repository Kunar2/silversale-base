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
    ['/csv/category.csv',       'category'],
    ['/csv/item.csv',           'item'],
    ['/csv/users.csv',          'users'],
    ['/csv/user_address.csv',   'user_address'],
    ['/csv/inventory.csv',      'inventory'],
    ['/csv/favourite.csv',      'favourite'],
    ['/csv/cart.csv',           'cart'],
    ['/csv/cart_item.csv',      'cart_item'],
    ['/csv/order_main.csv',     'order_main'],
    ['/csv/order_item.csv',     'order_item'],
    ['/csv/order_address.csv',  'order_address'],
    ['/csv/query.csv',          'query'],
];

foreach ($csvImports as [$file, $table]) {
    importCsvFile($db, __DIR__ . $file, $table);
}

function importCsvFile($db, $csvFile, $tableName) {

    if (!file_exists($csvFile)) {
        die("CSV file not found");
    }

    $idColumns = [
        'users'         => 'user_id',
        'category'      => 'category_id',
        'item'          => 'item_id',
        'inventory'     => 'unit_id',
        'cart'          => 'cart_id',
        'order_main'    => 'order_id',
        'order_address' => 'address_id',
        'query'         => 'query_id',
        'user_address'  => 'address_id',
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