<?php
// order-success.php
session_start();
include_once 'dbconnect.php';

// Kiểm tra xem có thông tin đơn hàng trong session không
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
    // Lấy thông tin đơn hàng từ cơ sở dữ liệu dựa trên order_id
    $order_query = "SELECT * FROM orders WHERE order_id = $order_id";
    $order_result = mysqli_query($conn, $order_query);

    if ($order_result && mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_assoc($order_result);
        // Di chuyển dòng này để đảm bảo $order_id đã được định nghĩa
        // Nếu $order_id không được định nghĩa, sẽ không có biến $order_id
        $order_id = $order['order_id'];
    }
    // Xóa thông tin đơn hàng khỏi session sau khi hiển thị
    unset($_SESSION['order_id']);
}
?>

<!-- Các phần còn lại của trang order-success.php -->

<?php

// Kiểm tra xem có thông tin đơn hàng trong session không
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];

    // Lấy thông tin đơn hàng từ cơ sở dữ liệu dựa trên order_id
    $order_query = "SELECT * FROM orders WHERE order_id = $order_id";
    $order_result = mysqli_query($conn, $order_query);

    if ($order_result) {
        if (mysqli_num_rows($order_result) > 0) {
            $order = mysqli_fetch_assoc($order_result);
            // Di chuyển dòng này để đảm bảo $order_id đã được định nghĩa
            // Nếu $order_id không được định nghĩa, sẽ không có biến $order_id
            $order_id = $order['order_id'];
        } else {
            echo "Lỗi: Không có dữ liệu trong bảng đơn hàng.";
        }
    } else {
        echo "Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($conn);
    }

    // Xóa thông tin đơn hàng khỏi session sau khi hiển thị
    unset($_SESSION['order_id']);
} else {
    echo "Lỗi: Không có order_id trong session.";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tech Trend Shop - Đặt Hàng Thành Công</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <?php
    include_once 'style.php';
    ?>
    <style>
        .order-success__text{
            color: black;
        }
    </style>
</head>

<body>
    <!-- Header Section Begin -->
    <?php
    include_once 'header.php';
    ?>
    <!-- Header Section End -->

    <!-- Order Success Section Begin -->
    <section class="order-success spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="order-success__text">
                        <?php
                        if (isset($order_id)) {
                            echo '<h2>Cảm ơn bạn đã đặt hàng!</h2>';
                            echo '<p>Đơn hàng của bạn đã được xác nhận. Mã đơn hàng của bạn là: <span>#' . $order_id . '</span></p>';
                            echo '<p>Chúng tôi sẽ liên hệ với bạn sớm nhất có thể để xác nhận và giao hàng.</p>';
                        } else {
                            echo '<h2>Đã có lỗi xảy ra!</h2>';
                            echo '<p>Không thể lấy thông tin đơn hàng.</p>';
                        }
                        ?>
                        <a href="index.php" class="primary-btn">Quay lại cửa hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Success Section End -->

    <!-- Footer Section Begin -->
    <?php
    include_once 'footer.php';
    ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php
    include_once 'js.php';
    ?>
</body>

</html>
