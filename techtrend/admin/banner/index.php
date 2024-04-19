<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Truy vấn CSDL
$query = "SELECT banner_id, banner_name, banner_image, content, link FROM banners";

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
    <title>Quản lý Banners</title>
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
                <h2 class="my-4">Danh sách Banners</h2>
                <div class="mb-3">
                    <a href="create.php" class="btn btn-success"><i class="fas fa-plus"></i> Tạo mới Banner</a>
                </div>

                <!-- Table to display banner list -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên banner</th>
                            <th>Ảnh banner</th>
                            <th>Nội dung</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Hiển thị dữ liệu từ CSDL
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['banner_id']}</td>";
                            echo "<td>{$row['banner_name']}</td>";
                            echo "<td><img src='{$row['banner_image']}' alt='Ảnh banner' width='100'></td>";
                            echo "<td>
                                    <button class='btn btn-info btn-sm view-detail' 
                                            data-banner-id='{$row['banner_id']}' 
                                            data-banner-name='{$row['banner_name']}' 
                                            data-banner-image='{$row['banner_image']}' 
                                            data-banner-content='{$row['content']}' 
                                    ><i class='fas fa-eye'></i> Xem chi tiết</button>
                                </td>";
                            echo "<td>
                                    <a href='edit.php?banner_id={$row['banner_id']}' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Chỉnh sửa</a>
                                    <a href='delete.php?banner_id={$row['banner_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xóa banner này không?')\"><i class='fas fa-trash-alt'></i> Xóa</a>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Modal xem chi tiết -->
                <div class="modal fade" id="bannerDetailModal" tabindex="-1" role="dialog" aria-labelledby="bannerDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bannerDetailModalLabel">Xem chi tiết Banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong>ID:</strong> <span id="bannerId"></span></p>
                                <p><strong>Tên banner:</strong> <span id="bannerName"></span></p>
                                <p><strong>Ảnh banner:</strong></p>
                                <img src="" alt="Ảnh banner" id="bannerImage" width="100">
                                <p><strong>Nội dung:</strong> <span id="bannerContent"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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
        // Sử dụng jQuery để xử lý sự kiện khi nút xem chi tiết được click
        $('.view-detail').on('click', function() {
            // Lấy thông tin từ thuộc tính data-*
            var bannerId = $(this).data('banner-id');
            var bannerName = $(this).data('banner-name');
            var bannerImage = $(this).data('banner-image');
            var bannerContent = $(this).data('banner-content');

            // Đặt thông tin vào modal
            $('#bannerId').text(bannerId);
            $('#bannerName').text(bannerName);
            $('#bannerImage').attr('src', bannerImage);
            $('#bannerContent').text(bannerContent);

            // Mở modal
            $('#bannerDetailModal').modal('show');
        });
    </script>

</body>

</html>

<?php
// Giải phóng bộ nhớ
mysqli_free_result($result);

// Đóng kết nối CSDL
mysqli_close($conn);
?>
