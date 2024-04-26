<?php
include '../../assets/konektor.php';

$idkategori = $_GET['idkategori'];

$query = "DELETE FROM kategoriberita WHERE idkategori='$idkategori'";
$result = mysqli_query($konektor, $query);

if ($result) {
    header("location:../kategoriberita.php");
} else {
    echo "Gagal menghapus berita.";
}
