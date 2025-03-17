<?php
include 'db.php';
include 'navbar.php';

$MaSV = $_GET['id'];
$result = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$MaSV'");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST["HoTen"];
    $GioiTinh = $_POST["GioiTinh"];
    $NgaySinh = $_POST["NgaySinh"];
    $MaNganh = $_POST["MaNganh"];

    if (!empty($_FILES["Hinh"]["name"])) {
        $Hinh = basename($_FILES["Hinh"]["name"]);
        $target_file = "assets/images/" . $Hinh;
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
    } else {
        $Hinh = $row["Hinh"];
    }

    $sql = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center">CHỈNH SỬA SINH VIÊN</h2>
    <form method="post" enctype="multipart/form-data" class="p-4 bg-light shadow rounded">
        Họ tên: <input type="text" name="HoTen" value="<?= $row['HoTen'] ?>" class="form-control" required>
        Giới tính: 
        <select name="GioiTinh" class="form-select">
            <option value="Nam" <?= $row['GioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= $row['GioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
        </select>
        Ngày sinh: <input type="date" name="NgaySinh" value="<?= $row['NgaySinh'] ?>" class="form-control" required>
        Ảnh đại diện: <input type="file" name="Hinh" class="form-control">
        Mã Ngành: <input type="text" name="MaNganh" value="<?= $row['MaNganh'] ?>" class="form-control" required>
        <input type="submit" value="Cập nhật" class="btn btn-primary mt-3 w-100">
    </form>
</div>
