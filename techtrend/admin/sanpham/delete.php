<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra nếu có product_id được truyền từ URL
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết sản phẩm
    $query = "SELECT * FROM products WHERE product_id = $productId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Xóa ảnh mô tả sản phẩm
        $backgroundImage = $row['background_image'];
        if (file_exists($backgroundImage)) {
            unlink($backgroundImage);
        }

        // Xóa thông tin sản phẩm từ bảng products
        $deleteProductQuery = "DELETE FROM products WHERE product_id = $productId";
        mysqli_query($conn, $deleteProductQuery);

        // Xóa ảnh mô tả sản phẩm từ bảng product_images
        $deleteImagesQuery = "DELETE FROM product_images WHERE product_id = $productId";
        mysqli_query($conn, $deleteImagesQuery);

        // Chuyển hướng về trang danh sách sản phẩm sau khi xóa
        header("Location: index.php");
        exit();
    } else {
        // Hiển thị thông báo nếu không tìm thấy sản phẩm
        echo "Không tìm thấy sản phẩm";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có product_id
    echo "Không có sản phẩm để xóa";
    exit();
}

// Đóng kết nối CSDL
mysqli_close($conn);
?>
