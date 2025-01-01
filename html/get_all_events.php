<?php
// Lấy danh sách sự kiện cho admin
session_start();
include('../config/database.php');

// Chỉ admin được phép truy cập
if ($_SESSION['role'] !== 'admin') {
    echo json_encode([]);
    exit();
}

$stmt = $conn->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events);
?>
