<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

    if ($product_id <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ'
        ]);
        exit;
    }

    // Kiểm tra sản phẩm tồn tại trong giỏ hàng
    if (!isset($_SESSION['cart'][$product_id])) {
        echo json_encode([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
        ]);
        exit;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    unset($_SESSION['cart'][$product_id]);

    // Tính tổng số lượng sản phẩm trong giỏ hàng
    $total_items = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
        'cart_count' => $total_items
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức không được hỗ trợ'
    ]);
} 