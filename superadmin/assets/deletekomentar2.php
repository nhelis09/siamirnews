<?php
include '../../assets/konektor.php';

$idkomentar2 = $_GET['q'];

$query = "DELETE FROM komentar2  WHERE idkomentar2='$idkomentar2'";
$result = mysqli_query($konektor, $query);

if ($result) {
    header("location:../komentar2.php");
} else {
    echo "Gagal menghapus berita.";
}
