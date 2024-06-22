<?php
//Script ini disimpan dengan nama file sendiri. Misalkan insertAdmin.php
// koneksi database
include '../../assets/konektor.php';

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
include '../../assets/cekinput.php';

// menangkap data yang di kirim dari form
$idberita = input($_POST['idberita']);
$idkomentar1 = input($_POST['idkomentar1']);
$isi = input($_POST['isi']);

// menginput data ke database
mysqli_query($konektor, "insert into komentar2 (idberita, idkomentar1, isi) values('$idberita', '$idkomentar1','$isi')");

// mengalihkan halaman kembali ke index.php
header("location: ../komentar2.php");
