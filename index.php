<?php
include 'db.php';
include 'navbar.php';

$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>
<div class="container mt-5">
    <h2 class="text-center text-primary">TRANG SINH VIÊN</h2>
    <a href="create.php" class="btn btn-success mb-3">➕ Thêm Sinh Viên</a>
    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>MaSV</th><th>HoTen</th><th>Giới Tính</th><th>Ngày Sinh</th><th>Hình</th><th>Ngành</th><th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['MaSV'] ?></td>
                <td><?= $row['HoTen'] ?></td>
                <td><?= $row['GioiTinh'] ?></td>
                <td><?= $row['NgaySinh'] ?></td>
                <td><img src="assets/images/<?= $row['Hinh'] ?>" width="80" class="rounded-circle"></td>
                <td><?= $row['MaNganh'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['MaSV'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                    <a href="delete.php?id=<?= $row['MaSV'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sinh viên này?')">🗑️ Xóa</a>
                    <a href="detail.php?id=<?= $row['MaSV'] ?>" class="btn btn-info btn-sm">🔍 Chi tiết</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
