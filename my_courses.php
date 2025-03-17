<?php
session_start();
include 'db.php';
include 'navbar.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION["MaSV"])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION["MaSV"];

// Lấy danh sách học phần sinh viên đã đăng ký
$sql = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi, DangKy.NgayDK 
        FROM DangKy
        JOIN ChiTietDangKy ON DangKy.MaDK = ChiTietDangKy.MaDK
        JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP
        WHERE DangKy.MaSV = '$MaSV'";

$result = $conn->query($sql);

// Tính tổng số tín chỉ đã đăng ký
$total_credits = 0;
$hocphans = [];
while ($row = $result->fetch_assoc()) {
    $hocphans[] = $row;
    $total_credits += $row['SoTinChi'];
}

// Xác nhận đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    if (!empty($hocphans)) {
        $_SESSION['message'] = "✅ Bạn đã đăng ký học phần thành công!";
        header("Location: success.php");
        exit();
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center text-primary">📌 Học Phần Đã Đăng Ký</h2>

    <?php if (!empty($hocphans)) { ?>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Ngày Đăng Ký</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocphans as $row) { ?>
                <tr>
                    <td><?= $row['MaHP'] ?></td>
                    <td><?= $row['TenHP'] ?></td>
                    <td><?= $row['SoTinChi'] ?></td>
                    <td><?= date("d-m-Y", strtotime($row['NgayDK'])) ?></td>
                    <td>
                        <a href="unregister.php?MaHP=<?= $row['MaHP'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn hủy học phần này?')">
                            ❌ Hủy
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Hiển thị Tổng Số Tín Chỉ -->
        <div class="text-center mt-3">
            <h5 class="fw-bold text-danger">📌 Tổng Số Tín Chỉ: <?= $total_credits ?> tín chỉ</h5>
        </div>

        <!-- Form Xác Nhận Đăng Ký -->
        <form method="post" class="text-center mt-3">
            <button type="submit" name="confirm" class="btn btn-success w-50">✅ Xác Nhận Đăng Ký</button>
        </form>

        <!-- Nút Xóa Tất Cả -->
        <div class="text-center mt-3">
            <a href="unregister_all.php" class="btn btn-warning btn-lg" onclick="return confirm('Bạn có chắc muốn hủy TẤT CẢ học phần đã đăng ký?')">
                🗑️ Xóa Tất Cả
            </a>
        </div>

    <?php } else { ?>
        <div class="alert alert-warning text-center">Bạn chưa đăng ký học phần nào!</div>
    <?php } ?>

    <div class="text-center mt-3">
        <a href="register.php" class="btn btn-primary">🔙 Quay lại Đăng Ký</a>
    </div>
</div>
