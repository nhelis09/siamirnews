<?php
include 'assets/konektor.php';
include 'cekinput.php';

session_start();
if ($_SESSION['status'] != "login") {
    header("location:loginuser/login.php?pesan=belum_login");
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$content = $_POST['content'];

$sql = "INSERT INTO topics (user_id, title, content) VALUES (?, ?, ?)";
$stmt = $konektor->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($konektor->error));
}

$stmt->bind_param('iss', $user_id, $title, $content);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: forum.php');
} else {
    echo "Error: " . $sql . "<br>" . $konektor->error;
}

$stmt->close();
$konektor->close();