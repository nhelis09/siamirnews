<?php
//Script ini diletakan pada halaman cekLogin.php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include '../../assets/konektor.php';

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
include 'cekinput.php';

// menangkap data yang dikirim dari form
$username = input($_POST['email']);
$sandi = input($_POST['password']);

// menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($konektor, "select * from admin where email='$username' and password='$sandi'");

// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);

if ($cek > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("location:../beranda.php");
} else {
    header("location:../index.php");
}