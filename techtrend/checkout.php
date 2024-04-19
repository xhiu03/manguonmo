<?php
session_start();
include_once 'dbconnect.php';

// Xử lý sự kiện xóa sản phẩm
if (isset($_POST['remove_product'])) {
    $productKey = $_POST['remove_product'];

    // Xóa sản phẩm khỏi giỏ hàng dựa trên key
    if (isset($_SESSION['cart'][$productKey])) {
        unset($_SESSION['cart'][$productKey]);
    }
}

// Xử lý sự kiện Mua Hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['customer_name']) && isset($_POST['customer_address']) && isset($_POST['customer_email']) && isset($_POST['customer_phone'])) {
        // Lấy thông tin người mua
        $customerName = $_POST['customer_name'];
        $customerAddress = $_POST['customer_address'];
        $customerEmail = $_POST['customer_email'];
        $customerPhone = $_POST['customer_phone'];

        // Thêm thông tin đơn hàng vào bảng orders
        $insertOrderQuery = "INSERT INTO orders (customer_name, customer_address, customer_email, customer_phone) 
                            VALUES ('$customerName', '$customerAddress', '$customerEmail', '$customerPhone')";
        $result = mysqli_query($conn, $insertOrderQuery);

        if ($result) {
            // Lấy order_id mới được tạo
            $order_id = mysqli_insert_id($conn);

            // Thêm thông tin đơn hàng chi tiết vào bảng order_details
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $product) {
                    $productId = $product['product_id'];
                    $quantity = $product['quantity'];

                    $insertOrderDetailQuery = "INSERT INTO order_details (order_id, product_id, quantity) 
                                             VALUES ('$order_id', '$productId', '$quantity')";
                    mysqli_query($conn, $insertOrderDetailQuery);
                }
            }

            // Xóa giỏ hàng sau khi đã đặt hàng thành công
            unset($_SESSION['cart']);

            // Lưu order_id vào session
            $_SESSION['order_id'] = $order_id;

            // Chuyển hướng đến trang "Đặt hàng thành công" hoặc trang cảm ơn.
            header("Location: order-success.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
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
    <title>Tech Trend Shop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <?php
    include_once 'style.php'
    ?>
    <!-- Add a style for the remove-product-btn -->
    <style>
        .remove-product-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Header Section Begin -->
    <?php
    include_once 'header.php'
    ?>
    <!-- Header Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="#" method="POST">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Thông Tin Mua Hàng</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Họ và Tên<span>*</span></p>
                                        <input type="text" name="customer_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Địa chỉ<span>*</span></p>
                                <input type="text" name="customer_address" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số Điện Thoại<span>*</span></p>
                                        <input type="text" name="customer_phone" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="customer_email" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Sản Phẩm Đã Thêm Vào Giỏ Hàng</h4>
                                <div class="checkout__order__products">
                                    <!-- Hiển thị danh sách sản phẩm đã chọn -->
                                    <?php
                                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $key => $product) {
                                            $productName = isset($product['product_name']) ? $product['product_name'] : 'Unknown Product';
                                            $productQuantity = isset($product['quantity']) ? $product['quantity'] : 0;
                                            $productPrice = isset($product['price']) ? $product['price'] : 0;
                                    ?>
                                            <p>
                                                <?php echo $productName . ' x' . $productQuantity . ' <span>$' . number_format($productPrice * $productQuantity) . '</span>'; ?>
                                                <!-- Thay đổi nút xóa thành biểu tượng thùng rác -->
                                                <button type="button" class="remove-product-btn" onclick="removeProduct(<?php echo $key; ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                            </p>
                                    <?php
                                        }
                                        $total = 0;
                                        foreach ($_SESSION['cart'] as $product) {
                                            $productPrice = isset($product['price']) ? $product['price'] : 0;
                                            $productQuantity = isset($product['quantity']) ? $product['quantity'] : 0;
                                            $total += $productPrice * $productQuantity;
                                        }
                                        echo '<ul class="checkout__total__all">';
                                        echo '<li>Tổng công <span>$' . number_format($total) . '</span></li>';
                                        echo '</ul>';
                                    } else {
                                        echo 'Giỏ hàng trống.';
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="site-btn">Mua Hàng</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <?php
    include_once 'footer.php'
    ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php
    include_once 'js.php'
    ?>
    <script>
    function removeProduct(productKey) {
        // Sử dụng Ajax để gửi yêu cầu xóa sản phẩm mà không làm tải lại trang
        var xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.href, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Cập nhật phần hiển thị giỏ hàng hoặc làm bất cứ điều gì khác bạn cần
                location.reload(); // Cập nhật trang để hiển thị giỏ hàng mới
            }
        };
        xhr.send("remove_product=" + productKey);
    }
</script>

<?php
// Xử lý sự kiện xóa sản phẩm
if (isset($_POST['remove_product'])) {
    $productKey = $_POST['remove_product'];

    // Xóa sản phẩm khỏi giỏ hàng dựa trên key
    if (isset($_SESSION['cart'][$productKey])) {
        unset($_SESSION['cart'][$productKey]);
    }
}
?>

</body>

</html>