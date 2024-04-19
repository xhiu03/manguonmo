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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>Xem chi tiết tin tức</title>
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
                <h2 class="my-4">Xem chi tiết tin tức</h2>

                <!-- Hiển thị thông tin chi tiết tin tức -->
                <div class="card">
                    <img class="card-img-top" src="<?php echo $row['news_image']; ?>" alt="Ảnh tin tức">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['news_name']; ?></h5>
                        <p class="card-text"><?php echo $row['content']; ?></p>
                    </div>
                </div>

                <a href="index.php" class="btn btn-secondary mt-3">Quay lại danh sách tin tức</a>

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
