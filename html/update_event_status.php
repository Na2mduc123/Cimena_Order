<?php
// Admin duyệt sự kiện
session_start();
include('../config/database.php');

// Chỉ admin được phép truy cập
if ($_SESSION['role'] !== 'admin') {
    echo "Không có quyền truy cập.";
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$eventId = $data['event_id'];
$status = $data['status']; // 'approved' hoặc 'rejected'
$adminComment = $data['admin_comment'];

$stmt = $conn->prepare("UPDATE events SET status = ?, admin_comment = ? WHERE id = ?");
$stmt->execute([$status, $adminComment, $eventId]);

echo "Trạng thái sự kiện đã được cập nhật.";
?>
