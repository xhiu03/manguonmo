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

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <!-- Phần danh mục -->
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-target="#collapseOne">Danh Mục</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <?php
                                                    // Truy vấn CSDL để lấy danh mục
                                                    $category_query = "SELECT category_id, category_name FROM categories";
                                                    $category_result = mysqli_query($conn, $category_query);

                                                    // Kiểm tra và hiển thị danh mục nếu có dữ liệu
                                                    if ($category_result && mysqli_num_rows($category_result) > 0) {
                                                        while ($category = mysqli_fetch_assoc($category_result)) {
                                                            echo '<li><a href="?category=' . $category['category_id'] . '">' . $category['category_name'] . '</a></li>';
                                                        }
                                                    } else {
                                                        echo '<li>Không có danh mục nào.</li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phần thương hiệu -->
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-target="#collapseTwo">Thương Hiệu</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__brand">
                                                <ul>
                                                    <?php
                                                    // Truy vấn CSDL để lấy thương hiệu
                                                    $brand_query = "SELECT brand_id, brand_name FROM brands";
                                                    $brand_result = mysqli_query($conn, $brand_query);

                                                    // Kiểm tra và hiển thị thương hiệu nếu có dữ liệu
                                                    if ($brand_result && mysqli_num_rows($brand_result) > 0) {
                                                        while ($brand = mysqli_fetch_assoc($brand_result)) {
                                                            echo '<li><a href="?brand=' . $brand['brand_id'] . '">' . $brand['brand_name'] . '</a></li>';
                                                        }
                                                    } else {
                                                        echo '<li>Không có thương hiệu nào.</li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!-- Sửa mã PHP để hiển thị tất cả sản phẩm -->
                    <?php
                    // Số sản phẩm trên mỗi trang
                    $productsPerPage = 16;

                    // Trang hiện tại (mặc định là 1 nếu không có giá trị)
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Bắt đầu từ vị trí của sản phẩm trong truy vấn
                    $start_from = ($current_page - 1) * $productsPerPage;

                    // Truy vấn CSDL để lấy thông tin sản phẩm, danh mục và thương hiệu và sắp xếp theo ID giảm dần (mới nhất lên đầu) và giới hạn số sản phẩm trên mỗi trang
                    $query = "SELECT p.product_id, p.product_name, p.price, p.background_image, c.category_name, b.brand_name 
                      FROM products p
                      JOIN categories c ON p.category_id = c.category_id
                      JOIN brands b ON p.brand_id = b.brand_id";

                    // Xử lý khi chọn danh mục
                    if (isset($_GET['category'])) {
                        $selected_category = $_GET['category'];
                        $query .= " WHERE p.category_id = $selected_category";
                    }

                    // Xử lý khi chọn thương hiệu
                    if (isset($_GET['brand'])) {
                        $selected_brand = $_GET['brand'];
                        $query .= " WHERE p.brand_id = $selected_brand";
                    }

                    // Xử lý khi tìm kiếm
                    if (isset($_GET['search'])) {
                        $search_term = $_GET['search'];
                        $query .= " WHERE p.product_name LIKE '%$search_term%'";
                    }

                    $query .= " ORDER BY p.product_id DESC LIMIT $start_from, $productsPerPage";

                    $result = mysqli_query($conn, $query);

                    // Kiểm tra và hiển thị sản phẩm nếu có dữ liệu
                    if ($result && mysqli_num_rows($result) > 0) {
                        echo '<div class="row product__filter">';

                        // Hiển thị từng sản phẩm
                        // Sửa phần hiển thị từng sản phẩm
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">';
                            echo '<div class="product__item">';
                            // Thêm thẻ <a> để tạo liên kết
                            echo '<a href="shop-details.php?product_id=' . $row['product_id'] . '">';
                            echo '<div class="product__item__pic set-bg" data-setbg="admin/assets/img/imgproducts/' . basename($row['background_image']) . '">';
                            echo '</div>';
                            echo '</a>';
                            echo '<div class="product__item__text">';
                            echo '<h6>' . $row['product_name'] . '</h6>';
                            echo '</a>';
                            echo '<h5>' . number_format($row['price']) . ' VNĐ</h5>';
                            echo '<p>Danh mục: ' . $row['category_name'] . '</p>';
                            echo '<p>Thương hiệu: ' . $row['brand_name'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }


                        echo '</div>';

                        // Giải phóng bộ nhớ
                        mysqli_free_result($result);

                        // Tính số lượng trang
                        $total_pages_query = "SELECT COUNT(*) as total FROM products";
                        $total_pages_result = mysqli_query($conn, $total_pages_query);
                        $total_pages = ceil(mysqli_fetch_assoc($total_pages_result)['total'] / $productsPerPage);

                        // Hiển thị phân trang
                        echo '<div class="row">';
                        echo '<div class="col-lg-12">';
                        echo '<div class="product__pagination">';

                        // Hiển thị các trang
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($i == $current_page) ? 'active' : '';
                            echo '<a class="' . $active_class . '" href="?page=' . $i . '">' . $i . '</a>';
                        }

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Hiển thị thông báo nếu không có sản phẩm
                        echo 'Không có sản phẩm nào.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

    <!-- Footer Section Begin -->
    <?php
    include_once 'footer.php';
    ?>
    <!-- Footer Section End -->

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

    <!-- Js Plugins -->
    <?php
    include_once 'js.php';
    ?>
</body>

</html>