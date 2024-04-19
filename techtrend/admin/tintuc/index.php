<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Truy vấn CSDL
$query = "SELECT news_id, news_name, news_image, content FROM news";

// Thực hiện truy vấn
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>Tin tức</title>
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
                <h2 class="my-4">Danh sách tin tức</h2>
                <div class="mb-3">
                    <a href="create.php" class="btn btn-success"><i class="fas fa-plus"></i> Tạo tin tức mới</a>
                </div>

                <!-- Table to display news list -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề tin tức</th>
                            <th>Ảnh tin tức</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Hiển thị dữ liệu từ CSDL
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['news_id']}</td>";
                            echo "<td>{$row['news_name']}</td>";
                            echo "<td><img src='{$row['news_image']}' alt='Ảnh tin tức' width='50'></td>";
                            echo "<td>
                                    <a href='view.php?news_id={$row['news_id']}' class='btn btn-info btn-sm'><i class='fas fa-eye'></i> Xem chi tiết</a>
                                    <a href='edit.php?news_id={$row['news_id']}' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Chỉnh sửa</a>
                                    <a href='delete.php?news_id={$row['news_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xóa tin tức này không?')\"><i class='fas fa-trash-alt'></i> Xóa</a>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

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
