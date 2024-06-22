<?php
include 'assets/konektor.php';
include 'filter.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: loginuser/login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply_id = $_POST['reply_id'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // Periksa apakah balasan tersebut milik pengguna yang sedang login
    $result = mysqli_query($konektor, "SELECT * FROM replies WHERE id = $reply_id AND user_id = $user_id");
    if (mysqli_num_rows($result) > 0) {
        $stmt = mysqli_prepare($konektor, "UPDATE replies SET content = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $content, $reply_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

header("Location:forum.php");
exit();