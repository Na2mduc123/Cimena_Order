<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_system";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM qly_skien WHERE status = 'approved'");
    $stmt->execute();

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($events as $event) {
        echo $event['event_name'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
$currentDate = date('Y-m-d H:i:s');
$stmt->execute([$currentDate]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
?>
