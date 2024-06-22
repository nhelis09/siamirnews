<?php
include 'assets/konektor.php';
session_start();
function getAvatar($user_id)
{
    $target_dir = "profile/uploads/avatars/";
    $extensions = ['jpg', 'jpeg', 'png'];
    $avatar_file = "";

    foreach ($extensions as $ext) {
        $file = $target_dir . $user_id . "." . $ext;
        if (file_exists($file)) {
            $avatar_file = $file . '?v=' . filemtime($file); // Tambahkan timestamp terakhir kali modifikasi file
            break;
        }
    }

    if ($avatar_file) {
        return $avatar_file;
    } else {
        return $target_dir . "avatarkosong.jpg"; // Lokasi avatar default jika tidak ditemukan
    }
}

function shareToWhatsApp($link)
{
    return "https://wa.me/?text=" . urlencode($link);
}

function getLikes($target_id, $target_type)
{
    global $konektor;
    $result = mysqli_query($konektor, "SELECT COUNT(*) as count FROM user_actions WHERE target_id = '$target_id' AND target_type = '$target_type' AND action = 'like'");
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function getDislikes($target_id, $target_type)
{
    global $konektor;
    $result = mysqli_query($konektor, "SELECT COUNT(*) as count FROM user_actions WHERE target_id = '$target_id' AND target_type = '$target_type' AND action = 'dislike'");
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function getCommentCount($topic_id)
{
    global $konektor;
    $result = mysqli_query($konektor, "SELECT COUNT(*) as count FROM comments WHERE topic_id = '$topic_id'");
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}


function hasUserLiked($user_id, $target_id, $target_type)
{
    global $konektor;
    $query = "SELECT COUNT(*) as count FROM user_actions WHERE user_id = ? AND target_id = ? AND target_type = ? AND action = 'like'";
    $stmt = mysqli_prepare($konektor, $query);
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $target_id, $target_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

function hasUserDisliked($user_id, $target_id, $target_type)
{
    global $konektor;
    $query = "SELECT COUNT(*) as count FROM user_actions WHERE user_id = ? AND target_id = ? AND target_type = ? AND action = 'dislike'";
    $stmt = mysqli_prepare($konektor, $query);
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $target_id, $target_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

// Periksa apakah ada parameter focus_comment_id atau focus_reply_id
$focus_comment_id = isset($_GET['focus_comment_id']) ? $_GET['focus_comment_id'] : null;
$focus_reply_id = isset($_GET['focus_reply_id']) ? $_GET['focus_reply_id'] : null;


?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - Beranda</title>
    <?php include 'assets/cdn.php'; ?>
    <link rel="icon" href="assets/logo.png" type="image/x-icon">
    <style>
    .btn-like.active {
        color: blue;
    }

    .btn-dislike.active {
        color: red;
    }

    .highlight {
        background-color: burlywood;
    }

    .card {
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;

    }
    </style>
    <audio id="like-sound" src="audio/tombol.mp3"></audio>
    <audio id="dislike-sound" src="audio/tombol.mp3"></audio>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'superadmin/assets/cekdata.php'; ?>
    <div class="container pt-0 shadow p-0 mb-0 bg-secondary border">
        <?php include 'assets/banner.php'; ?>
        <?php include 'assets/navbar.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <marquee behavior="scroll" direction="left">
                    <p>
                    <h5 class="rainbow-text">
                        Selamat datang di forum diskusi
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo htmlspecialchars(namauser($_SESSION['user_id'])) . "🎉✨";
                        } else {
                            echo ". Yuk login terlebih dahulu 😁🤗";
                        }
                        ?>
                    </h5>
                    </p>
                </marquee>

                <hr>
                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Tambahkan Topic Baru</h5>
                            <form id="topicForm" action="create_topic.php" method="post">
                                <small>
                                    <div id="loading" style="display: none; text-align: center;">
                                        <img src="https://websiamirnews22110023.my.id/assets/Animationbekerja.gif"
                                            alt="Loading..." />
                                    </div>
                                </small>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Isi</label>
                                    <textarea class="form-control" id="content" name="content" rows="3"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-send"></i> Posting
                                </button>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="col-md-8">
                    <center>
                        <h5 class="card-title">Semua Postingan </h5>
                    </center>
                    <a class="nav-link me-3" href="notifikasi.php">
                        <i class="bi bi-person"></i> Notifikasi
                    </a>


                    <?php
                    // Query to get topics
                    $data = mysqli_query($konektor, "SELECT * FROM topics ORDER BY created_at DESC");

                    while ($d = mysqli_fetch_array($data)) {
                        // Query to count comments for each topic
                        $commentCountResult = mysqli_query($konektor, "SELECT COUNT(*) as comment_count FROM comments WHERE topic_id = " . $d['id']);
                        $commentCount = mysqli_fetch_assoc($commentCountResult)['comment_count'];
                    ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <?php
                                $avatar = getAvatar($d['user_id']);
                                echo '<a href="' . htmlspecialchars($avatar) . '" target="_blank"><img src="' . htmlspecialchars($avatar) . '" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;"></a>';
                                echo htmlspecialchars(namauser($d['user_id']));

                                if (isset($_SESSION['user_id']) && $d['user_id'] == $_SESSION['user_id']) {
                                ?>
                            <div class="dropdown" style="display: inline;">
                                <span type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                    title="Aksi Selengkapnya.." aria-expanded="false"
                                    style="cursor: pointer; color: blue; font-weight: bold;">
                                    <h4>
                                        ...
                                    </h4>
                                </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item btn-edit-topic" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editTopicModal" data-topic-id="<?php echo $d['id']; ?>"
                                            data-topic-title="<?php echo htmlspecialchars($d['title']); ?>"
                                            data-topic-content="<?php echo htmlspecialchars($d['content']); ?>"
                                            title="Ubah Postingan Anda">
                                            Ubah
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="delete_topic.php?topic_id=<?php echo $d['id']; ?>"
                                            onclick="return confirm('Apakah Anda ingin menghapus topik ini?')"
                                            title="Hapus Postingan Anda">
                                            Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php
                                }
                                ?>


                            <p class="card-text">Judul:<b> <?php echo htmlspecialchars($d['title']); ?></b></p>

                            <?php
                                $content = htmlspecialchars($d['content']);
                                if (strlen($content) > 250) {
                                    $short_content = substr($content, 0, 250);
                                    echo '<p class="card-text">Isi: <span class="short-content">' . $short_content . '...</span>';
                                    echo '<span class="full-content" style="display:none;">' . $content . '</span>';
                                    echo ' <a href="javascript:void(0);" class="lihat-selengkapnya">Lihat Selengkapnya</a>';
                                    echo ' <a href="javascript:void(0);" class="tutup-selengkapnya" style="display:none;">Tutup</a></p>';
                                } else {
                                    echo '<p class="card-text">Isi: ' . $content . '</p>';
                                }
                                ?>

                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const lihatSelengkapnyaLinks = document.querySelectorAll('.lihat-selengkapnya');
                                const tutupSelengkapnyaLinks = document.querySelectorAll('.tutup-selengkapnya');
                                const shortContents = document.querySelectorAll('.short-content');
                                const fullContents = document.querySelectorAll('.full-content');

                                lihatSelengkapnyaLinks.forEach(link => {
                                    link.addEventListener('click', function() {
                                        const shortContent = this.previousElementSibling
                                            .previousElementSibling;
                                        const fullContent = this.previousElementSibling;
                                        const tutupSelengkapnyaLink = this.nextElementSibling;
                                        shortContent.style.display = 'none';
                                        fullContent.style.display = 'inline';
                                        this.style.display = 'none';
                                        tutupSelengkapnyaLink.style.display = 'inline';
                                    });
                                });

                                tutupSelengkapnyaLinks.forEach(link => {
                                    link.addEventListener('click', function() {
                                        const fullContent = this.previousElementSibling
                                            .previousElementSibling;
                                        const shortContent = fullContent.previousElementSibling;
                                        const lihatSelengkapnyaLink = this
                                            .previousElementSibling;
                                        shortContent.style.display = 'inline';
                                        fullContent.style.display = 'none';
                                        this.style.display = 'none';
                                        lihatSelengkapnyaLink.style.display = 'inline';
                                    });
                                });

                                shortContents.forEach(content => {
                                    content.addEventListener('dblclick', function(event) {
                                        event
                                            .preventDefault(); // Mencegah fungsi copy saat dobel klik
                                        const fullContent = this.nextElementSibling;
                                        const lihatSelengkapnyaLink = fullContent
                                            .nextElementSibling;
                                        const tutupSelengkapnyaLink = lihatSelengkapnyaLink
                                            .nextElementSibling;
                                        this.style.display = 'none';
                                        fullContent.style.display = 'inline';
                                        lihatSelengkapnyaLink.style.display = 'none';
                                        tutupSelengkapnyaLink.style.display = 'inline';
                                    });
                                });

                                fullContents.forEach(content => {
                                    content.addEventListener('dblclick', function(event) {
                                        event
                                            .preventDefault(); // Mencegah fungsi copy saat dobel klik
                                        const shortContent = this.previousElementSibling;
                                        const lihatSelengkapnyaLink = this.nextElementSibling;
                                        const tutupSelengkapnyaLink = lihatSelengkapnyaLink
                                            .nextElementSibling;
                                        this.style.display = 'none';
                                        shortContent.style.display = 'inline';
                                        tutupSelengkapnyaLink.style.display = 'none';
                                        lihatSelengkapnyaLink.style.display = 'inline';
                                    });
                                });
                            });
                            </script>




                            <p class="card-text"><small class="text-muted">
                                    <!-- Like and Dislike Buttons -->
                                    <div class="like-dislike-buttons">
                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-like <?php echo hasUserLiked($_SESSION['user_id'], $d['id'], 'topic') ? 'active' : ''; ?>"
                                            title="Like" data-id="<?php echo $d['id']; ?>" data-type="topic">
                                            <i class="bi bi-hand-thumbs-up"></i> <span
                                                class="like-count"><?php echo getLikes($d['id'], 'topic'); ?></span>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-dislike <?php echo hasUserDisliked($_SESSION['user_id'], $d['id'], 'topic') ? 'active' : ''; ?>"
                                            title="Dislike" data-id="<?php echo $d['id']; ?>" data-type="topic">
                                            <i class="bi bi-hand-thumbs-down"></i> <span
                                                class="dislike-count"><?php echo getDislikes($d['id'], 'topic'); ?></span>
                                        </a>
                                    </div>
                                    Diposting pada
                                    <?php echo date("d F Y H:i", strtotime($d['created_at'])); ?>
                                </small>
                            </p>
                            <a href="#" class="btn btn-primary btn-comment" data-bs-toggle="modal"
                                data-bs-target="#commentModal" data-topic-id="<?php echo $d['id']; ?>"
                                data-topic-title="<?php echo htmlspecialchars($d['title']); ?>"
                                data-topic-content="<?php echo htmlspecialchars($d['content']); ?>"
                                title="Berikan Komentar Anda">
                                <i class="bi bi-chat-left"></i>
                            </a>

                            <?php
                                $forumLink = "SiamirNews: " . htmlspecialchars($d['title']) . ". Selengkapnya: http://www.websiamirnews22110023.my.id/forum.php?id=" . $d['id'];
                                ?>
                            <a href="<?php echo shareToWhatsApp($forumLink); ?>" target="_blank" class="btn btn-success"
                                title="Bagikan Postingan Ini Ke Whatsapp">
                                <i class="bi bi-whatsapp"></i>
                            </a>



                            <center class="lihatKomentar" data-topic-id="<?php echo $d['id']; ?>"
                                style="cursor: pointer;">
                                Lihat (<?php echo $commentCount; ?>) Komentar
                            </center>


                            <div id="commentsSection-<?php echo $d['id']; ?>" class="comments-section"
                                style="display: none;">
                                <!-- Di dalam loop komentar -->
                                <?php
                                    $comments = mysqli_query($konektor, "SELECT * FROM comments WHERE topic_id = " . $d['id'] . " ORDER BY created_at DESC");
                                    if (mysqli_num_rows($comments) > 0) {
                                        while ($c = mysqli_fetch_array($comments)) {
                                            $userDetails = mysqli_query($konektor, "SELECT * FROM users WHERE idusers = " . $c['user_id']);
                                            $user = mysqli_fetch_assoc($userDetails);
                                            $userAvatar = getAvatar($c['user_id']);


                                            // Menghitung jumlah balasan untuk komentar ini
                                            $replyCountResult = mysqli_query($konektor, "SELECT COUNT(*) as reply_count FROM replies WHERE comment_id = " . $c['id']);
                                            $replyCountRow = mysqli_fetch_assoc($replyCountResult);
                                            $replyCount = $replyCountRow['reply_count'];

                                            $highlightClass = ($focus_comment_id == $c['id']) ? 'highlight' : '';

                                    ?>
                                <div id="comment-<?php echo $c['id']; ?>"
                                    class="comment mt-3 <?php echo $highlightClass; ?>"
                                    style="border-left: 2px solid #ccc; padding-left: 10px;">
                                    <a href="<?php echo htmlspecialchars($userAvatar); ?>" target="_blank">
                                        <img src="<?php echo htmlspecialchars($userAvatar); ?>" alt="."
                                            style="width: 30px; height: 30px; border-radius: 50%;">
                                    </a>
                                    <?php echo htmlspecialchars(namauser($c['user_id'])); ?>

                                    <p><?php echo htmlspecialchars($c['content']); ?></p>

                                    <!-- Like and Dislike Buttons for Comments -->
                                    <div class="like-dislike-buttons">
                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-like <?php echo hasUserLiked($_SESSION['user_id'], $c['id'], 'comment') ? 'active' : ''; ?>"
                                            title="Like" data-id="<?php echo $c['id']; ?>" data-type="comment">
                                            <i class="bi bi-hand-thumbs-up"></i> <span
                                                class="like-count"><?php echo getLikes($c['id'], 'comment'); ?></span>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-sm btn-dislike <?php echo hasUserDisliked($_SESSION['user_id'], $c['id'], 'comment') ? 'active' : ''; ?>"
                                            title="Dislike" data-id="<?php echo $c['id']; ?>" data-type="comment">
                                            <i class="bi bi-hand-thumbs-down"></i> <span
                                                class="dislike-count"><?php echo getDislikes($c['id'], 'comment'); ?></span>
                                        </a>
                                    </div>

                                    <!-- Button to reply to comment -->
                                    <a href="#" class="btn btn-sm " data-bs-toggle="modal" data-bs-target="#replyModal"
                                        data-comment-id="<?php echo $c['id']; ?>" title="Balas Komentar"
                                        data-comment-content="<?php echo htmlspecialchars($c['content']); ?>">
                                        <i class="bi bi-reply"></i> Balas
                                    </a>

                                    <!-- Edit and Delete buttons -->
                                    <?php if (isset($_SESSION['user_id']) && $c['user_id'] == $_SESSION['user_id']) { ?>
                                    <a href="#" class="btn btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editCommentModal" data-comment-id="<?php echo $c['id']; ?>"
                                        data-comment-content="<?php echo htmlspecialchars($c['content']); ?>"
                                        title="Ubah Komentar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete_comment.php?comment_id=<?php echo $c['id']; ?>" class="btn btn-sm"
                                        onclick="return confirm('Apakah Anda ingin menghapus komentar ini?')"
                                        title="Hapus Komentar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php } ?>

                                    <p>
                                        <small class="text-muted">Dikomentari pada
                                            <?php echo date("d F Y H:i", strtotime($c['created_at'])); ?></small>
                                    </p>

                                    <!-- Button to toggle replies -->
                                    <a href="#" class="btn btn-sm comment-toggle"
                                        data-comment-id="<?php echo $c['id']; ?>"
                                        data-reply-count="<?php echo $replyCount; ?>">
                                        <i class="bi bi-chevron-down"></i> Lihat (<?php echo $replyCount; ?>) Balasan
                                    </a>

                                    <!-- Fetch and display replies -->
                                    <div class="replies" id="replies-<?php echo $c['id']; ?>" style="display: none;">
                                        <?php
                                                    $replies = mysqli_query($konektor, "SELECT * FROM replies WHERE comment_id = " . $c['id'] . " ORDER BY created_at DESC");
                                                    while ($r = mysqli_fetch_array($replies)) {
                                                        $replyUserDetails = mysqli_query($konektor, "SELECT * FROM users WHERE idusers = " . $r['user_id']);
                                                        $replyUser = mysqli_fetch_assoc($replyUserDetails);
                                                        $replyUserAvatar = getAvatar($r['user_id']);
                                                    ?>
                                        <div class="reply mt-2"
                                            style="border-left: 2px solid #ccc; padding-left: 10px;">
                                            <a href="<?php echo htmlspecialchars($replyUserAvatar); ?>" target="_blank">
                                                <img src="<?php echo htmlspecialchars($replyUserAvatar); ?>" alt="."
                                                    style="width: 25px; height: 25px; border-radius: 50%;">
                                            </a>
                                            <?php echo htmlspecialchars(namauser($r['user_id'])); ?>
                                            <p><?php echo htmlspecialchars($r['content']); ?></p>

                                            <!-- Like and Dislike Buttons for Replies -->
                                            <div class="like-dislike-buttons">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-sm btn-like <?php echo hasUserLiked($_SESSION['user_id'], $r['id'], 'reply') ? 'active' : ''; ?>"
                                                    title="Like" data-id="<?php echo $r['id']; ?>" data-type="reply">
                                                    <i class="bi bi-hand-thumbs-up"></i> <span
                                                        class="like-count"><?php echo getLikes($r['id'], 'reply'); ?></span>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-sm btn-dislike <?php echo hasUserDisliked($_SESSION['user_id'], $r['id'], 'reply') ? 'active' : ''; ?>"
                                                    title="Dislike" data-id="<?php echo $r['id']; ?>" data-type="reply">
                                                    <i class="bi bi-hand-thumbs-down"></i> <span
                                                        class="dislike-count"><?php echo getDislikes($r['id'], 'reply'); ?></span>
                                                </a>
                                            </div>

                                            <!-- Edit and Delete buttons for replies -->
                                            <?php if (isset($_SESSION['user_id']) && $r['user_id'] == $_SESSION['user_id']) { ?>
                                            <a href="#" class="btn btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editReplyModal" data-reply-id="<?php echo $r['id']; ?>"
                                                data-reply-content="<?php echo htmlspecialchars($r['content']); ?>"
                                                title="Edit Balasan">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete_reply.php?reply_id=<?php echo $r['id']; ?>"
                                                class="btn btn-sm"
                                                onclick="return confirm('Apakah Anda ingin menghapus balasan ini?')"
                                                title="Hapus Balasan">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <?php } ?>


                                            <p>
                                                <small class="text-muted">Dibalas pada
                                                    <?php echo date("d F Y H:i", strtotime($r['created_at'])); ?></small>
                                            </p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                        }
                                    } else {
                                        echo '<p class="no-comments">Komentar tidak tersedia</p>';
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>


                <!-- LIHAT KOMENTAR -->
                <script>
                document.querySelectorAll('.lihatKomentar').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var topicId = button.getAttribute('data-topic-id');
                        var commentsSection = document.getElementById('commentsSection-' + topicId);
                        if (commentsSection.style.display === 'none' || commentsSection.style
                            .display === '') {
                            commentsSection.style.display = 'block';
                            button.textContent = 'Sembunyikan Komentar';
                            button.style.color = 'blue'; // Mengubah warna teks tombol menjadi biru
                            if (commentsSection.querySelector('.comment') === null && commentsSection
                                .querySelector('.no-comments') === null) {
                                commentsSection.innerHTML +=
                                    '<p class="no-comments">Komentar tidak tersedia</p>';
                            }
                        } else {
                            commentsSection.style.display = 'none';
                            var commentCount = commentsSection.querySelectorAll('.comment').length;
                            button.textContent = 'Lihat (' + commentCount + ') Komentar';
                            button.style.color = ''; // Mengembalikan warna teks tombol ke warna default
                            // Hapus pesan "Komentar tidak tersedia" saat menyembunyikan bagian komentar
                            var noCommentsMessage = commentsSection.querySelector('.no-comments');
                            if (noCommentsMessage) {
                                noCommentsMessage.remove();
                            }
                        }
                    });
                });

                document.querySelectorAll('.lihat-selengkapnya').forEach(function(link) {
                    link.addEventListener('click', function() {
                        var cardBody = link.closest('.card-body');
                        cardBody.querySelector('.short-content').style.display = 'none';
                        cardBody.querySelector('.full-content').style.display = 'inline';
                        cardBody.querySelector('.lihat-selengkapnya').style.display = 'none';
                        cardBody.querySelector('.tutup-selengkapnya').style.display = 'inline';
                    });
                });

                document.querySelectorAll('.tutup-selengkapnya').forEach(function(link) {
                    link.addEventListener('click', function() {
                        var cardBody = link.closest('.card-body');
                        cardBody.querySelector('.short-content').style.display = 'inline';
                        cardBody.querySelector('.full-content').style.display = 'none';
                        cardBody.querySelector('.lihat-selengkapnya').style.display = 'inline';
                        cardBody.querySelector('.tutup-selengkapnya').style.display = 'none';
                    });
                });



                // LIHAT  BALASAN
                document.querySelectorAll('.comment-toggle').forEach(function(link) {
                    var replyCount = link.getAttribute('data-reply-count');
                    link.innerHTML = '<i class="bi bi-chevron-down"></i> Lihat (' + replyCount + ') Balasan';

                    link.addEventListener('click', function(e) {
                        e.preventDefault(); // Prevent default anchor behavior
                        var commentId = link.getAttribute('data-comment-id');
                        var repliesSection = document.getElementById('replies-' + commentId);
                        if (repliesSection.style.display === 'none' || repliesSection.style.display ===
                            '') {
                            repliesSection.style.display = 'block';
                            link.innerHTML = '<i class="bi bi-chevron-up"></i> Sembunyikan Balasan';
                        } else {
                            repliesSection.style.display = 'none';
                            link.innerHTML = '<i class="bi bi-chevron-down"></i> Lihat (' + replyCount +
                                ') Balasan';
                        }

                        // Check if there are no replies
                        if (repliesSection.querySelectorAll('.reply').length === 0) {
                            repliesSection.innerHTML =
                                '<p class="no-replies">Balasan tidak tersedia</p>';
                        }
                    });
                });
                </script>

                <!-- bagian mencari komen dan balasan dari notifikasi -->
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Periksa apakah URL memiliki parameter focus_comment_id atau focus_reply_id
                    const urlParams = new URLSearchParams(window.location.search);
                    const focusCommentId = urlParams.get('focus_comment_id');
                    const focusReplyId = urlParams.get('focus_reply_id');

                    if (focusCommentId) {
                        // Buka bagian komentar
                        const commentSection = document.querySelector(`#commentsSection-${focusCommentId}`);
                        if (commentSection) {
                            commentSection.style.display = 'block';
                        }

                        // Soroti dan gulir ke komentar yang dituju
                        const comment = document.querySelector(`#comment-${focusCommentId}`);
                        if (comment) {
                            comment.classList.add('highlight');
                            comment.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }

                    if (focusReplyId) {
                        // Temukan komentar induk dari balasan
                        const reply = document.querySelector(`#reply-${focusReplyId}`);
                        if (reply) {
                            const commentId = reply.closest('.comment').getAttribute('data-comment-id');
                            const commentSection = document.querySelector(`#commentsSection-${commentId}`);
                            if (commentSection) {
                                commentSection.style.display = 'block';
                            }

                            // Buka bagian balasan
                            const repliesSection = document.querySelector(`#replies-${commentId}`);
                            if (repliesSection) {
                                repliesSection.style.display = 'block';
                            }

                            // Soroti dan gulir ke balasan yang dituju
                            reply.classList.add('highlight');
                            reply.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                });
                </script>


            </div>
        </div>
    </div>

    <!-- Edit Topic Modal -->
    <div class="modal fade" id="editTopicModal" tabindex="-1" aria-labelledby="editTopicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTopicModalLabel">Edit Topik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_topic.php" method="post">
                        <input type="hidden" id="edit-topic-id" name="topic_id">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-content" class="form-label">Isi</label>
                            <textarea class="form-control" id="edit-content" name="content" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="create_comment.php" method="post">
                        <input type="hidden" id="comment-topic-id" name="topic_id">
                        <div class="mb-3">
                            <label for="comment-content" class="form-label">Isi Komentar</label>
                            <textarea class="form-control" id="comment-content" name="content" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Posting Komentar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Balas Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="create_reply.php" method="post">
                        <input type="hidden" id="reply-comment-id" name="comment_id">
                        <div class="mb-3">
                            <label for="reply-content" class="form-label">Isi Balasan</label>
                            <textarea class="form-control" id="reply-content" name="content" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Posting Balasan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var editTopicModal = document.getElementById('editTopicModal');
        var commentModal = document.getElementById('commentModal');
        var replyModal = document.getElementById('replyModal');

        editTopicModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var topicId = button.getAttribute('data-topic-id');
            var topicTitle = button.getAttribute('data-topic-title');
            var topicContent = button.getAttribute('data-topic-content');

            var modalTitleInput = editTopicModal.querySelector('.modal-body #edit-title');
            var modalContentInput = editTopicModal.querySelector('.modal-body #edit-content');
            var modalTopicIdInput = editTopicModal.querySelector('.modal-body #edit-topic-id');

            modalTitleInput.value = topicTitle;
            modalContentInput.value = topicContent;
            modalTopicIdInput.value = topicId;
        });

        commentModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var topicId = button.getAttribute('data-topic-id');

            var modalTopicIdInput = commentModal.querySelector('.modal-body #comment-topic-id');
            modalTopicIdInput.value = topicId;
        });

        replyModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var commentId = button.getAttribute('data-comment-id');

            var modalCommentIdInput = replyModal.querySelector('.modal-body #reply-comment-id');
            modalCommentIdInput.value = commentId;
        });
    });
    </script>

    <!-- Edit Comment Modal -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommentModalLabel">Edit Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_comment.php" method="post">
                        <input type="hidden" id="edit-comment-id" name="comment_id">
                        <div class="mb-3">
                            <label for="edit-comment-content" class="form-label">Isi Komentar</label>
                            <textarea class="form-control" id="edit-comment-content" name="content" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Reply Modal -->
    <div class="modal fade" id="editReplyModal" tabindex="-1" aria-labelledby="editReplyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReplyModalLabel">Edit Balasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_reply.php" method="post">
                        <input type="hidden" id="edit-reply-id" name="reply_id">
                        <div class="mb-3">
                            <label for="edit-reply-content" class="form-label">Isi Balasan</label>
                            <textarea class="form-control" id="edit-reply-content" name="content" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var editCommentModal = document.getElementById('editCommentModal');
        var editReplyModal = document.getElementById('editReplyModal');

        editCommentModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var commentId = button.getAttribute('data-comment-id');
            var commentContent = button.getAttribute('data-comment-content');

            var modalContentInput = editCommentModal.querySelector(
                '.modal-body #edit-comment-content');
            var modalCommentIdInput = editCommentModal.querySelector(
                '.modal-body #edit-comment-id');

            modalContentInput.value = commentContent;
            modalCommentIdInput.value = commentId;
        });

        editReplyModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var replyId = button.getAttribute('data-reply-id');
            var replyContent = button.getAttribute('data-reply-content');

            var modalContentInput = editReplyModal.querySelector('.modal-body #edit-reply-content');
            var modalReplyIdInput = editReplyModal.querySelector('.modal-body #edit-reply-id');

            modalContentInput.value = replyContent;
            modalReplyIdInput.value = replyId;
        });
    });
    </script>

    <!-- REPLLYA MODAL -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var replyModal = document.getElementById('replyModal');

        replyModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var commentId = button.getAttribute('data-comment-id');
            var commentContent = button.getAttribute('data-comment-content');

            var modalCommentIdInput = replyModal.querySelector('.modal-body #reply-comment-id');

            modalCommentIdInput.value = commentId;
        });
    });
    </script>




    <script>
    document.querySelectorAll('.btn-like').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            const isActive = btn.classList.contains('active');

            // Ambil elemen audio
            const likeSound = document.getElementById('like-sound');

            if (isActive) {
                fetch('like_dislike.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&type=${type}&action=unlike`
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        btn.querySelector('.like-count').textContent = data.likes;
                        btn.classList.remove('active');
                    }
                });
            } else {
                const dislikeBtn = btn.nextElementSibling;
                const isDislikeActive = dislikeBtn.classList.contains('active');
                if (isDislikeActive) {
                    dislikeBtn.querySelector('.dislike-count').textContent--;
                    dislikeBtn.classList.remove('active');
                }

                fetch('like_dislike.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&type=${type}&action=like`
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        btn.querySelector('.like-count').textContent = data.likes;
                        dislikeBtn.querySelector('.dislike-count').textContent = data.dislikes;
                        btn.classList.add('active');
                        dislikeBtn.classList.remove('active');

                        // Putar bunyi like
                        likeSound.play();
                    }
                });
            }
        });
    });

    document.querySelectorAll('.btn-dislike').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const type = btn.getAttribute('data-type');
            const isActive = btn.classList.contains('active');

            // Ambil elemen audio
            const dislikeSound = document.getElementById('dislike-sound');

            if (isActive) {
                fetch('like_dislike.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&type=${type}&action=undislike`
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        btn.querySelector('.dislike-count').textContent = data.dislikes;
                        btn.classList.remove('active');
                    }
                });
            } else {
                const likeBtn = btn.previousElementSibling;
                const isLikeActive = likeBtn.classList.contains('active');
                if (isLikeActive) {
                    likeBtn.querySelector('.like-count').textContent--;
                    likeBtn.classList.remove('active');
                }

                fetch('like_dislike.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&type=${type}&action=dislike`
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        btn.querySelector('.dislike-count').textContent = data.dislikes;
                        likeBtn.querySelector('.like-count').textContent = data.likes;
                        btn.classList.add('active');
                        likeBtn.classList.remove('active');

                        // Putar bunyi dislike
                        dislikeSound.play();
                    }
                });
            }
        });
    });
    </script>

    <!-- PROSES LOADING -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('topicForm');
        const loading = document.getElementById('loading');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form untuk langsung submit

            loading.style.display = 'block'; // Tampilkan animasi loading

            // Submit form setelah menampilkan loading untuk mengirim data
            setTimeout(function() {
                form.submit(); // Submit form setelah 1 detik (anda bisa sesuaikan delaynya)
            }, 1000); // Misalnya, tunggu 1 detik sebelum mengirim
        });
    });
    </script>


</body>

</html>