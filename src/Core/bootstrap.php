<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;

$db = Database::getConnection();

$stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => 1]);
$product = $stmt->fetch();
