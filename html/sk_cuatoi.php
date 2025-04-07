<?php
include '../config/database.php'; // Kết nối cơ sở dữ liệu

// Xử lý xóa sự kiện
if (isset($_GET['delete'])) {
    $event_id = $_GET['delete'];
    $delete_sql = "DELETE FROM qly_skien WHERE id = :id";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bindParam(':id', $event_id);
    $stmt->execute();
    header("Location: sk_cuatoi.php"); // Sau khi xóa, quay lại trang sự kiện
    exit();
}

// Lấy các sự kiện đã duyệt
$sql = "SELECT * FROM qly_skien WHERE status = 'approved' ORDER BY event_time ASC";
$stmt = $conn->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table td {
            background-color: #f9f9f9;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .delete a {
            color: #d9534f;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #d9534f;
            border-radius: 4px;
        }

        .delete a:hover {
            background-color: #d9534f;
            color: white;
        }

        .no-events {
            text-align: center;
            color: #555;
            font-size: 18px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }
        .return
        {
            text-align:center;
        }
        .return button {
        top: 10px;
        left: 10px;
        background-color: #FF69B4;;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        }

        .return button:hover {
        background-color:#FF1493;;
        }
        .return button a
        {
            text-decoration: none;
        }
       
    </style>
</head>
<body>

    <div class="container">
        <h1>Sự kiện của tôi</h1>
        <div class="return"><button ><a href="../html/trangchu.php">Trở về</button></a></div>

        <?php if (count($events) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tên sự kiện</th>
                        <th>Thể loại</th>
                        <th>Số gười tham gia</th>
                        <th>Thời gian diễn ra</th>
                        <th>Địa điểm</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_category']); ?></td>
                            <td><?php echo htmlspecialchars($event['peoples_scale']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_time']); ?></td>
                            <td>
                                <?php
                                // Hiển thị địa điểm (Province, District, Ward, Address)
                                echo htmlspecialchars($event['province']) . ', ' . 
                                     htmlspecialchars($event['district']) . ', ' . 
                                     htmlspecialchars($event['ward']) . ', ' . 
                                     htmlspecialchars($event['detailed_address']);
                                ?>
                            </td>
                            <td>
                                <!-- Nút Xóa sự kiện -->
                                <div class="delete"><a href="sk_cuatoi.php?delete=<?php echo $event['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa sự kiện này chứ?');">Delete</a></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-events">Không có sự kiện nào!.</p>
        <?php endif; ?>
    </div>
    
    
    <div id="loader">⏳</div>
</body>
<script>
        // Hiệu ứng hiện ra mượt mà của trang
document.addEventListener("DOMContentLoaded", () => {
    // Thêm lớp 'loaded' để kích hoạt hiệu ứng fade-in
    document.body.classList.add('loaded');

    // Lắng nghe sự kiện click vào liên kết
    const links = document.querySelectorAll("a.effect");

    links.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const href = link.getAttribute("href");

            // Thêm hiệu ứng fade-out và hiển thị loader
            document.body.classList.remove("loaded");
            document.body.classList.add("fade-out", "loading");

            setTimeout(() => {
                window.location.href = href; // Chuyển sang trang mới
            }, 1000); // Trì hoãn để hiệu ứng hoàn tất
        });
    });
});
    </script>
</html>
