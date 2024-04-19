<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra nếu có brand_id được truyền từ URL
if (isset($_GET['brand_id'])) {
    $brandId = $_GET['brand_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết thương hiệu
    $query = "SELECT * FROM brands WHERE brand_id = $brandId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Hiển thị thông báo nếu không tìm thấy thương hiệu
        echo "Không tìm thấy thương hiệu";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có brand_id
    echo "Không có thương hiệu để hiển thị";
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $brandName = $_POST['brand_name'];

    // Xử lý ảnh thương hiệu
    $targetDir = "../assets/img/imgbrand/";

    // Lấy ngày tháng năm hiện tại
    $currentDate = date("YmdHis");

    // Upload ảnh thương hiệu
    $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["brand_image"]["name"]);
    move_uploaded_file($_FILES["brand_image"]["tmp_name"], $targetFile);

    // Cập nhật thông tin thương hiệu trong bảng brands
    $updateBrandQuery = "UPDATE brands SET 
                           brand_name = '$brandName', 
                           brand_image = '$targetFile' 
                           WHERE brand_id = $brandId";

    mysqli_query($conn, $updateBrandQuery);

    // Chuyển hướng về trang danh sách thương hiệu sau khi cập nhật
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>Chỉnh sửa thương hiệu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <?php
    // Include header
    include_once '../header.php';
    ?>
    <?php
    include_once '../sidebar.php';
    ?>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2 class="my-4">Chỉnh sửa thương hiệu</h2>

                <!-- Form chỉnh sửa thương hiệu -->
                <form action="edit.php?brand_id=<?php echo $brandId; ?>" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin thương hiệu -->
                    <div class="form-group">
                        <label for="brand_name">Tên thương hiệu:</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" value="<?php echo $row['brand_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="brand_image">Ảnh thương hiệu:</label>
                        <input type="file" class="form-control-file" id="brand_image" name="brand_image" accept="image/*">
                        <img src="<?php echo $row['brand_image']; ?>" alt="Ảnh thương hiệu" width="100">
                    </div>
                    <!-- Nút cập nhật -->
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>

            </main>
        </div>
    </div>

</body>
<?php
include_once __DIR__ . '/../../admin/js.php';
?>

</html>

<?php
// Đóng kết nối CSDL
mysqli_close($conn);
?>
