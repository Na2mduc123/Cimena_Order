<?php
// Xử lý tạo sự kiện từ người dùng
session_start();

echo "<h3>Thông tin Session:</h3><pre>";
print_r($_SESSION);
echo "</pre>";

if (!isset($_SESSION['user_id'])) {
    die("Lỗi: Không tìm thấy user_id trong session. Vui lòng đăng nhập lại.");
}

// Bao gồm file kết nối cơ sở dữ liệu
include('../config/database.php'); // Đảm bảo đường dẫn đúng
$userId = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy user_id từ session
    $userId = $_SESSION['user_id'];

    $categories = [
        'ca-nhac' => 'Ca nhạc',
        'hoi-nghi' => 'Hội nghị/Hội thảo',
        'le-hoi' => 'Lễ hội'
    ];
    // Lấy dữ liệu từ form
    $eventName = $_POST['event_name'] ?? null;
    $event_category = $_POST['event_category'] ?? null;
    $peoples_scale = $_POST['peoples_scale'] ?? null; 
    $eventTime = $_POST['event_time'] ?? null; 
    $logo = $_FILES['logo']['name'] ?? null;
    $banner = $_FILES['banner']['name'] ?? null;
    $province = $_POST['province'] ?? null;
    $district = $_POST['district'] ?? null;
    $ward = $_POST['ward'] ?? null;
    $detailedAddress = $_POST['detailed_address'] ?? null;

    // Kiểm tra dữ liệu đầu vào
    if (empty($userId) || empty($eventName) || empty($event_category) || empty($peoples_scale) || empty($eventTime) || empty($province) || empty($district) || empty($ward) || empty($detailedAddress)) {
        die("Lỗi: Vui lòng điền đầy đủ thông tin.");
    }
  
    // Xử lý upload logo
    if ($logo) {
        $logoPath = "../uploads/" . basename($logo);
        if (!move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
            die("Upload logo thất bại.");
        }
    }

    // Xử lý upload banner
    if ($banner) {
        $bannerPath = "../uploads/" . basename($banner);
        if (!move_uploaded_file($_FILES['banner']['tmp_name'], $bannerPath)) {
            die("Upload banner thất bại.");
        }
    }

    try {
        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare("
            INSERT INTO qly_skien (user_id, event_name, event_category, peoples_scale, event_time, logo, banner, province, district, ward, detailed_address, status)
            VALUES (:user_id, :event_name, :event_category, :peoples_scale, :event_time, :logo, :banner, :province, :district, :ward, :detailed_address, 'pending')
        ");

        // Thực thi câu lệnh SQL
        $stmt->execute([
            ':user_id' => $userId,
            ':event_name' => $eventName,
            ':event_category' => $event_category,
            ':peoples_scale' => $peoples_scale,
            ':event_time' => $eventTime,
            ':logo' => $logo,
            ':banner' => $banner,
            ':province' => $province,
            ':district' => $district,
            ':ward' => $ward,
            ':detailed_address' => $detailedAddress,
        ]);

        echo "Sự kiện đã được gửi và đang chờ duyệt.";
    } catch (PDOException $e) {
        die("Lỗi: " . $e->getMessage());
    }
}
?>
