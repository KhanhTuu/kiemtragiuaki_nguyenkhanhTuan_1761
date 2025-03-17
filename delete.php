<?php
include 'db.php';
$MaSV = $_GET['id'];
$conn->query("DELETE FROM SinhVien WHERE MaSV='$MaSV'");
header("Location: index.php");
?>
