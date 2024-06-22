<?php
session_start();

include 'assets/konektor.php'; // Pastikan file konektor.php sudah memuat koneksi ke database dengan benar.

if (isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];

    $query = "DELETE FROM comments WHERE id = $commentId";
    $result = mysqli_query($konektor, $query);

    if ($result) {
        header("location:forum.php?pesan=berasilhapus"); // Redirect ke halaman forum setelah berhasil menghapus komentar.
        exit();
    } else {
        header("location:forum.php?pesan=gagalhapus");
        // Anda bisa tambahkan tindakan lain untuk menangani kesalahan seperti log atau memberikan pesan error lebih spesifik.
    }
} else {
    header("location:forum.php?pesan=idtidakvalid");
    // Anda bisa tambahkan tindakan lain untuk menangani kasus di mana parameter comment_id tidak ditemukan atau tidak valid.
}