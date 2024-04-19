<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Truy vấn CSDL
$query = "SELECT category_id, category_name, category_content FROM categories";

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
    <title>Danh mục</title>
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
                <h2 class="my-4">Danh sách danh mục</h2>
                <div class="mb-3">
                    <a href="create.php" class="btn btn-success"><i class="fas fa-plus"></i> Tạo mới danh mục</a>
                </div>

                <!-- Table to display category list -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Hiển thị dữ liệu từ CSDL
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['category_id']}</td>";
                            echo "<td>{$row['category_name']}</td>";
                            echo "<td>
                                    <a href='edit.php?category_id={$row['category_id']}' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Chỉnh sửa</a>
                                    <a href='delete.php?category_id={$row['category_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')\"><i class='fas fa-trash-alt'></i> Xóa</a>
                                    <a href='#' class='btn btn-info btn-sm' data-toggle='modal' data-target='#categoryDetailModal{$row['category_id']}'><i class='fas fa-eye'></i> Xem chi tiết</a>
                                </td>";
                            echo "</tr>";
                            // Modal xem chi tiết
                            echo "<div class='modal fade' id='categoryDetailModal{$row['category_id']}' tabindex='-1' role='dialog' aria-labelledby='categoryDetailModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='categoryDetailModalLabel'>Xem chi tiết Danh mục</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <p><strong>ID:</strong> {$row['category_id']}</p>
                                                <p><strong>Tên danh mục:</strong> {$row['category_name']}</p>
                                                <p><strong>Nội dung danh mục:</strong> {$row['category_content']}</p>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                        ?>
                    </tbody>
                </table>
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
