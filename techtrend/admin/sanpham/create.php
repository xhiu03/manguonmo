<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Lấy danh sách danh mục từ CSDL
$categoryQuery = "SELECT * FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);

// Lấy danh sách thương hiệu từ CSDL
$brandQuery = "SELECT brand_id, brand_name, brand_image FROM brands";
$brandResult = mysqli_query($conn, $brandQuery);

// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $configuration = $_POST['configuration'];
    $productInfo = $_POST['product_info'];
    $categoryId = $_POST['category_id'];
    $brandId = $_POST['brand_id'];

    // Xử lý ảnh sản phẩm
    $targetDir = "../assets/img/imgproducts/";

    // Lấy ngày tháng năm hiện tại
    $currentDate = date("YmdHis");

    // Upload ảnh mô tả sản phẩm
    $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["background_image"]["name"]);
    move_uploaded_file($_FILES["background_image"]["tmp_name"], $targetFile);

    // Insert dữ liệu vào bảng products
    $insertProductQuery = "INSERT INTO products (product_name, price, background_image, configuration, product_info, category_id, brand_id) 
                           VALUES ('$productName', '$price', '$targetFile', '$configuration', '$productInfo', '$categoryId', '$brandId')";
    mysqli_query($conn, $insertProductQuery);

    // Lấy product_id của sản phẩm vừa thêm
    $productId = mysqli_insert_id($conn);

    // Upload và lưu trữ ảnh mô tả sản phẩm
    if (!empty($_FILES["description_images"]["name"])) {
        foreach ($_FILES["description_images"]["name"] as $key => $image) {
            $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["description_images"]["name"][$key]);
            move_uploaded_file($_FILES["description_images"]["tmp_name"][$key], $targetFile);

            // Insert dữ liệu vào bảng product_images
            $insertImageQuery = "INSERT INTO product_images (product_id, image_url) 
                                VALUES ('$productId', '$targetFile')";
            mysqli_query($conn, $insertImageQuery);
        }
    }

    // Chuyển hướng về trang danh sách sản phẩm sau khi thêm mới
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
    <title>Tạo mới sản phẩm</title>
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
                <h2 class="my-4">Tạo mới sản phẩm</h2>

                <!-- Form tạo mới sản phẩm -->
                <form action="create.php" method="post" enctype="multipart/form-data">
                    <!-- Các trường thông tin sản phẩm -->
                    <!-- ... (giữ nguyên phần cũ) ... -->
                    <div class="form-group">
                        <label for="product_name">Tên sản phẩm:</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Danh mục:</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php
                            // Hiển thị danh sách danh mục trong dropdown
                            while ($category = mysqli_fetch_assoc($categoryResult)) {
                                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">Thương hiệu:</label>
                        <select class="form-control" id="brand_id" name="brand_id" required>
                            <?php
                            // Hiển thị danh sách thương hiệu trong dropdown
                            while ($brand = mysqli_fetch_assoc($brandResult)) {
                                echo "<option value='{$brand['brand_id']}'>{$brand['brand_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá:</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>

                    <!-- Mô tả ảnh và ảnh nhiều -->
                    <div class="form-group">
                        <label for="background_image">Ảnh mô tả sản phẩm:</label>
                        <input type="file" class="form-control-file" id="background_image" name="background_image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="description_images">Ảnh mô tả sản phẩm (nhiều):</label>
                        <input type="file" class="form-control-file" id="description_images" name="description_images[]" accept="image/*" multiple>
                    </div>

                    <div class="form-group">
                        <label for="configuration">Cấu hình sản phẩm:</label>
                        <textarea class="form-control" id="configuration" name="configuration"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product_info">Thông tin sản phẩm:</label>
                        <textarea class="form-control" id="product_info" name="product_info"></textarea>
                    </div>
                    <!-- Nút tạo mới -->
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </form>

            </main>
        </div>
    </div>

    <script>
        CKEDITOR.replace('configuration');
        CKEDITOR.replace('product_info');
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
