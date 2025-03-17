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

// Nếu thêm học phần vào session
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaHP = $_POST["MaHP"];

    // Lấy thông tin học phần từ database
    $sql = "SELECT * FROM HocPhan WHERE MaHP='$MaHP'";
    $result = $conn->query($sql);
    $hocphan = $result->fetch_assoc();

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Kiểm tra nếu học phần đã tồn tại trong session thì không thêm lại
    if (!array_key_exists($MaHP, $_SESSION["cart"])) {
        $_SESSION["cart"][$MaHP] = $hocphan;
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
                <option value="<?= $row['MaHP'] ?>">
                    <?= $row['TenHP'] ?> (<?= $row['SoTinChi'] ?> tín chỉ)
                </option>
            <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary mt-3 w-100">Thêm vào giỏ hàng</button>
    </form>

    <div class="mt-4">
        <a href="registered.php" class="btn btn-success w-100">Xem học phần đã đăng ký</a>
    </div>
</div>
