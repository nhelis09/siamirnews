<?php
include '../../assets/konektor.php';

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai idberita dari form
    $idberita = $_POST['idberita'];

    // Mengambil nilai yang dikirim melalui form
    $idkategori = $_POST['idkategori'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggalpublikasi = $_POST['tanggalpublikasi'];
    $status = $_POST['status'];

    // Menyiapkan query update
    $query = "UPDATE berita SET idkategori='$idkategori', judul='$judul', isi='$isi', tanggalpublikasi='$tanggalpublikasi', status='$status' WHERE idberita='$idberita'";

    // Menjalankan query update
    if (mysqli_query($konektor, $query)) {
        // Jika query berhasil dijalankan, redirect ke halaman admin
        header("location:../berita.php");
        exit;
    } else {
        // Jika terdapat error saat menjalankan query, tampilkan pesan error
        echo "Error: " . $query . "<br>" . mysqli_error($konektor);
    }

    // Menutup koneksi database
    mysqli_close($konektor);
} else {
    // Jika halaman ini diakses secara langsung, redirect ke halaman admin
    header("location:../berita.php");
    exit;
}