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
    </script>
</head>
<body>
    <h1>Quản lý người dùng</h1>
    
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
    <p><a href="logout.php">Đăng xuất</a></p>
</body>
</html>
