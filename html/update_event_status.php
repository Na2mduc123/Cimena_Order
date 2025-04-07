<?php
// Đảm bảo rằng người dùng là admin
session_start();
include('../config/database.php');  // Đảm bảo đúng đường dẫn đến tệp cấu hình cơ sở dữ liệu

// Kiểm tra xem người dùng có phải là admin không
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Bạn không có quyền truy cập']);
    exit();
}

// Lấy dữ liệu từ request JSON
$data = json_decode(file_get_contents('php://input'), true);

$eventId = $data['event_id']; // ID sự kiện
$status = $data['status']; // Trạng thái 'approved' hoặc 'rejected'
$adminComment = $data['admin_comment']; // Bình luận của admin

// Cập nhật trạng thái sự kiện và bình luận của admin
try {
    $stmt = $conn->prepare("UPDATE qly_skien SET status = ?, admin_comment = ? WHERE id = ?");
    $stmt->execute([$status, $adminComment, $eventId]);

    // Trả về thông báo thành công
    echo "Trạng thái sự kiện đã được cập nhật!";
} catch (PDOException $e) {
    // Xử lý lỗi
    echo json_encode(['error' => 'Lỗi khi cập nhật trạng thái sự kiện: ' . $e->getMessage()]);
}
?>
