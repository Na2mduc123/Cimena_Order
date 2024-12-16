<?php
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Mặc định người dùng là user

    // Kiểm tra nếu tên đăng nhập đã tồn tại
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        echo "Tên đăng nhập đã tồn tại!";
    } else {
        // Nếu không có người dùng nào với tên đăng nhập đó, thực hiện đăng ký
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);

        // Chuyển hướng người dùng tới trang đăng nhập sau khi đăng ký thành công
        header('Location: login.php');
        exit();  // Đảm bảo mã sau khi chuyển hướng không bị thực thi
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="register">
        <h1>ĐĂNG KÝ</h1>
        <form method="POST">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" class="user" placeholder="Tên đăng nhập" required><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" class="pass" placeholder="Mật khẩu" required><br>
            <label for="repassword">Nhập lại mật khẩu:</label>
            <input type="password" name="repassword" class="repass" placeholder="Nhập lại mật khẩu" required><br>
            <a href="login.php">Tôi đã có tài khoản</a><br>
            <div class="tooltip">
                <button type="submit">ĐĂNG KÝ</button>
                <div class="tooltiptext" id="tooltip-error">Lỗi sẽ hiển thị tại đây</div>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();

    const usernameInput = document.querySelector('input[name="username"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const repasswordInput = document.querySelector('input[name="repassword"]');
    const tooltip = document.querySelector('.tooltip');
    const tooltipText = document.getElementById('tooltip-error');

    usernameInput.classList.remove('error');
    passwordInput.classList.remove('error');
    repasswordInput.classList.remove('error');
    tooltip.classList.remove('show');

    let errorMessage = '';

    if (!usernameInput.value.trim()) {
        usernameInput.classList.add('error');
        errorMessage = 'Tên đăng nhập không được để trống!';
    } else if (passwordInput.value !== repasswordInput.value) {
        repasswordInput.classList.add('error');
        errorMessage = 'Mật khẩu không khớp!';
    } else if (passwordInput.value.trim().length < 6) {
        passwordInput.classList.add('error');
        errorMessage = 'Mật khẩu phải có ít nhất 6 ký tự!';
    }

    if (errorMessage) {
        tooltipText.textContent = errorMessage;
        tooltip.classList.add('show');

        // Tự động ẩn tooltip và xóa viền đỏ sau 2 giây
        setTimeout(() => {
            tooltip.classList.remove('show');
        }, 2000);

        return;
    }

    // Nếu không có lỗi, gửi form
    tooltipText.textContent = '';
    tooltip.classList.remove('show');
    this.submit();
});

// Xóa viền đỏ khi người dùng click vào input
const inputs = document.querySelectorAll('input');
inputs.forEach(input => {
    input.addEventListener('focus', () => {
        input.classList.remove('error');
    });
});

    </script>
</body>
</html>

