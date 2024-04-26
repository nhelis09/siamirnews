<?php
//Script ini disimpan dengan nama file sendiri. Misalkan insertAdmin.php
// koneksi database
include '../../assets/konektor.php';

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
include '../../assets/cekinput.php';

// menangkap data yang di kirim dari form
$fariabel1 = input($_POST['kategori']);
$fariabel2 = input($_POST['nama']);
$fariabel3 = input($_POST['email']);
$fariabel4 = input($_POST['telepon']);
$fariabel5 = input($_POST['jeniskelamin']);
$fariabel6 = input($_POST['alamat']);
$fariabel7 = input($_POST['tempatlahir']);
$fariabel8 = input($_POST['tanggallahir']);
$fariabel9 = input($_POST['status']);
$fariabel10 = input($_POST['password']);

// menginput data ke database
mysqli_query($konektor, "insert into admin (kategori, nama, email, telepon, jeniskelamin, alamat, tempatlahir, tanggallahir, status, password) values('$fariabel1','$fariabel2','$fariabel3','$fariabel4','$fariabel5','$fariabel6','$fariabel7','$fariabel8','$fariabel9','$fariabel10')");

// mengalihkan halaman kembali ke index.php
header("location: ../admin.php");
