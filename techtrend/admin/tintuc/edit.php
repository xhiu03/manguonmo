<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra xem có tham số news_id được truyền không
if (isset($_GET['news_id'])) {
    $newsId = $_GET['news_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết tin tức
    $query = "SELECT * FROM news WHERE news_id = $newsId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Hiển thị thông báo nếu không tìm thấy tin tức
        echo "Không tìm thấy tin tức";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có news_id
    echo "Không có tin tức để hiển thị";
    exit();
}

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

    // Cập nhật thông tin tin tức trong bảng news
    $updateNewsQuery = "UPDATE news SET 
                       news_name = '$newsName', 
                       news_image = '$targetFile', 
                       content = '$content' 
                       WHERE news_id = $newsId";

    mysqli_query($conn, $updateNewsQuery);

    // Chuyển hướng về trang danh sách tin tức sau khi cập nhật
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
    <title>Chỉnh sửa tin tức</title>
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
                <h2 class="my-4">Chỉnh sửa tin tức</h2>

                <!-- Form chỉnh sửa tin tức -->
                <form action="edit.php?news_id=<?php echo $newsId; ?>" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin tin tức -->
                    <div class="form-group">
                        <label for="news_name">Tiêu đề tin tức:</label>
                        <input type="text" class="form-control" id="news_name" name="news_name" value="<?php echo $row['news_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="news_image">Ảnh tin tức:</label>
                        <input type="file" class="form-control-file" id="news_image" name="news_image" accept="image/*">
                        <img src="<?php echo $row['news_image']; ?>" alt="Ảnh tin tức" width="100">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung tin tức:</label>
                        <textarea class="form-control" id="content" name="content"><?php echo $row['content']; ?></textarea>
                        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                        <script>
                            CKEDITOR.replace('content');
                        </script>
                    </div>
                    <!-- Nút cập nhật -->
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>

            </main>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
</body>
<?php
include_once __DIR__ . '/../../admin/js.php';
?>

</html>

<?php
// Giải phóng bộ nhớ
mysqli_free_result($result);

// Đóng kết nối CSDL
mysqli_close($conn);
?>