<?php
session_start();
include 'db.php';

// Kiểm tra sinh viên đã đăng nhập chưa
if (!isset($_SESSION["MaSV"])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION["MaSV"];

// Tìm tất cả MaDK của sinh viên
$sql = "SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $MaDK = $row['MaDK'];

        // Lấy danh sách các học phần để cập nhật số lượng chỗ còn trống
        $sql_hp = "SELECT MaHP FROM ChiTietDangKy WHERE MaDK = '$MaDK'";
        $result_hp = $conn->query($sql_hp);
        while ($hp = $result_hp->fetch_assoc()) {
            $MaHP = $hp['MaHP'];
            $sql_update = "UPDATE HocPhan SET SoLuong = SoLuong + 1 WHERE MaHP = '$MaHP'";
            $conn->query($sql_update);
        }

        // Xóa tất cả học phần khỏi bảng ChiTietDangKy
        $sql_delete_ct = "DELETE FROM ChiTietDangKy WHERE MaDK = '$MaDK'";
        $conn->query($sql_delete_ct);
    }

    // Xóa tất cả đăng ký học phần của sinh viên
    $sql_delete_dk = "DELETE FROM DangKy WHERE MaSV = '$MaSV'";
    $conn->query($sql_delete_dk);

    $_SESSION['message'] = "✅ Tất cả học phần đã được hủy!";
} else {
    $_SESSION['message'] = "❌ Không có học phần nào để hủy!";
}

header("Location: my_courses.php");
exit();
