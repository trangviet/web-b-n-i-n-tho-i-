<?php
session_start();
require_once 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit();
    }
    $error = 'Sai tài khoản hoặc mật khẩu!';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>body{background:#f5f6fa;}</style>
</head>
<body>
<div class="container" style="max-width:400px;margin-top:80px;">
    <div class="card p-4 shadow">
        <h3 class="mb-3 text-center">Đăng nhập</h3>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Đăng nhập</button>
        </form>
        <div class="text-center mt-3">
            <span>Bạn là quản trị viên? <a href="admin/login.php">Đăng nhập admin tại đây</a></span>
        </div>
    </div>
</div>
</body>
</html> 