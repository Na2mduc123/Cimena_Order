<?php
session_start();
include('../config/database.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Tên đăng nhập và mật khẩu không được để trống!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header('Location: ' . ($user['role'] == 'admin' ? 'edit_user.php' : 'trangchu.php'));
                exit();
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        } else {
            $error = "Lỗi truy vấn cơ sở dữ liệu!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login">
        <h1>ĐĂNG NHẬP</h1>
        <form method="POST" id="loginForm">
            <label for="username" class="user">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="password" class="pass">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>

            <a href="register.php">Tôi chưa có tài khoản</a><br>

            <button type="submit">ĐĂNG NHẬP</button>
        </form>
        <div id="errorTooltip" class="error-tooltip"></div>
    </div>
    <script>
        const error = <?php echo json_encode($error); ?>;
        if (error) {
            // Hiển thị lỗi
            
            const tooltip = document.getElementById('errorTooltip');
            const input = error.includes('mật khẩu') ? document.getElementById('password') : document.getElementById('username');
            // Định vị tooltip
            const rect = input.getBoundingClientRect();
            tooltip.textContent = error;
            tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight - -180}px`;
            tooltip.style.left = `${rect.left + window.scrollX}px`;

            tooltip.classList.add('show');

            // Ẩn tooltip sau 2 giây
            setTimeout(() => {
                tooltip.classList.remove('show');
            }, 2000);
        }
    </script>
</body>
</html>
