<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p>Tech Trend - Nơi khám phá xu hướng công nghệ</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <a href="./contact.php">Hỗ Trợ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="./index.php"><img src="assets/img/TechTrendlogo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="active"><a href="./shop.php">Sản Phẩm</a></li>
                        <?php
                        // Hiển thị menu Thương Hiệu
                        echo "<li><a href='#'>Thương Hiệu</a><ul class='dropdown'>";
                        // Kết nối CSDL
                        include_once 'dbconnect.php';
                        // Truy vấn danh sách thương hiệu
                        $brandQuery = "SELECT * FROM brands";
                        $brandResult = mysqli_query($conn, $brandQuery);

                        // Kiểm tra và hiển thị danh sách thương hiệu
                        if ($brandResult && mysqli_num_rows($brandResult) > 0) {
                            $brands = mysqli_fetch_all($brandResult, MYSQLI_ASSOC);
                            foreach ($brands as $brand) {
                                echo "<li><a href='./shop.php?brand={$brand['brand_id']}'>{$brand['brand_name']}</a></li>";
                            }
                        } else {
                            // Hiển thị thông báo nếu không có thương hiệu
                            echo "<li><a href='#'>Không có thương hiệu nào.</a></li>";
                        }

                        // Giải phóng bộ nhớ
                        mysqli_free_result($brandResult);
                        echo "</ul></li>";
                        ?>
                        <?php
                        // (phần code tiếp theo giữ nguyên)
                        ?>
                        <?php
                        // Kết nối CSDL
                        include_once 'dbconnect.php';

                        // Truy vấn danh sách danh mục
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($conn, $query);

                        // Kiểm tra và hiển thị danh sách danh mục
                        if ($result && mysqli_num_rows($result) > 0) {
                            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        ?>

                            <!-- Menu danh mục -->
                            <li><a href="#">Danh Mục</a>
                                <ul class="dropdown">
                                    <?php
                                    // Hiển thị danh sách danh mục
                                    foreach ($categories as $category) {
                                        // Thêm tham số category_id để lọc trên trang shop.php
                                        echo "<li><a href='./shop.php?category={$category['category_id']}'>{$category['category_name']}</a></li>";
                                    }
                                    ?>
                                </ul>
                            </li>

                        <?php
                            // Giải phóng bộ nhớ
                            mysqli_free_result($result);
                        } else {
                            // Hiển thị thông báo nếu không có danh mục
                            echo "Không có danh mục nào.";
                        }
                        ?>

                        <li><a href="./blog.php">Tin Công Nghệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="checkout.php"><img src="assets/img/icon/cart.png" alt=""> <span>0</span></a>
                    <div class="price">Giỏ Hàng</div>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>