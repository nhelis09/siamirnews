<?php
include 'assets/konektor.php';
include 'cekinput.php';
session_start();
if ($_SESSION['status'] != "login") {
    header("location:loginuser/login.php?pesan=belum_login");
}

// Check if content and topic_id are set in the POST array
if (!isset($_POST['content']) || !isset($_POST['topic_id'])) {
    die('Invalid form submission');
}

// Get user ID and topic ID from session and POST data
$user_id = $_SESSION['user_id'];
$topic_id = $_POST['topic_id'];
$content = $_POST['content'];

// Prepare SQL statement to insert comment
$sql = "INSERT INTO comments (topic_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $konektor->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($konektor->error));
}

// Bind parameters to the SQL statement
$stmt->bind_param('iis', $topic_id, $user_id, $content);

// Execute the SQL statement and check for success
if ($stmt->execute()) {
    header('Location: forum.php');
} else {
    echo "Error: " . $sql . "<br>" . $konektor->error;
}

$stmt->close();
$konektor->close();