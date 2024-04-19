<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Kiểm tra nếu có product_id được truyền từ URL
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Truy vấn CSDL để lấy thông tin chi tiết sản phẩm
    $query = "SELECT * FROM products WHERE product_id = $productId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Hiển thị thông báo nếu không tìm thấy sản phẩm
        echo "Không tìm thấy sản phẩm";
        exit();
    }

    // Truy vấn CSDL để lấy ảnh mô tả nhỏ
    $queryImages = "SELECT image_url FROM product_images WHERE product_id = $productId";
    $resultImages = mysqli_query($conn, $queryImages);
    $images = mysqli_fetch_all($resultImages, MYSQLI_ASSOC);
} else {
    // Hiển thị thông báo nếu không có product_id
    echo "Không có sản phẩm để hiển thị";
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
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Thêm CSS để tạo khoảng cách giữa cấu hình và thông tin sản phẩm */
        .product_info_class {
            margin-top: 250px;
            margin-left: -100%;
        }

        /* Thêm CSS để căn giữa ảnh mô tả nhỏ */
        .thumbnail-image {
            text-align: center;
        }
    </style>
</head>

<body>

    <?php
    // Include header
    include_once '../header.php';
    ?>
    <?php
    include_once '../sidebar.php';
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 thumbnail-image">
                <img src="<?php echo $row['background_image']; ?>" alt="Ảnh sản phẩm" class="img-fluid mb-3">
                <!-- Ảnh mô tả nhỏ -->
                <div class="row">
                    <?php foreach ($images as $image) : ?>
                        <div class="col-3">
                            <img src="<?php echo $image['image_url']; ?>" alt="Ảnh mô tả" class="img-fluid">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 product-details">
                <h2 class="mb-4"><?php echo $row['product_name']; ?></h2>
                <p><strong>Giá:</strong> <?php echo number_format($row['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                <!-- Cấu hình và thông tin sản phẩm dưới hình ảnh -->
                <div class="mb-3 product_info_class">
                    <strong>Cấu hình sản phẩm:</strong><br><?php echo $row['configuration']; ?>
                </div>
                <div class="mb-3 product_info_class">
                    <strong>Thông tin sản phẩm:</strong><br><?php echo $row['product_info']; ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php
// Giải phóng bộ nhớ
mysqli_free_result($result);
mysqli_free_result($resultImages);

// Đóng kết nối CSDL
mysqli_close($conn);
?>
