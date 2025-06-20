<?php
// select_login.php: Trang chọn loại đăng nhập
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chọn loại đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f5f6fa; }
        .login-choice-card { max-width: 400px; margin: 100px auto; border-radius: 12px; }
        .login-choice-btn { font-size: 1.2rem; padding: 1rem; }
    </style>
</head>
<body>
<div class="card login-choice-card shadow p-4 text-center">
    <h3 class="mb-4">Chọn loại đăng nhập</h3>
    <a href="login.php" class="btn btn-primary login-choice-btn w-100 mb-3">Đăng nhập User</a>
    <a href="admin/login.php" class="btn btn-dark login-choice-btn w-100">Đăng nhập Admin</a>
</div>
</body>
</html> 