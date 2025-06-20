<?php
require_once 'config/database.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$product_id = $_GET['id'];

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                       FROM products p 
                       JOIN categories c ON p.category_id = c.id 
                       WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: products.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                 class="img-fluid rounded">
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h1 class="mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="mb-2">
                <!-- Đánh giá sao giả lập -->
                <span style="color: #FFD600; font-size: 1.3rem;">
                    <?php for($i=0;$i<5;$i++): ?>
                        <i class="bi bi-star-fill"></i>
                    <?php endfor; ?>
                </span>
                <span class="text-muted ms-2" style="font-size: 1rem;">(<?php echo rand(10, 200); ?> đánh giá)</span>
            </div>
            <p class="text-muted mb-3">Danh mục: <?php echo htmlspecialchars($product['category_name']); ?></p>
            <h2 class="text-danger mb-4"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</h2>
            
            <div class="mb-4">
                <h5>Mô tả sản phẩm:</h5>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <?php if (!empty($product['specs'])): ?>
            <div class="mb-4">
                <h5>Thông số kỹ thuật:</h5>
                <table class="table table-bordered table-sm w-100 bg-white">
                    <tbody>
                    <?php 
                    // specs dạng: "Màn hình: 6.1 inch\nCPU: Apple A15\nRAM: 6GB"
                    $specs = explode("\n", $product['specs']);
                    foreach($specs as $spec): 
                        $parts = explode(':', $spec, 2);
                        if(count($parts) == 2): ?>
                        <tr>
                            <th style="width:40%;background:#f8f9fa;"><?php echo htmlspecialchars(trim($parts[0])); ?></th>
                            <td><?php echo htmlspecialchars(trim($parts[1])); ?></td>
                        </tr>
                    <?php endif; endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <?php if (!empty($product['features'])): ?>
            <div class="mb-4">
                <h5>Điểm nổi bật:</h5>
                <ul>
                <?php foreach(explode("\n", $product['features']) as $feature): ?>
                    <li><?php echo htmlspecialchars($feature); ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="mb-4">
                <h5>Tình trạng:</h5>
                <p class="<?php echo $product['stock'] > 0 ? 'text-success' : 'text-danger'; ?>">
                    <?php echo $product['stock'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                </p>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" onclick="addToCart(<?php echo $product['id']; ?>)">
                        Thêm vào giỏ hàng
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Sản phẩm liên quan</h3>
            <div class="row">
                <?php
                $stmt = $conn->prepare("SELECT * FROM products 
                                      WHERE category_id = ? AND id != ? 
                                      ORDER BY created_at DESC LIMIT 4");
                $stmt->execute([$product['category_id'], $product['id']]);
                $related_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($related_products as $related): ?>
                    <div class="col-md-3 mb-4">
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($related['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($related['name']); ?>" 
                                 class="img-fluid mb-3">
                            <h5><?php echo htmlspecialchars($related['name']); ?></h5>
                            <p class="price"><?php echo number_format($related['price'], 0, ',', '.'); ?> VNĐ</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="addToCart(<?php echo $related['id']; ?>)">
                                    Thêm vào giỏ hàng
                                </button>
                                <a href="product_detail.php?id=<?php echo $related['id']; ?>" class="btn btn-outline-primary">
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