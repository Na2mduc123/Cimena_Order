<?php
// Lấy danh sách sự kiện của người dùng
session_start();
include('../config/database.php');

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM qly_skien WHERE user_id = ?");
$stmt->execute([$userId]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events);
?>
