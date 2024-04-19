

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
    include_once 'style.php'
    ?>
</head>

<body>
    <!-- Header Section Begin -->
    <?php
    include_once 'header.php'
    ?>
    <!-- banner -->
    <?php
    include_once 'banner.php'
    ?>
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Sản Phẩm Mới</li>
                    </ul>
                </div>
            </div>
            <?php
            // Include file kết nối CSDL
            include_once 'dbconnect.php';

            // Truy vấn CSDL để lấy thông tin sản phẩm và sắp xếp theo ID giảm dần (mới nhất lên đầu)
            $query = "SELECT product_id, product_name, price, background_image FROM products ORDER BY product_id DESC LIMIT 8";
            $result = mysqli_query($conn, $query);

            // Kiểm tra và hiển thị sản phẩm nếu có dữ liệu
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="row product__filter">';

                // Hiển thị từng sản phẩm
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">';
                    echo '<div class="product__item">';
                    echo '<a href="shop-details.php?product_id=' . $row['product_id'] . '">';
                    echo '<div class="product__item__pic set-bg" data-setbg="admin/assets/img/imgproducts/' . basename($row['background_image']) . '">';
                    echo '<span class="label">New</span>';
                    echo '</div>';
                    echo '</a>';
                    echo '<div class="product__item__text">';
                    echo '<h6>' . $row['product_name'] . '</h6>';
                    echo '<a href="#" class="add-cart">+ Add To Cart</a>';
                    // Chuyển đổi đơn vị tiền tệ sang VNĐ
                    echo '<h5>' . number_format($row['price']) . ' VNĐ</h5>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                
                echo '</div>';

                // Giải phóng bộ nhớ
                mysqli_free_result($result);
            } else {
                // Hiển thị thông báo nếu không có sản phẩm
                echo 'Không có sản phẩm nào.';
            }
            ?>
    
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Tin Công Nghệ</span>
                        <h2>Tin Tức Công Nghệ 2023</h2>
                    </div>
                </div>
            </div>
            <?php
            // Include file kết nối CSDL
            include_once 'dbconnect.php';

            // Truy vấn CSDL để lấy thông tin tin tức giới hạn 3 và sắp xếp theo ID giảm dần (bài đăng mới nhất lên đầu)
            $query = "SELECT news_id, news_name, news_image, content FROM news ORDER BY news_id DESC LIMIT 3";
            $result = mysqli_query($conn, $query);

            // Kiểm tra và hiển thị tin tức nếu có dữ liệu
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="row">';

                // Hiển thị từng tin tức
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-lg-4 col-md-6 col-sm-6">';
                    echo '<div class="blog__item">';
                    echo '<a href="blog-details.php?news_id=' . $row['news_id'] . '">';
                    echo '<div class="blog__item__pic set-bg" data-setbg="admin/assets/img/imgnews/' . basename($row['news_image']) . '"></div>';
                    echo '</a>';
                    echo '<div class="blog__item__text">';
                    echo '<h5>' . $row['news_name'] . '</h5>';
                    echo '<a href="blog-details.php?news_id=' . $row['news_id'] . '">Read More</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                

                echo '</div>';

                // Giải phóng bộ nhớ
                mysqli_free_result($result);
            } else {
                // Hiển thị thông báo nếu không có tin tức
                echo 'Không có tin tức nào.';
            }
            ?>
        </div>
    </section>
    <!-- Latest Blog Section End -->
    <?php
    include_once 'footer.php'
    ?>
    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->
    <?php
    include_once 'js.php'
    ?>

    <script>
        let currentSlide = 0;

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function showSlide(index) {
            const images = document.querySelector('.images');
            const totalSlides = images.children.length;

            if (index >= 0 && index < totalSlides) {
                currentSlide = index;
                const translateValue = -100 * currentSlide + '%';
                images.style.transform = `translateX(${translateValue})`;
            } else if (index === totalSlides) {
                currentSlide = 0;
                images.style.transform = `translateX(0)`;
            }
        }
    </script>


</body>

</html>