<?php
session_start();
include '../../assets/konektor.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:/index.php?pesan=belum_login");
    exit();
}

if (isset($_POST['idkategori'])) {
    $idkategori = $_POST['idkategori'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];

    $query = "UPDATE kategoriberita SET nama='$nama', keterangan='$keterangan' WHERE idkategori=$idkategori";
    $result = mysqli_query($konektor, $query);

    if ($result) {
        header("location:../kategoriberita.php?pesan=update_sukses");
    } else {
        header("location:../kategoriberita.php?pesan=update_gagal");
    }
}
