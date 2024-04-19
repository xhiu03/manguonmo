<?php
// Include the database connection file
include_once 'dbconnect.php';

// Hàm để làm sạch dữ liệu nhập
function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

// Kiểm tra nếu biểu mẫu được gửi để đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);
    $password = password_hash(sanitizeInput($_POST["password"]), PASSWORD_DEFAULT);

    // Thực hiện truy vấn đăng ký
    $query = "INSERT INTO users (email, phone_number, password) VALUES ('$email', '$phone', '$password')";

    if (mysqli_query($conn, $query)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Kiểm tra nếu biểu mẫu được gửi để đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // Thực hiện truy vấn đăng nhập
    $query = "SELECT user_id, email, password, role FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Đăng nhập thành công
            session_start();
            $_SESSION['user_id'] = $row['user_id'];

            // Kiểm tra role và chuyển hướng dựa trên role
            if ($row['role'] == 1) {
                // Nếu là admin, chuyển hướng đến trang quản trị
                header("Location: index.php");
            } else {
                // Nếu là người dùng, chuyển hướng đến trang index.php
                header("Location: ../index.php");
            }
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login & Registration Form</title>
    <!---Custom CSS File--->
    <link rel="stylesheet" href="stylelogin.css">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Login</header>
            <form action="#" method="post">
                <input type="text" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
                <a href="#">Forgot password?</a>
                <input type="submit" class="button" name="login" value="Login">
            </form>
            <div class="signup">
                <span class="signup">Don't have an account?
                    <label for="check">Signup</label>
                </span>
            </div>
        </div>
        <div class="registration form">
            <header>Signup</header>
            <form action="#" method="post">
                <input type="text" name="email" placeholder="Enter your email">
                <input type="text" name="phone" placeholder="Enter your phone number">
                <input type="password" name="password" placeholder="Create a password">
                <input type="password" name="confirm_password" placeholder="Confirm your password">
                <input type="submit" class="button" name="register" value="Signup">
            </form>
            <div class="signup">
                <span class="signup">Already have an account?
                    <label for="check">Login</label>
                </span>
            </div>
        </div>
    </div>
</body>

</html>
