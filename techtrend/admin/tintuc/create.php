<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $newsName = $_POST['news_name'];
    $content = $_POST['content'];

    // Xử lý ảnh tin tức
    $targetDir = "../assets/img/imgnews/";

    // Lấy ngày tháng năm hiện tại
    $currentDate = date("YmdHis");

    // Upload ảnh tin tức
    $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["news_image"]["name"]);
    move_uploaded_file($_FILES["news_image"]["tmp_name"], $targetFile);

    // Thêm tin tức vào CSDL
    $insertNewsQuery = "INSERT INTO news (news_name, news_image, content) 
                        VALUES ('$newsName', '$targetFile', '$content')";

    mysqli_query($conn, $insertNewsQuery);

    // Chuyển hướng về trang danh sách tin tức sau khi thêm mới
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
    <title>Tạo tin tức mới</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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
                <h2 class="my-4">Tạo tin tức mới</h2>

                <!-- Form tạo tin tức mới -->
                <form action="create.php" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin tin tức -->
                    <div class="form-group">
                        <label for="news_name">Tiêu đề tin tức:</label>
                        <input type="text" class="form-control" id="news_name" name="news_name" required>
                    </div>
                    <div class="form-group">
                        <label for="news_image">Ảnh tin tức:</label>
                        <input type="file" class="form-control-file" id="news_image" name="news_image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung tin tức:</label>
                        <textarea class="form-control" id="content" name="content" required></textarea>
                    </div>
                    <!-- Nút tạo mới -->
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </form>

            </main>
        </div>
    </div>

    <script>
        CKEDITOR.replace('content');
    </script>

</body>
<?php
include_once __DIR__ . '/../../admin/js.php';
?>

</html>

<?php
// Đóng kết nối CSDL
mysqli_close($conn);
?>
