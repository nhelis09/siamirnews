<?php
include '../../assets/konektor.php';

$idkomentar1 = $_GET['q'];

$query = "DELETE FROM komentar1  WHERE idkomentar1='$idkomentar1'";
$result = mysqli_query($konektor, $query);

if ($result) {
    header("location:../komentar1.php");
} else {
    echo "Gagal menghapus berita.";
}
