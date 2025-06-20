<?php
require_once 'config/database.php';
include 'includes/header.php';

// Lấy danh mục từ URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Lấy danh sách sản phẩm
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id";
$params = [];

if ($category) {
    $sql .= " WHERE c.slug = ?";
    $params[] = $category;
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách danh mục
$stmt = $conn->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <!-- Sidebar với danh mục -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Danh mục sản phẩm</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="products.php" class="list-group-item list-group-item-action <?php echo !$category ? 'active' : ''; ?>">
                        Tất cả sản phẩm
                    </a>
                    <?php foreach($categories as $cat): ?>
                        <a href="products.php?category=<?php echo $cat['slug']; ?>" 
                           class="list-group-item list-group-item-action <?php echo $category == $cat['slug'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <h2 class="mb-4">
                <?php 
                if ($category) {
                    foreach($categories as $cat) {
                        if ($cat['slug'] == $category) {
                            echo htmlspecialchars($cat['name']);
                            break;
                        }
                    }
                } else {
                    echo "Tất cả sản phẩm";
                }
                ?>
            </h2>

            <div class="row">
                <?php foreach($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="img-fluid mb-3">
                            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></p>
                            <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="addToCart(<?php echo $product['id']; ?>)">
                                    Thêm vào giỏ hàng
                                </button>
                                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 