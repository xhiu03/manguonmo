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
    <?php include_once 'style.php'; ?>
</head>

<body>

    <!-- Header Section Begin -->
    <?php include_once 'header.php'; ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-blog set-bg" data-setbg="https://cdn.pixabay.com/photo/2019/05/29/16/00/retro-4237850_1280.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Tin Công Nghệ</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <?php
                include_once 'dbconnect.php';

                // Truy vấn cơ sở dữ liệu
                $result = mysqli_query($conn, "SELECT news_id, news_name, news_image, content FROM news LIMIT 9");

                // Hiển thị bài viết
                // Hiển thị bài viết
                // Hiển thị bài viết
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-lg-4 col-md-6 col-sm-6">';
                    echo '<div class="blog__item">';
                    echo '<div class="blog__item__pic set-bg" data-setbg="admin/assets/img/imgnews/' . basename($row['news_image']) . '"></div>';
                    echo '<div class="blog__item__text">';
                    echo '<h5>' . $row['news_name'] . '</h5>';
                    echo '<a href="blog-details.php?news_id=' . $row['news_id'] . '">Read More</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }



                // Đóng kết nối cơ sở dữ liệu
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

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