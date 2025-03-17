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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    <h2 class="text-center text-primary">Đăng Ký Học Phần</h2>
    
    <form method="post" class="p-4 bg-light shadow rounded">
        <label class="form-label">Chọn học phần:</label>
        <select class="form-select" name="MaHP" required>
            <option value="">-- Chọn học phần --</option>
            <?php while ($row = $hocphans->fetch_assoc()) { ?>
                <option value="<?= $row['MaHP'] ?>" <?= ($row['SoLuong'] <= 0) ? 'disabled' : '' ?>>
                    <?= $row['TenHP'] ?> (<?= $row['SoTinChi'] ?> tín chỉ) - 
                    <?= ($row['SoLuong'] > 0) ? "Còn {$row['SoLuong']} chỗ" : "Hết chỗ" ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary mt-3 w-100">Thêm học phần</button>
    </form>

    <div class="mt-4">
        <a href="registered.php" class="btn btn-success w-100">Xem học phần đã đăng ký</a>
    </div>
</div>
