<?php
include 'assets/konektor.php';
include 'filter.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: loginuser/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required POST data is set
    if (!isset($_POST['topic_id']) || !isset($_POST['title']) || !isset($_POST['content'])) {
        die('Invalid form submission');
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];
    // Get topic ID, title, and content from POST data
    $topic_id = $_POST['topic_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare SQL statement to update topic
    $sql = "UPDATE topics SET title=?, content=? WHERE id=? AND user_id=?";
    $stmt = $konektor->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($konektor->error));
    }

    // Bind parameters to the SQL statement
    $stmt->bind_param('ssii', $title, $content, $topic_id, $user_id);

    // Execute the SQL statement and check for success
    if ($stmt->execute()) {
        header('Location: forum.php');
    } else {
        echo "Error: " . $sql . "<br>" . $konektor->error;
    }

    $stmt->close();
    $konektor->close();
} else {
    header('Location: forum.php');
    exit();
}