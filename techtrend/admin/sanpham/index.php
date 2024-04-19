<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Truy vấn CSDL
$query = "SELECT product_id, product_name, price, background_image, configuration, product_info FROM products";

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
    <title>Sản phẩm</title>
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
                <h2 class="my-4">Danh sách sản phẩm</h2>
                <div class="mb-3">
                    <a href="create.php" class="btn btn-success"><i class="fas fa-plus"></i> Tạo mới sản phẩm</a>
                </div>

                <!-- Table to display product list -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Thông tin sản phẩm</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Hiển thị dữ liệu từ CSDL
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['product_id']}</td>";
                            echo "<td>{$row['product_name']}</td>";
                            echo "<td>" . number_format($row['price'], 0, ',', '.') . " VNĐ</td>";
                            echo "<td><img src='{$row['background_image']}' alt='Ảnh sản phẩm' width='50'></td>";
                            echo "<td>
                                    <a href='#' class='btn btn-info btn-sm view-product' data-toggle='modal' data-target='#productDetailModal' data-product-id='{$row['product_id']}'><i class='fas fa-eye'></i> Xem chi tiết</a>
                                </td>";
                            echo "<td>
                                <a href='edit.php?product_id={$row['product_id']}' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Chỉnh sửa</a>
                                <a href='delete.php?product_id={$row['product_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')\"><i class='fas fa-trash-alt'></i> Xóa</a>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Modal xem chi tiết -->
                <div class='modal fade' id='productDetailModal' tabindex='-1' role='dialog' aria-labelledby='productDetailModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='productDetailModalLabel'>Xem chi tiết Sản phẩm</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <!-- Nội dung chi tiết sản phẩm sẽ được hiển thị ở đây -->
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../admin/js.php';
    ?>

    <script>
        // JavaScript để xử lý sự kiện khi nút xem chi tiết được click
        $('.view-product').click(function () {
            var productId = $(this).data('product-id');

            // Gửi yêu cầu AJAX để lấy dữ liệu chi tiết sản phẩm
            $.ajax({
                type: 'GET',
                url: 'get_product_detail.php', // Thay đổi đường dẫn nếu cần
                data: { 'product_id': productId },
                success: function (response) {
                    // Hiển thị dữ liệu chi tiết sản phẩm trong modal
                    $('#productDetailModal .modal-body').html(response);
                }
            });
        });
    </script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>

<?php
// Giải phóng bộ nhớ
mysqli_free_result($result);

// Đóng kết nối CSDL
mysqli_close($conn);
?>
