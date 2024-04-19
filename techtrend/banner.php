<?php
// Include file kết nối CSDL
include_once 'dbconnect.php';

// Truy vấn CSDL để lấy thông tin banner
$query = "SELECT banner_id, banner_name, banner_image, content, link FROM banners";
$result = mysqli_query($conn, $query);

// Kiểm tra và hiển thị banner nếu có dữ liệu
if ($result && mysqli_num_rows($result) > 0) {
    echo '<div class="banner">';
    echo '<button class="nav-btn prev-btn" onclick="prevSlide()">❮</button>';
    echo '<div class="images">';

    // Hiển thị từng banner
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<a href="' . $row['link'] . '" class="image">';
        echo '<img src="admin/assets/img/imgbanners/' . basename($row['banner_image']) . '" alt="' . $row['banner_name'] . '">';
        echo '</a>';
    }

    echo '</div>';
    echo '<button class="nav-btn next-btn" onclick="nextSlide()">❯</button>';
    echo '</div>';
    
    // Giải phóng bộ nhớ
    mysqli_free_result($result);
} else {
    // Hiển thị thông báo nếu không có banner
    echo 'Không có banner nào.';
}
?>
