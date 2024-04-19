<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Truy vấn CSDL
$query = "SELECT user_id, email, phone_number, `password`, role FROM users";

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
    <title>Danh sách người dùng</title>
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
                <h2 class="my-4">Danh sách người dùng</h2>
                <div class="mb-3">
                    <!-- Thêm nút tạo mới người dùng nếu cần -->
                </div>

                <!-- Table to display user list -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Hiển thị dữ liệu từ CSDL
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['user_id']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['phone_number']}</td>";
                            echo "<td>" . ($row['role'] == 1 ? 'Admin' : 'Khách Hàng') . "</td>";
                            echo "<td>
                                    <a href='#' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')\"><i class='fas fa-trash-alt'></i> Xóa</a>
                                    <!-- Thêm các nút thao tác khác nếu cần -->
                                </td>";
                            echo "</tr>";
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
