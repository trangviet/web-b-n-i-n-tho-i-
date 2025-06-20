<?php
require_once 'config/database.php';
require_once 'includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
    <h2 class="section-title mb-4">Tài khoản của bạn</h2>
    <div class="card p-4 mb-4">
        <h4>Thông tin cá nhân</h4>
        <table class="table table-borderless mb-0">
            <tr><th>Tên đăng nhập:</th><td><?php echo htmlspecialchars($user['username']); ?></td></tr>
            <tr><th>Email:</th><td><?php echo htmlspecialchars($user['email']); ?></td></tr>
            <tr><th>Ngày đăng ký:</th><td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td></tr>
        </table>
    </div>
    <a href="orders.php" class="btn btn-outline-primary">Xem đơn hàng của bạn</a>
</div>
<?php require_once 'includes/footer.php'; ?> 