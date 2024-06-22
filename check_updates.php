<?php
include 'assets/konektor.php';

// Contoh query untuk mendapatkan waktu terakhir perubahan dari beberapa tabel
$last_update_topics = mysqli_query($konektor, "SELECT MAX(updated_at) as last_update FROM topics");
$last_update_comments = mysqli_query($konektor, "SELECT MAX(updated_at) as last_update FROM comments");

$row_topics = mysqli_fetch_assoc($last_update_topics);
$row_comments = mysqli_fetch_assoc($last_update_comments);

// Mengambil waktu terakhir perubahan dari kedua tabel
$last_update = max($row_topics['last_update'], $row_comments['last_update']);

echo json_encode(['last_update' => $last_update]);