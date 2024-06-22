<?php
// koneksi database
include '../assets/konektor.php';

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
include '../assets/cekinput.php';

// menangkap data yang dikirim dari form
$idberita = input($_POST['idberita']);
$idkomentar1 = input($_POST['idkomentar1']); // ID komentar yang dibalas
$isi = input($_POST['isi']);

// menginput data ke database
mysqli_query($konektor, "INSERT INTO komentar2 (idberita, idkomentar1, isi, tanggal ) VALUES ('$idberita', '$idkomentar1', '$isi', NOW())");

// mengalihkan halaman kembali ke detailberita.php
header("location: ../detailberita.php?id=$idberita");