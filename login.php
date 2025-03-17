

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST["MaSV"];
    
    $sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        session_start();
        $_SESSION["MaSV"] = $MaSV;
        header("Location: register.php");
    } else {
        $message = "❌ Mã sinh viên không tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Đăng nhập</h2>
        <?php if (isset($message)) { ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php } ?>
        <form method="post" class="p-4 bg-light shadow rounded">
            <label class="form-label">Mã Sinh Viên:</label>
            <input type="text" name="MaSV" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-3 w-100">Đăng nhập</button>
        </form>
    </div>
</body>
</html>

