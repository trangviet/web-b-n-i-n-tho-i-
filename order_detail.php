<?php
require_once 'config/database.php';
require_once 'includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
if (!isset($_GET['id'])) {
    header('Location: orders.php');
    exit();
}
$order_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$order) {
    echo '<div class="container py-5"><div class="alert alert-danger">Không tìm thấy đơn hàng.</div></div>';
    require_once 'includes/footer.php';
    exit();
}
// Lấy sản phẩm trong đơn
$stmt = $conn->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
    <h2 class="section-title mb-4">Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>
    <div class="mb-3"><b>Ngày đặt:</b> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></div>
    <div class="mb-3"><b>Trạng thái:</b> <?php echo htmlspecialchars($order['status']); ?></div>
    <div class="mb-3"><b>Tổng tiền:</b> <span class="text-danger"><?php echo number_format($order['total'], 0, ',', '.'); ?> VNĐ</span></div>
    <h5 class="mt-4 mb-3">Sản phẩm trong đơn</h5>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width:60px;height:60px;object-fit:cover;"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="orders.php" class="btn btn-outline-primary mt-3">Quay lại danh sách đơn hàng</a>
</div>
<?php require_once 'includes/footer.php'; ?> 