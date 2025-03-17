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
?>

<div class="container mt-5">
    <h2 class="text-center text-primary">📌 Học Phần Đã Đăng Ký</h2>

    <?php if ($result->num_rows > 0) { ?>
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
                <?php while ($row = $result->fetch_assoc()) { ?>
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
    <?php } else { ?>
        <div class="alert alert-warning text-center">Bạn chưa đăng ký học phần nào!</div>
    <?php } ?>

    <div class="text-center mt-3">
        <a href="register.php" class="btn btn-primary">🔙 Quay lại Đăng Ký</a>
    </div>
</div>
