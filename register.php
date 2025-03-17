<?php
session_start();
include 'db.php';
include 'navbar.php';

// Kiểm tra sinh viên đã đăng nhập chưa
if (!isset($_SESSION["MaSV"])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION["MaSV"];

// Nếu sinh viên chọn đăng ký học phần
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["MaHP"])) {
    $MaHP = $_POST["MaHP"];

    // Kiểm tra số lượng học phần còn chỗ không
    $sql_check = "SELECT SoLuong FROM HocPhan WHERE MaHP='$MaHP'";
    $result = $conn->query($sql_check);
    $row = $result->fetch_assoc();

    if ($row["SoLuong"] > 0) {
        // Thêm vào bảng DangKy
        $sql1 = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), '$MaSV')";
        $conn->query($sql1);
        $MaDK = $conn->insert_id;

        // Thêm vào bảng ChiTietDangKy
        $sql2 = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
        $conn->query($sql2);

        // Giảm số lượng sinh viên dự kiến
        $sql_update = "UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP='$MaHP'";
        $conn->query($sql_update);

        $_SESSION['message'] = "✅ Đăng ký thành công!";
    } else {
        $_SESSION['message'] = "❌ Học phần này đã hết chỗ!";
    }
}

// Lấy danh sách học phần để hiển thị
$sql_hp = "SELECT * FROM HocPhan";
$hocphans = $conn->query($sql_hp);
?>

<div class="container mt-5">
    <h2 class="text-center text-primary">📌 Danh Sách Học Phần</h2>

    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-info text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php } ?>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Mã HP</th>
                <th>Tên Học Phần</th>
                <th>Số Tín Chỉ</th>
                <th>Số Lượng Còn</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $hocphans->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['MaHP'] ?></td>
                <td><?= $row['TenHP'] ?></td>
                <td><?= $row['SoTinChi'] ?></td>
                <td>
                    <span class="badge <?= ($row['SoLuong'] > 0) ? 'bg-success' : 'bg-danger' ?>">
                        <?= ($row['SoLuong'] > 0) ? $row['SoLuong'] : 'Hết chỗ' ?>
                    </span>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="MaHP" value="<?= $row['MaHP'] ?>">
                        <button type="submit" class="btn btn-primary btn-sm" <?= ($row['SoLuong'] <= 0) ? 'disabled' : '' ?>>
                            📝 Đăng Ký
                        </button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="registered.php" class="btn btn-success">✅ Xem Học Phần Đã Đăng Ký</a>
    </div>
</div>
