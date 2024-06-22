<?php
include 'assets/konektor.php';
session_start();



if (!isset($_GET['topic_id'])) {
    header('Location: forum.php?pesan=idtopiktidakvalid');
    exit();
}

$user_id = $_SESSION['user_id'];
$topic_id = $_GET['topic_id'];

$sql = "DELETE FROM topics WHERE id = ? AND user_id = ?";
$stmt = $konektor->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($konektor->error));
}

$stmt->bind_param('ii', $topic_id, $user_id);

if ($stmt->execute()) {
    header('Location: forum.php?pesan=berhasilhapus');
    exit();
} else {
    header('Location: forum.php?pesan=gagalhapus');
    exit();
}

$stmt->close();
$konektor->close();