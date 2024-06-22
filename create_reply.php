<?php
include 'assets/konektor.php';
include 'cekinput.php';
session_start();
if ($_SESSION['status'] != "login") {
    header("location:loginuser/login.php?pesan=belum_login");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = $_POST['comment_id'];
    $username = $_POST['username'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // Masukkan balasan ke dalam database
    $query = "INSERT INTO replies (comment_id, user_id, content, created_at) VALUES ('$comment_id', '$user_id', '$content', NOW())";
    if (mysqli_query($konektor, $query)) {
        header("Location: forum.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($konektor);
    }
}