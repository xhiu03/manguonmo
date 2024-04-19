<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Khởi tạo giỏ hàng nếu chưa được thiết lập
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $productExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += $quantity;
            $productExists = true;
            break;
        }
    }

    // Nếu sản phẩm chưa có trong giỏ hàng, thêm nó vào
    if (!$productExists) {
        $newItem = array(
            'product_id' => $product_id,
            'product_name' => $product_name,  // Đảm bảo 'product_name' được thiết lập
            'price' => $price,
            'quantity' => $quantity
        );
        $_SESSION['cart'][] = $newItem;
    }

    // Chuyển hướng trở lại trang trước đó
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
