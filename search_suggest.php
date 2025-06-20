<?php
require_once 'config/database.php';
header('Content-Type: application/json; charset=utf-8');

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$suggestions = [];

if ($keyword !== '') {
    $stmt = $conn->prepare("SELECT id, name FROM products WHERE name LIKE :kw ORDER BY name LIMIT 8");
    $kw = "%$keyword%";
    $stmt->bindParam(':kw', $kw, PDO::PARAM_STR);
    $stmt->execute();
    $suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($suggestions); 