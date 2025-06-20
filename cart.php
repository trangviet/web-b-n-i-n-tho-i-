<?php
session_start();
require_once 'config/database.php';
require_once 'includes/header.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Tính tổng tiền
$total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>

<div class="container py-5">
    <h1 class="mb-4">Giỏ hàng</h1>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="row">
            <div class="col-md-8">
                <div class="cart-items">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="cart-item mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid rounded">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1"><?php echo $item['name']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo number_format($item['price']); ?> VNĐ</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="quantity-control">
                                        <button class="btn btn-sm btn-outline-secondary decrease-quantity" data-id="<?php echo $item['id']; ?>">-</button>
                                        <input type="number" class="form-control form-control-sm quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-id="<?php echo $item['id']; ?>">
                                        <button class="btn btn-sm btn-outline-secondary increase-quantity" data-id="<?php echo $item['id']; ?>">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="mb-0 fw-bold"><?php echo number_format($item['price'] * $item['quantity']); ?> VNĐ</p>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-sm btn-danger remove-item" data-id="<?php echo $item['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart-summary">
                    <h3 class="mb-3">Tổng đơn hàng</h3>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span><?php echo number_format($total); ?> VNĐ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="fw-bold text-primary"><?php echo number_format($total); ?> VNĐ</span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary w-100">Thanh toán</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h3 class="mt-3">Giỏ hàng trống</h3>
            <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
            <a href="products.php" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<style>
.cart-item {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-input {
    width: 60px;
    text-align: center;
}

.cart-summary {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

@media (max-width: 768px) {
    .cart-item {
        margin-bottom: 1rem;
    }
    
    .cart-item img {
        margin-bottom: 1rem;
    }
    
    .quantity-control {
        margin: 1rem 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý tăng số lượng
    const increaseButtons = document.querySelectorAll('.increase-quantity');
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
            updateCartItem(input.dataset.id, input.value);
        });
    });

    // Xử lý giảm số lượng
    const decreaseButtons = document.querySelectorAll('.decrease-quantity');
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateCartItem(input.dataset.id, input.value);
            }
        });
    });

    // Xử lý thay đổi số lượng trực tiếp
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 1) {
                this.value = 1;
            }
            updateCartItem(this.dataset.id, this.value);
        });
    });

    // Xử lý xóa sản phẩm
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                removeCartItem(this.dataset.id);
            }
        });
    });

    // Hàm cập nhật số lượng sản phẩm
    function updateCartItem(productId, quantity) {
        fetch('update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Có lỗi xảy ra', 'error');
        });
    }

    // Hàm xóa sản phẩm
    function removeCartItem(productId) {
        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Có lỗi xảy ra', 'error');
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?> 