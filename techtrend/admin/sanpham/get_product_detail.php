<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra xem có tham số product_id được truyền không
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết sản phẩm
    $query = "SELECT products.product_id, products.product_name, products.price, products.background_image, products.configuration, products.product_info, categories.category_name, brands.brand_name
              FROM products
              INNER JOIN categories ON products.category_id = categories.category_id
              INNER JOIN brands ON products.brand_id = brands.brand_id
              WHERE products.product_id = $productId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Hiển thị thông tin chi tiết sản phẩm
        echo "<p><strong>ID:</strong> {$row['product_id']}</p>";
        echo "<p><strong>Tên sản phẩm:</strong> {$row['product_name']}</p>";
        echo "<p><strong>Danh mục:</strong> {$row['category_name']}</p>";
        echo "<p><strong>Thương hiệu:</strong> {$row['brand_name']}</p>";
        echo "<p><strong>Giá:</strong> " . number_format($row['price'], 0, ',', '.') . " VNĐ</p>";
        echo "<p><strong>Ảnh sản phẩm:</strong></p>";
        echo "<img src='{$row['background_image']}' alt='Ảnh sản phẩm' width='100'>";
        echo "<p><strong>Thông số kỹ thuật:</strong> {$row['configuration']}</p>";
        echo "<p><strong>Thông tin sản phẩm:</strong> {$row['product_info']}</p>";
    } else {
        // Hiển thị thông báo nếu không tìm thấy sản phẩm
        echo "Không tìm thấy sản phẩm";
    }
} else {
    // Hiển thị thông báo nếu không có product_id
    echo "Không có sản phẩm để hiển thị";
}

// Giải phóng bộ nhớ
mysqli_free_result($result);

// Đóng kết nối CSDL
mysqli_close($conn);
?>
