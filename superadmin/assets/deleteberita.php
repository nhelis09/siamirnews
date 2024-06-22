<?php
include '../../assets/konektor.php';

$idberita = $_GET['idberita'];

$query = "DELETE FROM berita WHERE idberita='$idberita'";
$result = mysqli_query($konektor, $query);
$nama = ($_GET['idlapangan']);
$target = "../assets/fotoprofil/$nama.jpg";
if (file_exists($target)) {
    unlink($target);
}
if ($result) {
    header("location:../berita.php");
} else {
    echo "Gagal menghapus berita.";
}