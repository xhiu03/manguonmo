<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $bannerName = $_POST['banner_name'];
    $content = $_POST['content'];
    $link = $_POST['link'];

    // Xử lý ảnh banner
    $targetDir = "../assets/img/imgbanners/";    

    // Lấy ngày tháng năm hiện tại
    $currentDate = date("YmdHis");

    // Upload ảnh banner
    $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["banner_image"]["name"]);
    move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile);

    // Thêm mới thông tin banner vào CSDL
    $insertBannerQuery = "INSERT INTO banners (banner_name, banner_image, content, link) VALUES ('$bannerName', '$targetFile', '$content', '$link')";

    mysqli_query($conn, $insertBannerQuery);

    // Chuyển hướng về trang danh sách banner sau khi thêm mới
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
    <title>Thêm mới Banner</title>
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
                <h2 class="my-4">Thêm mới Banner</h2>

                <!-- Form thêm mới banner -->
                <form action="create.php" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin banner -->
                    <div class="form-group">
                        <label for="banner_name">Tên banner:</label>
                        <input type="text" class="form-control" id="banner_name" name="banner_name" required>
                    </div>
                    <div class="form-group">
                        <label for="banner_image">Ảnh banner:</label>
                        <input type="file" class="form-control-file" id="banner_image" name="banner_image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung:</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link:</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                    <!-- Nút thêm mới -->
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>

            </main>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../admin/js.php';
    ?>

</body>

</html>