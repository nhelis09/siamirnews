<?php
include 'assets/konektor.php';
include 'filter.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: loginuser/login.php');
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect user to login page or show appropriate message
        exit("Anda harus login untuk mengakses halaman ini.");
    }

    $commentId = $_POST['comment_id'];
    $newContent = $_POST['content'];

    // Update comment in database
    $updateQuery = "UPDATE comments SET content = '$newContent' WHERE id = $commentId";
    $result = mysqli_query($konektor, $updateQuery);

    if ($result) {
        // Redirect user back to previous page or show success message
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // Handle error if update query fails
        exit("Terjadi kesalahan. Silakan coba lagi.");
    }
} else {
    // If accessed directly without POST request, show appropriate message or redirect
    exit("Akses tidak sah.");
}