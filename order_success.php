<?php
session_start();
require_once 'config/database.php';
include 'includes/header.php';

if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$order_id = $_GET['order_id'];

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT o.*, u.full_name, u.email, u.phone 
                       FROM orders o 
                       JOIN users u ON o.user_id = u.id 
                       WHERE o.id = ? AND o.user_id = ?");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: index.php');
    exit();
}

// Lấy chi tiết đơn hàng
$stmt = $conn->prepare("SELECT oi.*, p.name, p.image 
                       FROM order_items oi 
                       JOIN products p ON oi.product_id = p.id 
                       WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <h2 class="mt-3">Đặt hàng thành công!</h2>
                    <p class="text-muted">Cảm ơn bạn đã đặt hàng. Mã đơn hàng của bạn là: #<?php echo $order_id; ?></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thông tin người nhận</h6>
                            <p>
                                <strong>Họ và tên:</strong> <?php echo htmlspecialchars($order['full_name']); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?><br>
                                <strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?><br>
                                <strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Thông tin đơn hàng</h6>
                            <p>
                                <strong>Mã đơn hàng:</strong> #<?php echo $order_id; ?><br>
                                <strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?><br>
                                <strong>Trạng thái:</strong> 
                                <span class="badge bg-warning">Đang xử lý</span><br>
                                <strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Chi tiết đơn hàng</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($order_items as $item): ?>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-2">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                     class="img-fluid rounded">
                            </div>
                            <div class="col-md-6">
                                <h6><?php echo htmlspecialchars($item['name']); ?></h6>
                                <p class="text-muted">Số lượng: <?php echo $item['quantity']; ?></p>
                            </div>
                            <div class="col-md-4 text-end">
                                <p class="text-danger fw-bold">
                                    <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="text-danger fw-bold">
                            <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ
                        </span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 