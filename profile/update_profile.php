<?php
include '../assets/konektor.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Update data berdasarkan field yang dipilih
    switch ($field) {
        case 'nama':
            $query = "UPDATE users SET nama='$value' WHERE idusers='$user_id'";
            break;
        case 'email':
            $query = "UPDATE users SET email='$value' WHERE idusers='$user_id'";
            break;
        case 'password':
            $query = "UPDATE users SET password='$value' WHERE idusers='$user_id'";
            break;
    }

    mysqli_query($konektor, $query);

    // Redirect kembali ke halaman profil
    header("Location:profile.php?pesan=sukses");
    exit();
}

$konektor->close();
