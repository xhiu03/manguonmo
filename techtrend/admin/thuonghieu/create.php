<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra nếu có dữ liệu được gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $brandName = $_POST['brand_name'];

    // Xử lý ảnh thương hiệu
    $targetDir = "/../../assets/img/imgbrand/";

    // Lấy ngày tháng năm hiện tại
    $currentDate = date("YmdHis");

    // Upload ảnh thương hiệu
    $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["brand_image"]["name"]);
    move_uploaded_file($_FILES["brand_image"]["tmp_name"], $targetFile);

    // Thực hiện truy vấn để thêm mới thương hiệu
    $insertBrandQuery = "INSERT INTO brands (brand_name, brand_image) 
                        VALUES ('$brandName', '$targetFile')";

    mysqli_query($conn, $insertBrandQuery);

    // Chuyển hướng về trang danh sách thương hiệu sau khi thêm mới
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
    <title>Thêm mới thương hiệu</title>
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
                <h2 class="my-4">Thêm mới thương hiệu</h2>

                <!-- Form thêm mới thương hiệu -->
                <form action="create.php" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin thương hiệu -->
                    <div class="form-group">
                        <label for="brand_name">Tên thương hiệu:</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" required>
                    </div>
                    <div class="form-group">
                        <label for="brand_image">Ảnh thương hiệu:</label>
                        <input type="file" class="form-control-file" id="brand_image" name="brand_image" accept="image/*" required>
                    </div>
                    <!-- Nút thêm mới -->
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
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
