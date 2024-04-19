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
    } else {
        // Hiển thị thông báo nếu không tìm thấy banner
        echo "Không tìm thấy banner";
        exit();
    }
} else {
    // Hiển thị thông báo nếu không có banner_id
    echo "Không có banner để hiển thị";
    exit();
}

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

    // Kiểm tra xem người dùng có tải lên ảnh mới không
    if (!empty($_FILES["banner_image"]["name"])) {
        // Nếu có, thực hiện upload ảnh mới
        $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["banner_image"]["name"]);
        move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile);
        
        // Cập nhật thông tin banner trong CSDL với ảnh mới
        $updateBannerQuery = "UPDATE banners SET 
                            banner_name = '$bannerName', 
                            banner_image = '$targetFile', 
                            content = '$content', 
                            link = '$link' 
                            WHERE banner_id = $bannerId";
    } else {
        // Nếu không có ảnh mới, chỉ cập nhật thông tin khác và giữ lại ảnh cũ
        $updateBannerQuery = "UPDATE banners SET 
                            banner_name = '$bannerName', 
                            content = '$content', 
                            link = '$link' 
                            WHERE banner_id = $bannerId";
    }

    mysqli_query($conn, $updateBannerQuery);

    // Chuyển hướng về trang danh sách banner sau khi cập nhật
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
    <title>Chỉnh sửa Banner</title>
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
                <h2 class="my-4">Chỉnh sửa Banner</h2>

                <!-- Form chỉnh sửa banner -->
                <form action="edit.php?banner_id=<?php echo $bannerId; ?>" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin banner -->
                    <div class="form-group">
                        <label for="banner_name">Tên banner:</label>
                        <input type="text" class="form-control" id="banner_name" name="banner_name" value="<?php echo $row['banner_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="banner_image">Ảnh banner:</label>
                        <input type="file" class="form-control-file" id="banner_image" name="banner_image" accept="image/*">
                        <img src="<?php echo $row['banner_image']; ?>" alt="Ảnh banner" width="100">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung:</label>
                        <textarea class="form-control" id="content" name="content"><?php echo $row['content']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link:</label>
                        <input type="text" class="form-control" id="link" name="link" value="<?php echo $row['link']; ?>">
                    </div>
                    <!-- Nút cập nhật -->
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>

            </main>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../admin/js.php';
    ?>

</body>

</html>

<?php
// Giải phóng bộ nhớ
mysqli_free_result($result);

// Đóng kết nối CSDL
mysqli_close($conn);
?>
