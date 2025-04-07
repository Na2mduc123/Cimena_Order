<?php
// Bắt đầu session để truy cập thông tin người dùng
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
$dbname = "user_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(['message' => 'Kết nối cơ sở dữ liệu thất bại: ' . $conn->connect_error]);
    exit;
}

// Lấy dữ liệu từ AJAX request
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra nếu có ticket_id trong request
if (!isset($data['ticket_id'])) {
    echo json_encode(['message' => 'Dữ liệu không hợp lệ']);
    exit;
}

// Lấy ticket_id từ request
$ticket_id = $data['ticket_id'];

// Kiểm tra nếu vé thuộc về người dùng
$stmt = $conn->prepare("SELECT * FROM tickets WHERE id = ? AND user_id = ?");
$stmt->bind_param('ii', $ticket_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu vé tồn tại và thuộc về người dùng
if ($result->num_rows > 0) {
    // Tiến hành xóa vé
    $stmt = $conn->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param('i', $ticket_id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Xóa vé thành công!', 'success' => true]);
    } else {
        echo json_encode(['message' => 'Xóa vé thất bại, vui lòng thử lại!', 'success' => false]);
    }
} else {
    echo json_encode(['message' => 'Vé không tồn tại hoặc bạn không có quyền xóa vé này.', 'success' => false]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
