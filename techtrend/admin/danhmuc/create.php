<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $categoryName = $_POST['category_name'];
    $categoryContent = $_POST['category_content'];

    // Thêm mới thông tin danh mục vào CSDL
    $insertCategoryQuery = "INSERT INTO categories (category_name, category_content) VALUES ('$categoryName', '$categoryContent')";

    mysqli_query($conn, $insertCategoryQuery);

    // Chuyển hướng về trang danh sách danh mục sau khi thêm mới
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
    <title>Thêm mới Danh mục</title>
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
                <h2 class="my-4">Thêm mới Danh mục</h2>

                <!-- Form thêm mới danh mục -->
                <form action="create.php" method="post">
                    <!-- Các trường thông tin danh mục -->
                    <div class="form-group">
                        <label for="category_name">Tên danh mục:</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <div class="form-group">
                        <label for="category_content">Nội dung danh mục:</label>
                        <textarea class="form-control" id="category_content" name="category_content"></textarea>
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

<?php
// Đóng kết nối CSDL
mysqli_close($conn);
?>
