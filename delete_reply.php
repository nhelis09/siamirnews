<?php
session_start();

include 'assets/konektor.php';
if (isset($_GET['reply_id'])) {
    $reply_id = $_GET['reply_id'];
    $user_id = $_SESSION['user_id'];

    // Hanya hapus balasan jika milik pengguna yang sedang login
    $query = "DELETE FROM replies WHERE id = $reply_id AND user_id = $user_id";
    $result = mysqli_query($konektor, $query);

    if ($result) {
        header("Location:forum.php?pesan=berhasilhapus");
        exit(); // Keluar dari script setelah mengarahkan header
    } else {
        header("Location:forum.php?pesan=gagalhapus");
        // Anda bisa tambahkan tindakan lain untuk menangani kesalahan seperti log atau memberikan pesan error lebih spesifik.
    }
} else {
    header("Location:forum.php?pesan=idbalasantidakvalid");
    // Anda bisa tambahkan tindakan lain untuk menangani kasus di mana parameter reply_id tidak ditemukan atau tidak valid.
}