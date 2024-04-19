<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra xem có tham số category_id được truyền không
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];

    // Xóa danh mục từ bảng categories
    $deleteCategoryQuery = "DELETE FROM categories WHERE category_id = $categoryId";

    mysqli_query($conn, $deleteCategoryQuery);

    // Chuyển hướng về trang danh sách danh mục sau khi xóa
    header("Location: index.php");
    exit();
} else {
    // Hiển thị thông báo nếu không có category_id
    echo "Không có danh mục để xóa";
    exit();
}
?>
