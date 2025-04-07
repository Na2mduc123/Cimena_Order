<?php
session_start();
include('../config/database.php');

// Kiểm tra xem người dùng đã đăng nhập chưa và có phải là admin không
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');  // Nếu chưa đăng nhập hoặc không phải admin, chuyển hướng về trang đăng nhập
    exit();
}

// Biến thông báo
$alertMessage = '';


// PHẦN QUẢN LÝ TÀI KHOẢN NGƯỜI DÙNG
// Thêm người dùng
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Mã hóa mật khẩu
    $role = $_POST['role'];

    // Kiểm tra nếu tên người dùng đã tồn tại
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        $alertMessage = "Tên đăng nhập đã tồn tại!";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);
        $alertMessage = "Thêm người dùng thành công!";
    }
}

// Sửa thông tin người dùng
if (isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Cập nhật thông tin người dùng
    $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
    $stmt->execute([$username, $role, $id]);
    $alertMessage = "Cập nhật thông tin người dùng thành công!";
}

// Xóa người dùng
if (isset($_POST['delete_user'])) {
    $id = $_POST['delete_id'];
    
    // Kiểm tra xem người dùng có phải là admin không
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    // Nếu người dùng là admin, không cho phép xóa
    if ($user['role'] == 'admin') {
        $alertMessage = "Không thể xóa tài khoản Admin!";
    } else {
        // Xóa người dùng khỏi cơ sở dữ liệu nếu không phải admin
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $alertMessage = "Xóa người dùng thành công!";
    }
}

// Lấy danh sách người dùng
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll();

// Lấy danh sách sự kiện
$stmt = $conn->query("SELECT * FROM qly_skien ORDER BY id DESC");
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="../css/edit_user.css">
    <script>
        // Nếu có thông báo, hiển thị dưới dạng alert
        <?php if ($alertMessage): ?>
            alert("<?php echo $alertMessage; ?>");
        <?php endif; ?>

              // Lấy tất cả liên kết và phần tử
    
    </script>
