<?php
require_once 'config/database.php';
require_once 'includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
    <h2 class="section-title mb-4">Đơn hàng của bạn</h2>
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                    <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">Xem</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php require_once 'includes/footer.php'; ?> 