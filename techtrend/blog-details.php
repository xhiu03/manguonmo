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
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <?php include_once 'style.php'; ?>
</head>

<body>

    <!-- Header Section Begin -->
    <?php include_once 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Blog Details Hero Begin -->
    <section class="blog-hero spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 text-center">
                    <div class="blog__hero__text">
                        <?php
                        include_once 'dbconnect.php';

                        // Kiểm tra xem có tham số news_id được truyền không
                        if (isset($_GET['news_id'])) {
                            $news_id = $_GET['news_id'];

                            // Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết của bài viết
                            $query = "SELECT news_id, news_name, news_image, content FROM news WHERE news_id = $news_id";
                            $result = mysqli_query($conn, $query);

                            if ($row = mysqli_fetch_assoc($result)) {
                                echo '<h2>' . $row['news_name'] . '</h2>';
                                echo '<ul>';
                                echo '<li>Được Đăng Bởi Quản Trị Viên Tech Trend</li>';
                                echo '</ul>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <?php
                        // Hiển thị hình ảnh của bài viết
                        echo '<img src="admin/assets/img/imgnews/' . basename($row['news_image']) . '" alt="">';
                        ?>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <?php
                        // Hiển thị nội dung của bài viết
                        echo '<div class="blog__details__text">';
                        echo '<p>' . $row['content'] . '</p>';
                        echo '</div>';
                        ?>
                        <!-- Phần còn lại của mã HTML -->

                        <!-- ... -->

                        <!-- ... -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Footer Section Begin -->
    <?php include_once 'footer.php'; ?>
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
    <?php include_once 'js.php'; ?>
</body>

</html>
