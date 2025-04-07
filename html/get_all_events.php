<?php
session_start();
include('../config/database.php');

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Bạn không có quyền truy cập']);
    exit();
}

// Lấy trạng thái sự kiện từ tham số GET
$status = isset($_GET['status']) ? $_GET['status'] : null;

try {
    // Xây dựng truy vấn SQL
    $sql = "SELECT id, event_name, event_time, province, district, ward, detailed_address, admin_comment, status 
            FROM qly_skien";

    // Thêm điều kiện trạng thái nếu có
    if ($status) {
        $sql .= " WHERE status = :status";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':status' => $status]);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    // Lấy kết quả
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Kiểm tra và hiển thị thông tin sự kiện nếu không có lỗi
    if ($events) {
        echo json_encode($events);
    } else {
        echo json_encode(['error' => 'Không có sự kiện nào']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Lỗi khi lấy danh sách sự kiện: ' . $e->getMessage()]);
    exit();
}
?>
