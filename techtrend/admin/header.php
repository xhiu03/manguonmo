
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Trong tệp tin dbconnect.php hoặc một tệp tin tương tự
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Include the database connection file
include_once 'dbconnect.php';

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Đăng xuất
    session_destroy();
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
    exit();
}

// Xử lý đổi mật khẩu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $currentPassword = sanitizeInput($_POST["current_password"]);
    $newPassword = sanitizeInput($_POST["new_password"]);
    $confirmPassword = sanitizeInput($_POST["confirm_password"]);

    // Kiểm tra xác thực người dùng nếu cần
    // ...

    // Lấy thông tin người dùng từ CSDL
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = $userId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Kiểm tra mật khẩu hiện tại
        if (password_verify($currentPassword, $user['password'])) {
            // Kiểm tra xác nhận mật khẩu mới
            if ($newPassword == $confirmPassword) {
                // Hash mật khẩu mới
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Cập nhật mật khẩu mới vào CSDL
                $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE user_id = $userId";

                if (mysqli_query($conn, $updateQuery)) {
                    echo "Password changed successfully!";
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "New password and confirm password do not match!";
            }
        } else {
            echo "Incorrect current password!";
        }
    } else {
        echo "Error fetching user information: " . mysqli_error($conn);
    }
}
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="/techtrend/assets/img/TechTrendlogo.png" width="80" height="80" class="d-inline-block align-top" alt="">
    </a>

    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <!-- Trong phần navbar -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="margin-left: -117px;">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="fas fa-key"></i> Đổi mật khẩu
                    </a>
                    <a class="dropdown-item" href="?action=logout">
                        <i class="fas fa-info-circle"></i> Đăng Xuất
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Modal Đổi mật khẩu -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Đổi mật khẩu -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="currentPassword">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="change_password">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
