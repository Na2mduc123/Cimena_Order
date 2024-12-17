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

// Mã cho trang trangchu của người dùng
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG CHỦ</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/trangchu.css">
    <script>
        
        
    </script>
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
                    <a href="#">Vé đã mua</a>
                    <a href="#">Sự kiện của tôi</a>
                    <a href="#">Thông tin tài khoản</a>
                    <a href="#">Đăng xuất</a>
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
    <div>
    <div class="menu1">
        <div class="carousel">
          <button class="carousel-btn left">&#8249;</button>
          <div class="carousel-track">
            <div class="carousel-item">
              <img src="../img/ATVNCG.png" alt="Image 1">
              <video src="../video/ATVNCG.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/squid_game2.jpg" alt="Image 2">
              <video src="../video/squidgame2.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/nhachoi.jpg" alt="Image 3">
              <video src="../video/nhachoi.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/banner-viec-lam.jpg" alt="Image 4">
              <video src="../video/hoithao.mp4" muted autoplay loop></video>
            </div>
            <div class="carousel-item">
              <img src="../img/Le-Hoi-0.jpg" alt="Image 5">
              <video src="../video/lehoi.mp4" muted autoplay loop></video>
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
    
      <section id="special-events" class="special-events-section">
        <div class="container">
          <h2 class="section-title">Sự kiện sắp diễn ra</h2>
          <div class="events-grid-wrapper">
            <div class="events-grid">
      
              <!-- Sự kiện 1 -->
              <div class="event-card">
                <div class="event-image">
                  <img src="../img/1.jpg" alt="Sự kiện 1">
                </div>
                <div class="event-info">
                  <h3 class="event-title">Đêm nhạc Trịnh Công Sơn</h3>
                  <p class="event-date">Ngày 20/12/2024</p>
                  <p class="event-location">Nhà hát Lớn Hà Nội</p>
                  <a href="#" class="event-link">Xem chi tiết</a>
                  <button class="follow-button" onclick="followEvent(this)">Theo dõi</button>
                  <p class="followers-count">0 người đã theo dõi</p>
                </div>
              </div>
      
              <!-- Sự kiện 2 -->
              <div class="event-card">
                <div class="event-image">
                  <img src="../img/2.jpg" alt="Sự kiện 2">
                </div>
                <div class="event-info">
                  <h3 class="event-title">Hội thảo Startup Việt</h3>
                  <p class="event-date">Ngày 15/01/2025</p>
                  <p class="event-location">Trung tâm Hội nghị SECC, TP.HCM</p>
                  <a href="#" class="event-link">Xem chi tiết</a>
                  <button class="follow-button" onclick="followEvent(this)">Theo dõi</button>
                  <p class="followers-count">0 người đã theo dõi</p>
                </div>
              </div>
      
              <!-- Sự kiện 3 -->
              <div class="event-card">
                <div class="event-image">
                  <img src="../img/3.jpg" alt="Sự kiện 3">
                </div>
                <div class="event-info">
                  <h3 class="event-title">Lễ hội ánh sáng 2024</h3>
                  <p class="event-date">Ngày 30/12/2024</p>
                  <p class="event-location">Phố đi bộ Nguyễn Huệ, TP.HCM</p>
                  <a href="#" class="event-link">Xem chi tiết</a>
                  <button class="follow-button" onclick="followEvent(this)">Theo dõi</button>
                  <p class="followers-count">0 người đã theo dõi</p>
                </div>
              </div>
      
              <!-- Sự kiện 4 -->
              <div class="event-card">
                <div class="event-image">
                  <img src="../img/2.jpg" alt="Sự kiện 4">
                </div>
                <div class="event-info">
                  <h3 class="event-title">Festival Văn hóa 2024</h3>
                  <p class="event-date">Ngày 05/03/2024</p>
                  <p class="event-location">Đà Nẵng</p>
                  <a href="#" class="event-link">Xem chi tiết</a>
                  <button class="follow-button" onclick="followEvent(this)">Theo dõi</button>
                  <p class="followers-count">0 người đã theo dõi</p>
                </div>
              </div>
      
              <!-- Sự kiện 5 -->
              <div class="event-card">
                <div class="event-image">
                  <img src="../img/1.jpg" alt="Sự kiện 5">
                </div>
                <div class="event-info">
                  <h3 class="event-title">Đêm diễn Kịch nói</h3>
                  <p class="event-date">Ngày 12/04/2024</p>
                  <p class="event-location">Nhà hát TP.HCM</p>
                  <a href="#" class="event-link">Xem chi tiết</a>
                  <button class="follow-button" onclick="followEvent(this)">Theo dõi</button>
                  <p class="followers-count">0 người đã theo dõi</p>
                </div>
              </div>
      
            </div>
            <button class="prev-button" onclick="scrollEvents('prev')">&#10094;</button>
            <button class="next-button" onclick="scrollEvents('next')">&#10095;</button>
          </div>
        </div>
      </section>
    
      <div class="special-events">
        <h2>Sự kiện đang diễn ra</h2>
        <div class="event-container">
          <button class="nav-btn left-btn">&lt;</button>
          <div class="event-list">
            <!-- Các sự kiện -->
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Tên sự kiện</h3>
                <p>Ngày: 20/12/2024</p>
                <p>Địa điểm: TP. Hồ Chí Minh</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <div class="event-item">
              <img src="https://via.placeholder.com/300x200" alt="Tên sự kiện">
              <div class="event-details">
                <h3>Sự kiện âm nhạc ABC</h3>
                <p>Ngày: 25/12/2024</p>
                <p>Địa điểm: Hà Nội</p>
                <a href="#" class="buy-ticket">Mua vé ngay</a>
              </div>
            </div>
            <!-- Thêm sự kiện -->
          </div>
          <button class="nav-btn right-btn">&gt;</button>
        </div>
      </div>

    </div>
    <div class="section" data-section="Hội nghị">
        <h2>Hội nghị</h2>
        <div class="section1">
            <a href="">Xem thêm</a>
        </div>
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
        <div class="section1">
            <a href="">Xem thêm</a>
        </div>
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
        <div class="section1">
            <a href="">Xem thêm</a>
        </div>
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
    

