<?php
session_start();
include('assets/konektor.php'); // Ganti dengan file koneksi database Anda

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("location:loginuser/login.php?pesan=belum_login");
    exit;
}

$user_id = $_SESSION['user_id'];


// Hapus notifikasi tunggal jika ada permintaan penghapusan (komentar)
if (isset($_GET['delete_comment_id'])) {
    $deleteCommentId = $_GET['delete_comment_id'];
    // Simpan ID notifikasi yang akan dihapus dalam variabel sesi
    $_SESSION['deleted_comment_ids'][] = $deleteCommentId;
}

// Hapus notifikasi tunggal jika ada permintaan penghapusan (balasan)
if (isset($_GET['delete_reply_id'])) {
    $deleteReplyId = $_GET['delete_reply_id'];
    // Simpan ID notifikasi yang akan dihapus dalam variabel sesi
    $_SESSION['deleted_reply_ids'][] = $deleteReplyId;
}

/// Tandai notifikasi sebagai sudah dibaca jika ada permintaan
if (isset($_GET['mark_as_read'])) {
    $markAsReadId = $_GET['mark_as_read'];
    // Hapus ID notifikasi dari variabel sesi (tandai sudah dibaca)
    if (($key = array_search($markAsReadId, $_SESSION['deleted_comment_ids'])) !== false) {
        unset($_SESSION['deleted_comment_ids'][$key]);
    }
    if (($key = array_search($markAsReadId, $_SESSION['deleted_reply_ids'])) !== false) {
        unset($_SESSION['deleted_reply_ids'][$key]);
    }
}

// Query untuk mendapatkan notifikasi tentang komentar pada topik pengguna
$commentNotificationsQuery = "
    SELECT comments.id AS comment_id, comments.content AS comment_content, comments.created_at AS comment_created_at,
           users.nama AS commenter_username, topics.title AS topic_title
    FROM comments
    JOIN topics ON comments.topic_id = topics.id
    JOIN users ON comments.user_id = users.idusers
    WHERE topics.user_id = $user_id
      AND comments.user_id != $user_id  -- Hanya berikan notifikasi jika komentar bukan dari pengguna itu sendiri
";

// Tambahkan kondisi untuk mengabaikan notifikasi yang ingin dihapus (komentar)
if (!empty($_SESSION['deleted_comment_ids'])) {
    $deletedCommentIds = implode(',', $_SESSION['deleted_comment_ids']);
    $commentNotificationsQuery .= " AND comments.id NOT IN ($deletedCommentIds)";
}

$commentNotificationsQuery .= " ORDER BY comments.created_at DESC";


$commentNotifications = mysqli_query($konektor, $commentNotificationsQuery);
if (!$commentNotifications) {
    echo 'Error: ' . mysqli_error($konektor);
}

// Query untuk mendapatkan notifikasi tentang balasan pada komentar pengguna
$replyNotificationsQuery = "
    SELECT replies.id AS reply_id, replies.content AS reply_content, replies.created_at AS reply_created_at,
           users.nama AS replier_username, comments.content AS comment_content
    FROM replies
    JOIN comments ON replies.comment_id = comments.id
    JOIN users ON replies.user_id = users.idusers
    WHERE comments.user_id = $user_id
      AND replies.user_id != $user_id  -- Hanya berikan notifikasi jika balasan bukan dari pengguna itu sendiri
";

// Tambahkan kondisi untuk mengabaikan notifikasi yang ingin dihapus (balasan)
if (!empty($_SESSION['deleted_reply_ids'])) {
    $deletedReplyIds = implode(',', $_SESSION['deleted_reply_ids']);
    $replyNotificationsQuery .= " AND replies.id NOT IN ($deletedReplyIds)";
}

$replyNotificationsQuery .= " ORDER BY replies.created_at DESC";

$replyNotifications = mysqli_query($konektor, $replyNotificationsQuery);
if (!$replyNotifications) {
    echo 'Error: ' . mysqli_error($konektor);
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .notification-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .notification-column {
        flex: 1;
        min-width: 300px;
    }

    .notification-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        padding: 10px;
        position: relative;
    }

    .delete-button {
        position: absolute;
        top: 5px;
        right: 10px;
        color: red;
        cursor: pointer;
    }

    .delete-all-button {
        margin-top: 20px;
    }

    .mark-as-read-button {
        position: absolute;
        top: 5px;
        right: 70px;
        color: blue;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Notifikasi</h2>
        <div class="notification-container">
            <div class="notification-column">
                <h4>Komentar pada Topik Anda</h4>
                <?php
                if ($commentNotifications && mysqli_num_rows($commentNotifications) > 0) {
                    while ($notification = mysqli_fetch_assoc($commentNotifications)) {
                        echo '<div class="list-group-item notification-card">';
                        echo '<a href="forum.php?focus_comment_id=' . $notification['comment_id'] . '">';
                        echo '<p><strong>' . htmlspecialchars($notification['commenter_username']) . '</strong> mengomentari topik Anda <strong>"' . htmlspecialchars($notification['topic_title']) . '"</strong></p>';
                        echo '<p>' . htmlspecialchars($notification['comment_content']) . '</p>';
                        echo '<small class="text-muted">' . date("d F Y H:i", strtotime($notification['comment_created_at'])) . '</small>';
                        echo '</a>';
                        echo '<a href="?delete_comment_id=' . $notification['comment_id'] . '" class="delete-button" onclick="return confirm(\'Anda yakin ingin menghapus notifikasi ini?\')">&times;</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Tidak ada notifikasi komentar.</p>';
                }
                ?>
            </div>

            <div class="notification-column">
                <h4>Balasan pada Komentar Anda</h4>
                <?php
                if ($replyNotifications && mysqli_num_rows($replyNotifications) > 0) {
                    while ($notification = mysqli_fetch_assoc($replyNotifications)) {
                        echo '<div class="list-group-item notification-card">';
                        echo '<a href="forum.php?focus_reply_id=' . $notification['reply_id'] . '">';
                        echo '<p><strong>' . htmlspecialchars($notification['replier_username']) . '</strong> membalas komentar Anda <strong>"' . htmlspecialchars($notification['comment_content']) . '"</strong></p>';
                        echo '<p>' . htmlspecialchars($notification['reply_content']) . '</p>';
                        echo '<small class="text-muted">' . date("d F Y H:i", strtotime($notification['reply_created_at'])) . '</small>';
                        echo '</a>';
                        echo '<a href="?delete_reply_id=' . $notification['reply_id'] . '" class="delete-button" onclick="return confirm(\'Anda yakin ingin menghapus notifikasi ini?\')">&times;</a>';
                        echo '<a href="?mark_as_read=' . $notification['reply_id'] . '" class="mark-as-read-button">Tandai Sudah Dibaca</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Tidak ada notifikasi balasan.</p>';
                }
                ?>
            </div>
        </div>

        <div class="text-center delete-all-button">
            <a href="?delete_all=true" class="btn btn-danger"
                onclick="return confirm('Anda yakin ingin menghapus semua notifikasi?')">Hapus Semua Notifikasi</a>
        </div>
        <a class="btn btn-primary" href="forum.php">Kembali</a>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>