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

// Khi nhấn "Xác Nhận Đăng Ký"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    if (!empty($_SESSION["cart"])) {
        // Tạo một bản ghi mới trong bảng DangKy
        $sql_dk = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), '$MaSV')";
        $conn->query($sql_dk);
        $MaDK = $conn->insert_id;

        // Lưu học phần vào bảng ChiTietDangKy và giảm số lượng còn lại
        foreach ($_SESSION["cart"] as $MaHP => $hocphan) {
            $sql_ct = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
            $conn->query($sql_ct);

            // Cập nhật số lượng còn lại của học phần
            $sql_update = "UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP = '$MaHP'";
            $conn->query($sql_update);
        }

        // Xóa giỏ hàng sau khi lưu vào database
        unset($_SESSION["cart"]);

        // Chuyển hướng đến trang xác nhận thành công
        $_SESSION['message'] = "✅ Đăng ký học phần thành công!";
        header("Location: success.php");
        exit();
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center text-primary">📌 Học Phần Đã Chọn</h2>

    <?php if (!empty($_SESSION["cart"])) { ?>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION["cart"] as $MaHP => $hocphan) { ?>
                <tr>
                    <td><?= $hocphan['MaHP'] ?></td>
                    <td><?= $hocphan['TenHP'] ?></td>
                    <td><?= $hocphan['SoTinChi'] ?></td>
                    <td>
                        <a href="unregister.php?MaHP=<?= $MaHP ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa học phần này?')">
                            ❌ Hủy
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Form Xác Nhận Đăng Ký -->
        <form method="post" class="text-center mt-3">
            <button type="submit" name="confirm" class="btn btn-success w-50">✅ Xác Nhận Đăng Ký</button>
        </form>

    <?php } else { ?>
        <div class="alert alert-warning text-center">Bạn chưa chọn học phần nào!</div>
    <?php } ?>

    <div class="mt-3 text-center">
        <a href="register.php" class="btn btn-secondary">🔙 Trở về đăng ký</a>
    </div>
</div>
