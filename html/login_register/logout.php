<?php

session_start();
session_unset();  // Xóa tất cả dữ liệu trong session
session_destroy();  // Hủy session
header('Location: ../../html/login_register/login.php');  // Chuyển hướng về trang đăng nhập
sleep(2);
exit();

?>
