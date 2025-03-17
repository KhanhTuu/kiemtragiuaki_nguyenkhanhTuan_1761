<?php
include 'db.php';
include 'navbar.php';

$MaSV = $_GET['id'];
$result = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$MaSV'");
$row = $result->fetch_assoc();
?>
<div class="container mt-5">
    <h2 class="text-center">THÔNG TIN CHI TIẾT</h2>
    <table class="table table-bordered">
        <tr><th>Mã SV</th><td><?= $row['MaSV'] ?></td></tr>
        <tr><th>Họ Tên</th><td><?= $row['HoTen'] ?></td></tr>
        <tr><th>Giới Tính</th><td><?= $row['GioiTinh'] ?></td></tr>
        <tr><th>Ngày Sinh</th><td><?= $row['NgaySinh'] ?></td></tr>
        <tr><th>Hình</th><td><img src="assets/images/<?= $row['Hinh'] ?>" width="100"></td></tr>
        <tr><th>Ngành</th><td><?= $row['MaNganh'] ?></td></tr>
    </table>
    <a href="edit.php?id=<?= $row['MaSV'] ?>" class="btn btn-warning">Sửa</a>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</div>
