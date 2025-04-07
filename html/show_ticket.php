<?php
// Kết nối cơ sở dữ liệu và lấy danh sách vé đã mua
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_system";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy user_id từ session
session_start();
$user_id = $_SESSION['user_id'];

// Sử dụng prepared statement để tránh SQL injection
$stmt = $conn->prepare("SELECT * FROM tickets WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vé của tôi</title>
    <style>
        *
        {
            text-align: center;
            width: 800px;
            margin: auto;
        }
        .ticket {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }
        .ticket p {
            margin: 5px 0;
        }
        .ticket button {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .ticket button:hover {
            background-color: #c0392b;
        }
        h1 {
            margin-top: 20px;
            margin-bottom: 40px;
        }
        .thanhtoan {
            background-color: green;
        }
        #paymentImage {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 30%;
            max-height: 70%;
            opacity: 0; /* Bắt đầu với opacity là 0 */
            visibility: hidden; /* Ẩn hình ảnh */
            transition: opacity 0.5s ease, visibility 0s linear 0.5s; /* Hiệu ứng chuyển đổi mượt mà */
            z-index: 9999;
        }

        #paymentImage.show {
            opacity: 1; /* Khi hiển thị hình ảnh */
            visibility: visible; /* Đảm bảo hình ảnh có thể nhìn thấy */
            transition: opacity 0.5s ease; /* Chuyển đổi opacity nhanh hơn */
        }
        .return
        {
            margin-top: -20px;
            margin-bottom: 30px;
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
        width: 100px;
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

<h1>VÉ CỦA TÔI</h1>
<div class="return"><button ><a href="../html/trangchu.php">Trở về</button></a></div>
<?php
if ($result->num_rows > 0) {
    // Duyệt qua từng vé đã mua
    while ($row = $result->fetch_assoc()) {
        // Định dạng lại thời gian chiếu
        $show_time = date('d/m/Y H:i', strtotime($row['show_time']));

        echo "<div class='ticket'>";
        echo "<p><strong>Phim: </strong>" . $row['movie_name'] . "</p>";
        echo "<p><strong>Ghế: </strong>" . $row['seat_number'] . "</p>";
        echo "<p><strong>Thời gian chiếu: </strong>" . $show_time . "</p>";
        echo "<p><strong>Số tiền: </strong>" . number_format($row['amount'], 0, ',', '.') . " VND</p>";
        echo "<button onclick='showImage()' style='background-color: pink; margin-bottom: 5px'>Thanh toán</button>";
        echo "<button onclick='deleteTicket(" . $row['id'] . ")'>Xóa vé</button>";
        echo "</div>";
    }
} else {
    echo "<p>Bạn chưa mua vé nào.</p>";
}
?>

<img id="paymentImage" src="../img/qr.jpg" alt="Hình ảnh thanh toán">

<script>
// Hàm xóa vé
function deleteTicket(ticketId) {
    if (confirm("Bạn chắc chắn muốn xóa vé này?")) {
        fetch('../html/delete_ticket.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ticket_id: ticketId })
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message);
            if (result.success) {
                // Xóa vé khỏi giao diện
                const ticketElement = document.querySelector(`button[onclick="deleteTicket(${ticketId})"]`).parentElement;
                ticketElement.remove();
            }
        })
        .catch(error => {
            console.error("Lỗi xóa vé:", error);
            alert("Có lỗi xảy ra khi xóa vé.");
        });
    }
}

function showImage() {
    var image = document.getElementById("paymentImage");
    image.classList.add("show"); // Hiển thị hình ảnh khi nhấn nút thanh toán
}

// Lắng nghe click vào ngoài hình ảnh để ẩn hình ảnh
document.addEventListener("click", function(event) {
    var image = document.getElementById("paymentImage");
    
    // Kiểm tra nếu click ra ngoài phần tử hình ảnh hoặc nút thanh toán
    if (!image.contains(event.target) && !event.target.closest("button")) {
        image.classList.remove("show"); // Ẩn hình ảnh
    }
});


</script>

</body>
</html>
