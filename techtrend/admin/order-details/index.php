<?php
session_start();
include_once '../dbconnect.php';

// Xử lý sự kiện xác nhận đơn hàng
if (isset($_POST['confirm_order'])) {
    $order_id = $_POST['order_id'];

    // Thực hiện cập nhật trạng thái đơn hàng
    $updateQuery = "UPDATE orders SET order_status = 'Đang xử lý' WHERE order_id = $order_id";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Hiển thị thông báo xác nhận đơn hàng thành công
        echo '<script>alert("Đơn hàng đã được xác nhận và đang trong quá trình xử lý.");</script>';
    } else {
        // Hiển thị thông báo lỗi nếu cập nhật không thành công
        echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại sau.");</script>';
    }
}

// Xử lý sự kiện giao hàng thành công
if (isset($_POST['deliver_order'])) {
    $order_id = $_POST['order_id'];

    // Thực hiện cập nhật trạng thái đơn hàng
    $updateQuery = "UPDATE orders SET order_status = 'Giao thành công' WHERE order_id = $order_id";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Hiển thị thông báo giao hàng thành công
        echo '<script>alert("Đơn hàng đã được giao thành công.");</script>';
    } else {
        // Hiển thị thông báo lỗi nếu cập nhật không thành công
        echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại sau.");</script>';
    }
}

// Truy vấn CSDL để lấy danh sách đơn hàng
$query = "SELECT order_id, customer_name, customer_address, customer_email, customer_phone, order_status
          FROM orders";

$result = mysqli_query($conn, $query);
?>

<!-- Phần HTML của trang -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>Quản lý Đơn hàng</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php
    include_once '../header.php';
    include_once '../sidebar.php';
    ?>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2 class="my-4">Danh sách đơn hàng</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['order_id']}</td>";
                            echo "<td>{$row['customer_name']}</td>";
                            echo "<td>{$row['customer_address']}</td>";
                            echo "<td>{$row['customer_email']}</td>";
                            echo "<td>{$row['customer_phone']}</td>";
                            echo "<td>{$row['order_status']}</td>";
                            echo "<td>
                                    <form method='post'>
                                        <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                        <button type='submit' name='confirm_order' class='btn btn-success btn-sm'><i class='fas fa-check'></i> Xác nhận đơn hàng</button>
                                    </form>
                                    <form method='post'>
                                        <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                        <button type='submit' name='deliver_order' class='btn btn-primary btn-sm'><i class='fas fa-truck'></i> Giao hàng thành công</button>
                                    </form>
                                    <a href='#' class='btn btn-info btn-sm' data-toggle='modal' data-target='#orderDetailModal{$row['order_id']}'><i class='fas fa-eye'></i> Xem chi tiết</a>
                                </td>";
                            echo "</tr>";

                            // Modal xem chi tiết đơn hàng
                            echo "<div class='modal fade' id='orderDetailModal{$row['order_id']}' tabindex='-1' role='dialog' aria-labelledby='orderDetailModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='orderDetailModalLabel'>Xem chi tiết Đơn hàng</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>";
                            
                            // Hiển thị chi tiết sản phẩm
                            echo "<p><strong>Tên sản phẩm - Số lượng - Giá tiền:</strong></p>";
                            // Thực hiện truy vấn để lấy chi tiết sản phẩm của đơn hàng
                            $orderDetailsQuery = "SELECT od.product_id, p.product_name, od.quantity, p.price
                                                FROM order_details od
                                                JOIN products p ON od.product_id = p.product_id
                                                WHERE od.order_id = {$row['order_id']}";
                            $orderDetailsResult = mysqli_query($conn, $orderDetailsQuery);
                            
                            if ($orderDetailsResult && mysqli_num_rows($orderDetailsResult) > 0) {
                                while ($orderDetail = mysqli_fetch_assoc($orderDetailsResult)) {
                                    echo "<p>{$orderDetail['product_name']} - {$orderDetail['quantity']} - $" . number_format($orderDetail['price']) . "</p>";
                                }
                            } else {
                                echo "<p>Không có chi tiết sản phẩm cho đơn hàng này.</p>";
                            }

                            // Kết thúc modal
                            echo "</div>
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
mysqli_free_result($result);
mysqli_close($conn);
?>
