<?php
include_once 'dbconnect.php';

// Kiểm tra xem có tham số product_id được truyền vào không
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Truy vấn để lấy thông tin sản phẩm từ cơ sở dữ liệu
    $query = "SELECT p.product_id, p.product_name, p.price, p.background_image, p.configuration, p.product_info, p.category_id, p.brand_id, b.brand_name, c.category_name
    FROM products p
    INNER JOIN brands b ON p.brand_id = b.brand_id
    INNER JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = $product_id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Lấy dòng dữ liệu đầu tiên (do product_id là duy nhất)
        $product = mysqli_fetch_assoc($result);

        // Tiếp theo, hiển thị thông tin sản phẩm trong HTML
?>
        <!DOCTYPE html>
        <html lang="zxx">

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
            include_once 'style.php';
            ?>
        </head>

        <body>
            <!-- Header Section Begin -->
            <?php
            include_once 'header.php';
            ?>
            <!-- Header Section End -->
            <!-- Shop Details Section Begin -->
            <section class="shop-details">
                <div class="product__details__pic">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                    // Truy vấn để lấy danh sách ảnh từ bảng product_images
                                    $image_query = "SELECT image_url FROM product_images WHERE product_id = $product_id";
                                    $image_result = mysqli_query($conn, $image_query);

                                    // Kiểm tra xem có ảnh nào không
                                    if ($image_result && mysqli_num_rows($image_result) > 0) {
                                        $count = 1;
                                        while ($image = mysqli_fetch_assoc($image_result)) {
                                            // Sử dụng basename để lấy tên tệp từ đường dẫn
                                            $basename = basename($image['image_url']);
                                            // Sử dụng đường dẫn giống với mã bạn đưa ra
                                            $background_image_url = "admin/assets/img/imgproducts/{$basename}";
                                            // Sử dụng ảnh đầu tiên làm ảnh đại diện active
                                            $active_class = ($count == 1) ? 'active' : '';
                                    ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo $active_class; ?>" data-toggle="tab" href="#tabs-<?php echo $count; ?>" role="tab">
                                                    <div class="product__thumb__pic set-bg" data-setbg="<?php echo $background_image_url; ?>">
                                                        <!-- Hiển thị ảnh từ product_images -->
                                                    </div>
                                                </a>
                                            </li>
                                    <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-9">
                                <div class="tab-content">
                                    <?php
                                    // Reset count để sử dụng lại
                                    $count = 1;
                                    // Truy vấn để lấy danh sách ảnh từ bảng product_images
                                    $image_result = mysqli_query($conn, $image_query);

                                    // Kiểm tra xem có ảnh nào không
                                    if ($image_result && mysqli_num_rows($image_result) > 0) {
                                        while ($image = mysqli_fetch_assoc($image_result)) {
                                            // Sử dụng basename để lấy tên tệp từ đường dẫn
                                            $basename = basename($image['image_url']);
                                            // Sử dụng đường dẫn giống với mã bạn đưa ra
                                            $image_url = "admin/assets/img/imgproducts/{$basename}";
                                            // Sử dụng ảnh đầu tiên làm ảnh đại diện active
                                            $active_class = ($count == 1) ? 'active' : '';
                                    ?>
                                            <div class="tab-pane <?php echo $active_class; ?>" id="tabs-<?php echo $count; ?>" role="tabpanel">
                                                <div class="product__details__pic__item">
                                                    <img src="<?php echo $image_url; ?>" alt="">
                                                </div>
                                            </div>
                                    <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="product__details__content">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-8">
                                <div class="product__details__text">
                                    <h4><?php echo $product['product_name']; ?></h4>
                                    <h3><?php echo '₫' . number_format($product['price'], 0, ',', '.'); ?></h3>
                                    <!-- Sử dụng thẻ <a> để tạo liên kết cho tên thương hiệu -->
                                    <h5>Tên Thương hiệu: <a href='./shop.php?brand=<?php echo $product['brand_id']; ?>'><?php echo $product['brand_name']; ?></a></h5>
                                    <!-- Sử dụng thẻ <a> để tạo liên kết cho tên danh mục -->
                                    <h5>Tên Danh Mục: <a href='./shop.php?category=<?php echo $product['category_id']; ?>'><?php echo $product['category_name']; ?></a></h5>
                                    <div class="product__details__cart__option">
                                        <form action="add_to_cart.php" method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" name="quantity" value="1">
                                                </div>
                                            </div>
                                            <button type="submit" class="primary-btn">add to cart</button>
                                        </form>
                                    </div>

                                    <div class="product__details__btns__option">
                                        <a href="#"><i class="fa fa-heart"></i> add to wishlist</a>
                                        <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product__details__tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Cấu Hình</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Thông Tin Sản Phẩm</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                            <div class="product__details__tab__content">
                                                <p class="note"><?php echo $product['configuration']; ?></p>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tabs-7" role="tabpanel">
                                            <div class="product__details__tab__content">
                                                <p class="note"><?php echo $product['product_info']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Shop Details Section End -->

            <!-- Related Section Begin -->

            <!-- Related Section End -->

            <!-- Footer Section Begin -->
            <?php
            include_once 'footer.php'
            ?>
            <!-- Footer Section End -->
            <!-- Js Plugins -->
            <?php
            include_once 'js.php'
            ?>
        </body>

        </html>
<?php
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Giải phóng bộ nhớ sau khi sử dụng kết quả truy vấn
    mysqli_free_result($result);
}

// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($conn);
?>