<?php
// Kết nối cơ sở dữ liệu
include('../config/database.php');

// Tạo tài khoản admin
$username = 'admin';
$password = password_hash('admin', PASSWORD_DEFAULT); // Mã hóa mật khẩu
$role = 'admin';

// Kiểm tra xem tài khoản admin đã tồn tại chưa
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$existing_user = $stmt->fetch();

if ($existing_user) {
    echo "Tài khoản admin đã tồn tại!";
} else {
    // Thêm tài khoản admin vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
    echo "Tài khoản admin đã được tạo thành công!";
}
?>
