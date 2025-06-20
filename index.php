<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// Lấy sản phẩm mới nhất
$latest_products_query = "SELECT * FROM products ORDER BY created_at DESC LIMIT 12";
$latest_products = $conn->query($latest_products_query);

// Lấy sản phẩm bán chạy
$popular_products_query = "SELECT p.*, COUNT(oi.id) as order_count 
                         FROM products p 
                         LEFT JOIN order_items oi ON p.id = oi.product_id 
                         GROUP BY p.id 
                         ORDER BY order_count DESC 
                         LIMIT 12";
$popular_products = $conn->query($popular_products_query);

// Lấy danh mục sản phẩm
$categories_query = "SELECT * FROM categories";
$categories = $conn->query($categories_query);
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 mb-4">Khám phá công nghệ mới nhất</h1>
                <p class="lead mb-4">Chúng tôi cung cấp những sản phẩm công nghệ chất lượng cao với giá cả phải chăng</p>
                <a href="products.php" class="btn btn-primary btn-lg">Mua sắm ngay</a>
            </div>
            <div class="col-md-6">
                <img src="assets/images/hero-image.jpg" alt="Hero Image" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-4">Danh mục sản phẩm</h2>
        <div class="row">
            <?php while($category = $categories->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-md-4 mb-4">
                <a href="products.php?category=<?php echo $category['id']; ?>" class="category-card">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-<?php echo $category['icon']; ?> display-4 mb-3"></i>
                            <h3 class="card-title"><?php echo $category['name']; ?></h3>
                            <p class="card-text"><?php echo $category['description']; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="latest-products-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-4">Sản phẩm mới nhất</h2>
        <div class="row">
            <?php while($product = $latest_products->fetch(PDO::FETCH_ASSOC)): ?>
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
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-outline-primary">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<!-- Popular Products Section -->
<section class="popular-products-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-4">Sản phẩm bán chạy</h2>
        <div class="row">
            <?php while($product = $popular_products->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <div class="popular-badge">Bán chạy</div>
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
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="bi bi-truck display-4 mb-3"></i>
                    <h3>Miễn phí vận chuyển</h3>
                    <p>Cho đơn hàng từ 2 triệu đồng</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="bi bi-shield-check display-4 mb-3"></i>
                    <h3>Bảo hành chính hãng</h3>
                    <p>12 tháng cho mọi sản phẩm</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="bi bi-headset display-4 mb-3"></i>
                    <h3>Hỗ trợ 24/7</h3>
                    <p>Luôn sẵn sàng phục vụ</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Đăng ký nhận thông tin</h2>
                <p class="mb-4">Nhận thông tin về sản phẩm mới và khuyến mãi đặc biệt</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Nhập email của bạn">
                        <button class="btn btn-primary" type="submit">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?> 