</head>
<body>
    <div id="links">
        <a data-target="item1">Quản lý tài khoản người dùng</a>
        <a data-target="item2">Quản lý sự kiện người dùng</a>
    </div>
    <p><a href="logout.php">Đăng xuất</a></p>
    
    <!-- Nội dung các mục -->
  <div class="content-wrapper">
    <div id="item1" class="content">
            <!-- Form Thêm người dùng -->
        <h2>Thêm người dùng mới</h2>
        <form method="POST">
            Tên đăng nhập:
            <input type="text" name="username" required><br>
        
            Mật khẩu:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="password" name="password" required><br>

            Vai trò:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br><br>

            <button type="submit" name="add_user">Thêm người dùng</button>
        </form>

        <h2>Danh sách người dùng</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td>
                                    <!-- Chỉnh sửa người dùng -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <input type="text" name="username" value="<?= $user['username'] ?>" required>
                                        <select name="role" required>
                                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                        </select>
                                        <button type="submit" name="edit_user">Sửa</button>
                                    </form>
                                    <!-- Xóa người dùng -->
                                    <?php if ($user['role'] != 'admin'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?= $user['id'] ?>">
                                            <button type="submit" name="delete_user" onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này?')">Xóa</button>
                                        </form>
                                    <?php else: ?>
                                        <span>Không thể xóa</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>

    </div>



    <div id="item2" class="content">
    <div id="filter-buttons">
        <button onclick="loadAdminEvents('pending')">Chờ duyệt</button>
        <button onclick="loadAdminEvents('approved')">Đã duyệt</button>
        <button onclick="loadAdminEvents()">Tất cả</button>
    </div>

    <!-- Danh sách sự kiện -->
    <div id="admin-event-list-section">                                                                                                     
        <h2>Danh sách Sự kiện</h2>
        <ul id="admin-events">
            <!-- Danh sách sự kiện sẽ được chèn vào đây -->
        </ul>
    </div>             

    <!-- JavaScript -->
    <script>
        // Script điều khiển các phần tử hiện thị trên cùng 1 page và cùng 1 chỗ khi ấn vào link tương ứng

        const links = document.querySelectorAll('#links a');
    const items = document.querySelectorAll('.content');

    // Thêm sự kiện click cho từng liên kết
    links.forEach(link => {
      link.addEventListener('click', () => {
        const targetId = link.getAttribute('data-target');

        // Ẩn tất cả các phần tử
        items.forEach(item => item.classList.remove('active'));

        // Hiển thị phần tử tương ứng
        document.getElementById(targetId).classList.add('active');
      });
    });


// Lấy tất cả các nút
const buttons = document.querySelectorAll('#links a');

// Thêm sự kiện click cho từng nút
buttons.forEach(button => {
    button.addEventListener('click', () => {
        // Xóa lớp 'active' khỏi tất cả các nút
        buttons.forEach(btn => btn.classList.remove('active'));

        // Thêm lớp 'active' vào nút được click
        button.classList.add('active');
    });
});

async function loadAdminEvents(status = '') {
    console.log(`Loading events with status: ${status}`);
    try {
        const response = await fetch('../html/get_all_events.php?status=' + status);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const events = await response.json();
        console.log('Received events:', events);
        const adminEvents = document.getElementById('admin-events');
        adminEvents.innerHTML = ''; // Xóa nội dung hiện có

        // Kiểm tra nếu events là mảng
        if (Array.isArray(events) && events.length > 0) {
            events.forEach(event => {
                console.log(`Processing event: ${event.event_name}`);

                // Kiểm tra giá trị tỉnh, huyện, xã trước khi hiển thị
                const province = event.province || 'Không có thông tin tỉnh';
                const district = event.district || 'Không có thông tin huyện';
                const ward = event.ward || 'Không có thông tin xã';

                // Tạo phần tử mới cho sự kiện
                const eventItem = `
                    <li>
                        <strong>${event.event_name} (${event.status})</strong><br>
                        Thời gian diễn ra: ${new Date(event.event_time).toLocaleString()}<br>
                        Địa điểm: ${province}, ${district}, ${ward}, ${event.detailed_address}<br>
                        <label for="comment-${event.id}">Nhập phản hồi:</label>
                        <input type="text" id="comment-${event.id}" value="${event.admin_comment || ''}">
                        <button onclick="updateEventStatus(${event.id}, 'approved')">Duyệt</button>
                        <button onclick="updateEventStatus(${event.id}, 'rejected')">Không duyệt</button>
                        <button onclick="deleteEvent(${event.id})">Xóa</button>
                    </li>
                `;
                adminEvents.insertAdjacentHTML('beforeend', eventItem);
            });
        } else {
            adminEvents.innerHTML = 'Không có sự kiện nào với trạng thái này.';
        }
    } catch (error) {
        console.error('Error fetching events:', error);
        alert('Có lỗi xảy ra khi tải sự kiện.');
    }
}




async function updateEventStatus(eventId, status) {
    const comment = document.getElementById(`comment-${eventId}`).value;
    console.log(`Updating event ${eventId} with status: ${status} and comment: ${comment}`);

    try {
        const response = await fetch('update_event_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ event_id: eventId, status: status, admin_comment: comment }),
        });
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const data = await response.text();
        console.log('Update response:', data); // Kiểm tra phản hồi từ API
        alert(data);
        await loadAdminEvents(); // Tải lại sự kiện sau khi cập nhật
    } catch (error) {
        console.error('Error updating event status:', error);
        alert('Có lỗi xảy ra khi cập nhật trạng thái sự kiện.');
    }
}

// Hàm xóa sự kiện
async function deleteEvent(eventId) {
    const confirmDelete = confirm('Bạn có chắc chắn muốn xóa sự kiện này?');
    if (!confirmDelete) return; // Nếu người dùng không xác nhận, dừng hàm

    try {
        const response = await fetch('../html/delete_event.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ event_id: eventId }),
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const result = await response.text(); // Nhận phản hồi từ server
        alert(result); // Hiển thị phản hồi từ server

        // Tải lại danh sách sự kiện sau khi xóa
        loadAdminEvents();
    } catch (error) {
        console.error('Error deleting event:', error);
        alert('Có lỗi xảy ra khi xóa sự kiện: ' + error.message);
    }
}

// Gọi hàm để tải sự kiện khi trang web tải






    </script>




</body>
</html>
