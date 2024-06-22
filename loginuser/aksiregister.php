<?php
include '../assets/konektor.php'; // Hubungkan ke database

// Tangkap data dari formulir
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];

// Query untuk memeriksa apakah email sudah terdaftar
$check_query = "SELECT * FROM users WHERE email = '$email'";
$check_result = mysqli_query($konektor, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // Jika email sudah terdaftar, redirect kembali ke halaman pendaftaran dengan pesan error
    header("Location: registerakun.php?error=email_terdaftar");
    exit();
}

// Query untuk menyimpan data ke database
$query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";
$result = mysqli_query($konektor, $query);

if ($result) {
    // Jika berhasil disimpan, redirect ke halaman login
    header("Location:login.php?success=register");
    exit();
} else {
    // Jika gagal disimpan, redirect kembali ke halaman pendaftaran dengan pesan error
    header("Location: registerakun.php?error=database");
    exit();
}
