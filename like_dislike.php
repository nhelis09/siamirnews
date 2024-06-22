<?php
include 'assets/konektor.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: loginuser/login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $target_id = $_POST['id'];
    $target_type = $_POST['type'];
    $action = $_POST['action'];

    // Periksa apakah pengguna sudah melakukan like atau dislike pada target ini
    $check = mysqli_query($konektor, "SELECT * FROM user_actions WHERE user_id = '$user_id' AND target_id = '$target_id' AND target_type = '$target_type'");
    if (mysqli_num_rows($check) > 0) {
        // Pengguna sudah melakukan tindakan sebelumnya
        $row = mysqli_fetch_assoc($check);
        if ($row['action'] === $action) {
            // Pengguna mencoba melakukan tindakan yang sama lagi, tidak lakukan apa-apa
            $response = [
                'success' => false,
                'message' => 'Action already performed'
            ];
            echo json_encode($response);
            exit;
        } else {
            // Pengguna mengubah tindakan, perbarui catatan di database
            mysqli_query($konektor, "UPDATE user_actions SET action = '$action' WHERE id = " . $row['id']);
        }
    } else {
        // Pengguna belum melakukan tindakan sebelumnya, tambahkan catatan baru ke database
        mysqli_query($konektor, "INSERT INTO user_actions (user_id, target_id, target_type, action) VALUES ('$user_id', '$target_id', '$target_type', '$action')");
    }

    // Hitung jumlah likes dan dislikes
    $likes = mysqli_query($konektor, "SELECT COUNT(*) as count FROM user_actions WHERE target_id = '$target_id' AND target_type = '$target_type' AND action = 'like'");
    $likes_count = mysqli_fetch_assoc($likes)['count'];
    $dislikes = mysqli_query($konektor, "SELECT COUNT(*) as count FROM user_actions WHERE target_id = '$target_id' AND target_type = '$target_type' AND action = 'dislike'");
    $dislikes_count = mysqli_fetch_assoc($dislikes)['count'];

    // Berikan respons JSON dengan jumlah likes dan dislikes yang diperbarui
    $response = [
        'success' => true,
        'likes' => $likes_count,
        'dislikes' => $dislikes_count
    ];
    echo json_encode($response);
} else {
    // Jika bukan request POST, kembalikan respons kosong
    http_response_code(405); // Metode tidak diizinkan
    exit;
}