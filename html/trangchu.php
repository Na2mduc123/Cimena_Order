<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['role'])) {
    header('Location: login.php');  // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] != 'user') {
    header('location: trangchu.php');
    exit();
}

// Mã cho trang dashboard của người dùng
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG CHỦ</title>
    <link rel="stylesheet" href="../css/trangchu.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">MTN</a>
        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm...">
        </div>
        <nav class="nav-links">
            <a href="../html/taosk.html">Tạo sự kiện</a>
            <a href="#">Vé đã mua</a>
            <div class="account">
                <a href="#">Tài khoản</a>
                <div class="dropdown">
                    <a href="">Vé đã mua</a>
                    <a href="#">Sự kiện của tôi</a>
                    <a href="#">Thông tin tài khoản</a>
                    <a href="../html/logout.php">Đăng xuất</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="sub-nav">
        <a href="#">Hội nghị</a>
        <a href="#">Hội thảo</a>
        <a href="#">Ca nhạc</a>     
    </div>
    <div class = "phim"><a href="../html/trangchu_phim.html">Phim</a></div>
    <div class="menu1">
        <div class="carousel">
          <button class="carousel-btn left">&#8249;</button>
          <div class="carousel-track">
            <div class="carousel-item">
              <img src="../img/1.jpg" alt="Image 1">
              <video src="../video/video1.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/2.jpg" alt="Image 2">
              <video src="../video/video1.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/3.jpg" alt="Image 3">
              <video src="../video/video1.mp44" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/1.jpg" alt="Image 4">
              <video src="../video/video1.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/2.jpg" alt="Image 5">
              <video src="../video/video1.mp4" muted autoplay loop></video>
            </div>
          </div>
          <button class="carousel-btn right">&#8250;</button>
          <div class="carousel-dots">
            <div class="carousel-dot" data-index="0"></div>
            <div class="carousel-dot" data-index="1"></div>
            <div class="carousel-dot" data-index="2"></div>
            <div class="carousel-dot" data-index="3"></div>
            <div class="carousel-dot" data-index="4"></div>
          </div>
        </div>
      </div>

    <div class="section" data-section="Hội nghị">
        <h2>Hội nghị</h2>
        <div class="items">
            <div class="item">
                <img src="/img/emlaba1noi.jpg" alt="Hội nghị 1">
                <div class="info">
                    <h3>Hội nghị 1</h3>
                    <p>Giá: 500,000đ</p>
                    <p>Ngày: 15/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="/img/11.jpg" alt="Hội nghị 2">
                <div class="info">
                    <h3>Hội nghị 2</h3>
                    <p>Giá: 600,000đ</p>
                    <p>Ngày: 16/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội nghị 3">
                <div class="info">
                    <h3>Hội nghị 3</h3>
                    <p>Giá: 700,000đ</p>
                    <p>Ngày: 17/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội nghị 4">
                <div class="info">
                    <h3>Hội nghị 4</h3>
                    <p>Giá: 800,000đ</p>
                    <p>Ngày: 18/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội nghị 5">
                <div class="info">
                    <h3>Hội nghị 5</h3>
                    <p>Giá: 900,000đ</p>
                    <p>Ngày: 19/12/2024</p>
                </div>
            </div>
        </div>
    </div>

    <div class="section" data-section="Hội thảo">
        <h2>Hội thảo</h2>
        <div class="items">
            <div class="item">
                <img src="placeholder.jpg" alt="Hội thảo 1">
                <div class="info">
                    <h3>Hội thảo 1</h3>
                    <p>Giá: 300,000đ</p>
                    <p>Ngày: 20/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội thảo 2">
                <div class="info">
                    <h3>Hội thảo 2</h3>
                    <p>Giá: 400,000đ</p>
                    <p>Ngày: 21/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội thảo 3">
                <div class="info">
                    <h3>Hội thảo 3</h3>
                    <p>Giá: 500,000đ</p>
                    <p>Ngày: 22/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội thảo 4">
                <div class="info">
                    <h3>Hội thảo 4</h3>
                    <p>Giá: 600,000đ</p>
                    <p>Ngày: 23/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Hội thảo 5">
                <div class="info">
                    <h3>Hội thảo 5</h3>
                    <p>Giá: 700,000đ</p>
                    <p>Ngày: 24/12/2024</p>
                </div>
            </div>
        </div>
    </div>

    <div class="section" data-section="Ca nhạc">
        <h2>Ca nhạc</h2>
        <div class="items">
            <div class="item">
                <img src="placeholder.jpg" alt="Ca nhạc 1">
                <div class="info">
                    <h3>Ca nhạc 1</h3>
                    <p>Giá: 200,000đ</p>
                    <p>Ngày: 25/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Ca nhạc 2">
                <div class="info">
                    <h3>Ca nhạc 2</h3>
                    <p>Giá: 250,000đ</p>
                    <p>Ngày: 26/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Ca nhạc 3">
                <div class="info">
                    <h3>Ca nhạc 3</h3>
                    <p>Giá: 300,000đ</p>
                    <p>Ngày: 27/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Ca nhạc 4">
                <div class="info">
                    <h3>Ca nhạc 4</h3>
                    <p>Giá: 350,000đ</p>
                    <p>Ngày: 28/12/2024</p>
                </div>
            </div>
            <div class="item">
                <img src="placeholder.jpg" alt="Ca nhạc 5">
                <div class="info">
                    <h3>Ca nhạc 5</h3>
                    <p>Giá: 400,000đ</p>
                    <p>Ngày: 29/12/2024</p>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/trangchu.js"></script>
</body>
</html>
