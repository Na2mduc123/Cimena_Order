<?php
// Bắt đầu session để truy cập vào thông tin người dùng
session_start();

// Kiểm tra nếu không có user_id trong session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['message' => 'Không tìm thấy user_id trong session. Vui lòng đăng nhập lại.']);
    exit;
}

// Lấy user_id từ session
$user_id = $_SESSION['user_id'];

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(['message' => 'Kết nối cơ sở dữ liệu thất bại: ' . $conn->connect_error]));
}

// Lấy dữ liệu từ AJAX request
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra dữ liệu
if (!isset($data['seat_number'], $data['movie_name'], $data['show_time'], $data['amount'])) {
    echo json_encode(['message' => 'Dữ liệu không hợp lệ']);
    exit;
}

// Gán dữ liệu từ request
$seat_number = $data['seat_number'];
$movie_name = $data['movie_name'];
$show_time = date('Y-m-d H:i:s', strtotime($data['show_time']));
$amount = $data['amount'];

// Chuẩn bị truy vấn thêm dữ liệu
$stmt = $conn->prepare("
    INSERT INTO tickets (user_id, seat_number, movie_name, show_time, amount, created_at) 
    VALUES (?, ?, ?, ?, ?, NOW())
");
$stmt->bind_param('isssd', $user_id, $seat_number, $movie_name, $show_time, $amount);

// Thực thi truy vấn
if ($stmt->execute()) {
    echo json_encode(['message' => 'Đặt vé thành công!']);
} else {
    echo json_encode(['message' => 'Đặt vé thất bại!', 'error' => $stmt->error]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
