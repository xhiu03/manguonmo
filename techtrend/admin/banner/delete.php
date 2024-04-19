<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra xem có tham số banner_id được truyền không
if (isset($_GET['banner_id'])) {
    $bannerId = $_GET['banner_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết banner
    $query = "SELECT * FROM banners WHERE banner_id = $bannerId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Xóa ảnh banner từ thư mục
        unlink($row['banner_image']);

        // Xóa banner từ CSDL
        $deleteBannerQuery = "DELETE FROM banners WHERE banner_id = $bannerId";
        mysqli_query($conn, $deleteBannerQuery);

        // Chuyển hướng về trang danh sách banner sau khi xóa
        header("Location: index.php");
        exit();
    } else {
        // Hiển thị thông báo nếu không tìm thấy banner
        echo "Không tìm thấy banner";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có banner_id
    echo "Không có banner để xóa";
    exit();
}
?>
