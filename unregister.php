<?php
session_start();
include 'db.php';

// Kiểm tra sinh viên đã đăng nhập chưa
if (!isset($_SESSION["MaSV"])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION["MaSV"];
$MaHP = $_GET['MaHP'] ?? null;

if ($MaHP) {
    // Tìm MaDK của sinh viên để xóa đúng bản ghi
    $sql = "SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV' ORDER BY NgayDK DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $MaDK = $row['MaDK'];

        // Xóa học phần khỏi bảng ChiTietDangKy
        $sql_delete = "DELETE FROM ChiTietDangKy WHERE MaDK = '$MaDK' AND MaHP = '$MaHP'";
        if ($conn->query($sql_delete)) {
            // Cập nhật lại số lượng học phần có thể đăng ký
            $sql_update = "UPDATE HocPhan SET SoLuong = SoLuong + 1 WHERE MaHP = '$MaHP'";
            $conn->query($sql_update);
            $_SESSION['message'] = "✅ Hủy học phần thành công!";
        } else {
            $_SESSION['message'] = "❌ Lỗi khi hủy học phần!";
        }
    } else {
        $_SESSION['message'] = "❌ Không tìm thấy đăng ký học phần!";
    }
}

header("Location: my_courses.php");
exit();
