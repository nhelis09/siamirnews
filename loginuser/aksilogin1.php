<?php
include '../assets/konektor.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah email terdaftar
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $konektor->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($konektor->error));
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Verifikasi password langsung tanpa menggunakan password_verify
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['idusers'];
        header('Location:../index1.php');
    } else {
        header('Location:login1.php?error=email_password_incorrect');
    }
} else {
    header('Location:login1.php?error=email_not_registered');
}

$stmt->close();
$konektor->close();