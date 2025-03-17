<?php
// Kiểm tra session trước khi khởi động để tránh lỗi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đăng Ký Học Phần</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome (Thêm icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS tùy chỉnh -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Test1</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-users"></i> Sinh Viên</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php"><i class="fas fa-edit"></i> Đăng Ký</a></li>
                <li class="nav-item"><a class="nav-link" href="my_courses.php"><i class="fas fa-book"></i> Học Phần Của Tôi</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION["MaSV"])) { ?>
                    <li class="nav-item"><a class="nav-link text-danger fw-bold" href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link text-success fw-bold" href="login.php"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>
