<?php
include '../assets/konektor.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location:../loginuser/login.php?pesan=belum_login");
    exit();
}

$user_id = $_SESSION['user_id'];
$extensions = ['jpg', 'jpeg', 'png'];
$avatar_deleted = false;

foreach ($extensions as $ext) {
    $avatar_file = "uploads/avatars/$user_id.$ext";
    if (file_exists($avatar_file)) {
        unlink($avatar_file); // Hapus file avatar
        $avatar_deleted = true;
    }
}

if ($avatar_deleted) {
    $query = "UPDATE users SET avatar=NULL WHERE idusers='$user_id'";
    mysqli_query($konektor, $query);
    unset($_SESSION['avatar']); // Hapus avatar dari sesi
    echo "Avatar berhasil dihapus.";
} else {
    echo "Avatar tidak ditemukan.";
}