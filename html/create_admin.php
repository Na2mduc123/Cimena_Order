<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Thay đổi nếu cần
$password = "";      // Thay đổi nếu cần
$dbname = "users_system"; // Tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo tên người dùng và mật khẩu
$user = "admin";
$pass = "admin";  // Mật khẩu bạn muốn đặt

// Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

// Thực thi câu lệnh SQL để thêm tài khoản admin
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $hashedPassword); // "ss" là kiểu dữ liệu của 2 tham số (string, string)

// Thực thi và kiểm tra kết quả
if ($stmt->execute()) {
    echo "Tài khoản admin đã được tạo thành công!";
} else {
    echo "Lỗi khi tạo tài khoản: " . $stmt->error;
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
