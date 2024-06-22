<?php
session_start(); // Memulai sesi
// Bersihkan variabel sesi notifikasi
unset($_SESSION['deleted_comment_ids']);
unset($_SESSION['deleted_reply_ids']);

// Lakukan penghapusan sesi
session_destroy();

header("Location:../index.php"); // Mengarahkan pengguna ke halaman login
exit(); // Menghentikan eksekusi skrip lebih lanjut