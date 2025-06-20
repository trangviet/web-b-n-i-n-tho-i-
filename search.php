<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// Lấy từ khóa tìm kiếm
$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$products = [];

if ($keyword !== '') {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :kw OR description LIKE :kw ORDER BY created_at DESC");
    $kw = "%$keyword%";
    $stmt->bindParam(':kw', $kw, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container py-5">
    <h2 class="section-title mb-4">Kết quả tìm kiếm cho: <span style="color: var(--primary-color)"><?php echo htmlspecialchars($keyword); ?></span></h2>
    <?php if ($keyword === ''): ?>
        <div class="alert alert-warning">Vui lòng nhập từ khóa tìm kiếm.</div>
    <?php elseif (empty($products)): ?>
        <div class="alert alert-danger">Không tìm thấy sản phẩm nào phù hợp với từ khóa <b><?php echo htmlspecialchars($keyword); ?></b>.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="product-card">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title"><?php echo $product['name']; ?></h3>
                            <p class="product-price"><?php echo number_format($product['price']); ?> VNĐ</p>
                            <div class="product-actions">
                                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">Chi tiết</a>
                                <button class="btn btn-primary add-to-cart" data-id="<?php echo $product['id']; ?>">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?> 