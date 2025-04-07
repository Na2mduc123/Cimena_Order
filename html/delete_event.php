<?php
// delete_event.php

header('Content-Type: application/json');

include('../config/database.php');

// Đọc dữ liệu từ yêu cầu JSON
$input = json_decode(file_get_contents('php://input'), true);
$event_id = $input['event_id'];

if (isset($event_id)) {
    // Xóa sự kiện
    $conn->beginTransaction();
    try {
        $stmt = $conn->prepare("DELETE FROM qly_skien WHERE id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();
        $conn->commit();
        echo json_encode("Sự kiện đã được xóa thành công.");
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode("Có lỗi xảy ra khi xóa sự kiện: " . $e->getMessage());
    }
} else {
    echo json_encode("ID sự kiện không hợp lệ.");
}

// Đóng kết nối
$conn = null;
?>