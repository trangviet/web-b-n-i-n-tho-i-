<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($product_id <= 0 || $quantity <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ'
        ]);
        exit;
    }

    // Kiểm tra sản phẩm tồn tại
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại'
        ]);
        exit;
    }

    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    }

    // Tính tổng số lượng sản phẩm trong giỏ hàng
    $total_items = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Đã thêm sản phẩm vào giỏ hàng',
        'cart_count' => $total_items
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không được hỗ trợ'
    ]);
} 