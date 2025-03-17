<?php
session_start();
include 'db.php';
include 'navbar.php';

if (!isset($_SESSION["MaSV"])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION["MaSV"];

// Xác nhận đăng ký học phần
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_SESSION["cart"])) {
        $sql_dk = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), '$MaSV')";
        $conn->query($sql_dk);
        $MaDK = $conn->insert_id;

        foreach ($_SESSION["cart"] as $MaHP => $hocphan) {
            $sql_ct = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
            $conn->query($sql_ct);
        }

        // Xóa giỏ hàng sau khi lưu vào database
        unset($_SESSION["cart"]);

        header("Location: success.php");
        exit();
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center text-primary">Học Phần Đã Chọn</h2>

    <?php if (!empty($_SESSION["cart"])) { ?>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION["cart"] as $MaHP => $hocphan) { ?>
                <tr>
                    <td><?= $hocphan['MaHP'] ?></td>
                    <td><?= $hocphan['TenHP'] ?></td>
                    <td><?= $hocphan['SoTinChi'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <form method="post" class="text-center">
            <button type="submit" class="btn btn-success w-50">✅ Xác Nhận</button>
        </form>

    <?php } else { ?>
        <div class="alert alert-warning text-center">Bạn chưa chọn học phần nào!</div>
    <?php } ?>

    <div class="mt-3 text-center">
        <a href="register.php" class="btn btn-secondary">Trở về đăng ký</a>
    </div>
</div>