</body>
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <ul>
                <li>Hotline</li>
                <li><a href="#"><i class="fas fa-phone"></i>&#160;Thứ 2 - Thứ 6 (8:30 - 18:30)</a></li>
                <li>Email</li>
                <li><a href="#"> <i class="fas fa-envelope"></i></a>&#160;mtn@gmail.com</li>
                <li>Văn phòng</li>
                <li><a href="#"> <i class="fas fa-map-marker-alt"></i>&#160;Ngõ 389, Xuân Khanh, Sơn Tây, Hà Nội.</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <ul>
                <li>Dành cho khách hàng</li>
                <li><a href="#">Điều khoản sử dụng cho khách hàng</a></li>
                <li>Dành cho ban tổ chức</li>
                <li><a href="#">Điều khoản sử dụng cho ban tổ chức</a></li>
                <li>Đăng ký nhận email về các sự kiện hot nhất</li>
                <li><div class="email-container">
                  <input type="email" id="email" placeholder="Nhập email của bạn..." required>
                  <button id="sendButton">
                      <i class="fa-solid fa-paper-plane"></i>
                  </button>
              </div>
              <p id="status"></p></li>
            </ul>
        </div>
        <div class="footer-column">
            <ul>
                <li>Về công ty chúng tôi</li>
                <li><a href="#">Quy chế hoạt động</a></li>
                <li><a href="#">Chính sách bảo mật thông tin</a></li>
                <li><a href="#">Cơ chế giải quyết tranh chấp/khiếu nại</a></li>
                <li><a href="#">Chính sách bảo mật thanh toán</a></li>
                <li><a href="#">Chính sách đổi trả và kiểm hàng</a></li>
                <li><a href="#">Điều kiện vận chuyển và giao nhận</a></li>
                <li><a href="#">Phương thức thanh toán</a></li>
            </ul>
        </div>
        
    </div>
    <div class="footer-bottom">
        &copy; 2024 Công ty MTN. Bảo lưu mọi quyền.
    </div>
    <div id="loader">⏳</div>
    <script src = "../js/trangchu.js"></script>
</footer>
</html>
