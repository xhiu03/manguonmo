<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra nếu có brand_id được truyền từ URL
if (isset($_GET['brand_id'])) {
    $brandId = $_GET['brand_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết thương hiệu
    $query = "SELECT brand_image FROM brands WHERE brand_id = $brandId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Xóa ảnh thương hiệu từ thư mục
        $imagePath = $row['brand_image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Xóa thông tin thương hiệu từ CSDL
        $deleteBrandQuery = "DELETE FROM brands WHERE brand_id = $brandId";
        mysqli_query($conn, $deleteBrandQuery);

        // Chuyển hướng về trang danh sách thương hiệu sau khi xóa
        header("Location: index.php");
        exit();
    } else {
        // Hiển thị thông báo nếu không tìm thấy thương hiệu
        echo "Không tìm thấy thương hiệu";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có brand_id
    echo "Không có thương hiệu để xóa";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa thương hiệu</title>
</head>

<body>
    <!-- Nội dung trang xóa thương hiệu (nếu cần) -->
</body>

</html>

<?php
// Đóng kết nối CSDL
mysqli_close($conn);
?>
