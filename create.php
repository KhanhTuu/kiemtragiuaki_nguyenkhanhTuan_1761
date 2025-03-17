<?php
include 'db.php';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST["MaSV"];
    $HoTen = $_POST["HoTen"];
    $GioiTinh = $_POST["GioiTinh"];
    $NgaySinh = $_POST["NgaySinh"];
    $MaNganh = $_POST["MaNganh"];

    // Xử lý upload ảnh
    $target_dir = "assets/images/";
    $Hinh = basename($_FILES["Hinh"]["name"]);
    $target_file = $target_dir . $Hinh;
    move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);

    // Lưu vào CSDL
    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh)
            VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center">THÊM SINH VIÊN</h2>
    <form method="post" enctype="multipart/form-data" class="p-4 bg-light shadow rounded">
        Mã SV: <input type="text" name="MaSV" class="form-control" required>
        Họ tên: <input type="text" name="HoTen" class="form-control" required>
        Giới tính: 
        <select name="GioiTinh" class="form-select">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
        Ngày sinh: <input type="date" name="NgaySinh" class="form-control" required>
        Ảnh đại diện: <input type="file" name="Hinh" class="form-control" required>
        Mã Ngành: <input type="text" name="MaNganh" class="form-control" required>
        <input type="submit" value="Thêm Sinh Viên" class="btn btn-primary mt-3 w-100">
    </form>
</div>
