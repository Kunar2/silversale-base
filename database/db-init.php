<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $db = Database::getConnection();

    // Read SQL file
    $sql = file_get_contents(__DIR__ . '/db-init.sql');

    // Execute all commands
    $db->exec($sql);

    echo "Database initialized successfully.";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}