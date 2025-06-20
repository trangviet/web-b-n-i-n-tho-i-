<?php
require_once 'config/database.php';
require_once 'includes/header.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $user_message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($subject) || empty($user_message)) {
        $message = 'Vui lòng điền đầy đủ tất cả các trường.';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Địa chỉ email không hợp lệ.';
        $message_type = 'error';
    } else {
        // Đây là nơi bạn sẽ xử lý tin nhắn, ví dụ: gửi email hoặc lưu vào database
        // For now, just a success message
        $message = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.';
        $message_type = 'success';
        // In a real application, you would send an email here:
        // mail('your_email@example.com', $subject, "From: $name <$email>\n\n" . $user_message);
    }
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">Liên hệ chúng tôi</h1>
    <p class="text-center lead mb-5">Chúng tôi luôn sẵn lòng lắng nghe và hỗ trợ bạn.</p>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="contact.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên của bạn</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email của bạn</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Chủ đề</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Tin nhắn của bạn</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Gửi tin nhắn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 