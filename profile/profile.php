<?php
include '../assets/konektor.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("location:../loginuser/login.php?pesan=belum_login");
    exit();
}

// Ubah Nama File Avatar Menjadi ID Pengguna:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $user_id = $_SESSION['user_id'];
    $avatar_ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png'];
    $max_file_size = 1048576; // 1 MB dalam bytes

    if ($_FILES['avatar']['size'] > $max_file_size) {
        $error_message = "Ukuran file terlalu besar. Maksimum 1 MB yang diperbolehkan.";
    } elseif (in_array($avatar_ext, $allowed_exts)) {
        // Hapus avatar lama jika ada
        $target_dir = "uploads/avatars/";
        foreach ($allowed_exts as $ext) {
            $old_avatar = $target_dir . $user_id . '.' . $ext;
            if (file_exists($old_avatar)) {
                unlink($old_avatar);
            }
        }

        $avatar = $user_id . '.' . $avatar_ext;
        $target_file = $target_dir . $avatar;

        // Simpan avatar yang diunggah
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            $query = "UPDATE users SET avatar='$avatar' WHERE idusers='$user_id'";
            mysqli_query($konektor, $query);
            $_SESSION['avatar'] = $avatar;
            header("Location: profile.php"); // Reload halaman untuk merefleksikan avatar baru
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        $error_message = "Format file tidak diperbolehkan. Harap unggah file dengan format jpg, jpeg, atau png.";
    }
}

// Ambil detail pengguna saat ini
$user_id = $_SESSION['user_id'];
$query = mysqli_query($konektor, "SELECT * FROM users WHERE idusers = $user_id");
$user = mysqli_fetch_assoc($query);
?>

<?php
// Menghapus cache browser
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <?php include '../assets/cdn.php'; // mengakses cdn bootstrap 
    ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <style>
    #profileContainer {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #profileImage {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        font-size: 35px;
        color: #fff;
        text-align: center;
        line-height: 150px;
        margin: 20px 0;
        cursor: pointer;
    }

    #profileImage img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }

    .edit-icon,
    .delete-icon {
        position: absolute;
        top: 0;
        width: 40px;
        height: 40px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .edit-icon {
        right: 0;
    }

    .delete-icon {
        left: 0;
    }

    #profileImage:hover .edit-icon,
    #profileImage:hover .delete-icon {
        opacity: 1;
    }

    #profileDetails {
        margin-top: 20px;
    }
    </style>
    <script>
    function triggerUpload() {
        document.getElementById('avatarInput').click();
    }

    function deleteAvatar(event) {
        event.stopPropagation(); // Mencegah eksekusi event triggerUpload
        if (confirm('Anda yakin ingin menghapus foto profile ini?')) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_avatar.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload halaman setelah menghapus avatar
                    window.location.reload();
                }
            };
            xhr.send();
        }
    }
    </script>
</head>

<body>
    <div class="container pt-0 shadow p-0 mb-0 bg-secondary">
        <?php include 'banner.php'; ?>
        <?php include 'navbar.php'; ?>
        <hr>
        <br>

        <center>
            <!-- Pesan kesalahan unggah avatar -->
            <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger mt-3"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </center>

        <div class="row">
            <div id="profileContainer" class="container">
                <div class="card">
                    <div class="card-body d-flex">
                        <div id="profileImageContainer" class="me-3">
                            <form id="avatarForm" action="profile.php" method="post" enctype="multipart/form-data">
                                <input type="file" id="avatarInput" name="avatar" style="display: none;"
                                    onchange="document.getElementById('avatarForm').submit();">
                                <div id="profileImage" onclick="triggerUpload()">
                                    <?php
                                    $avatar_found = false;
                                    $extensions = ['jpg', 'jpeg', 'png'];
                                    foreach ($extensions as $ext) {
                                        $avatar_path = "uploads/avatars/{$user['idusers']}.$ext";
                                        if (file_exists($avatar_path)) {
                                            $avatar_found = true;
                                            $avatar_url = $avatar_path . '?v=' . filemtime($avatar_path); // Tambahkan timestamp terbaru
                                            echo "<img src='$avatar_url' alt='Avatar'>";
                                            break;
                                        }
                                    }
                                    if (!$avatar_found) {
                                        echo "<img src='uploads/avatars/avatarkosong.jpg' alt='Default Avatar'>";
                                    }
                                    ?>
                                    <div class="edit-icon" onclick="triggerUpload()">&#9998;</div>
                                    <?php if ($avatar_found) : ?>
                                    <div class="delete-icon" onclick="deleteAvatar(event)">&#10006;</div>
                                    <?php endif; ?>
                                </div>
                            </form>

                        </div>
                        <div id="profileDetails" class="flex-grow-1">
                            <h4>
                                <p> <?php echo htmlspecialchars($user['nama'], ENT_QUOTES, 'UTF-8'); ?><a href="#"
                                        onclick="editData('nama')"> <i class="bi bi-pencil"></i></a></p>
                            </h4>
                            <ul>
                                <li>
                                    Email: <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?><a
                                        href="#" onclick="editData('email')"> <i class="bi bi-pencil"></i></a>
                                </li>
                                <li>
                                    Password: <?php echo htmlspecialchars($user['password'], ENT_QUOTES, 'UTF-8'); ?><a
                                        href="#" onclick="editData('password')"> <i class="bi bi-pencil"></i></a>
                                </li>
                                <li>
                                    <i>Bergabung pada: <?php echo date('d-m-Y', strtotime($user['created_at'])); ?></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p></p>
        <p></p>
        <br>
        <p></p>
        <hr>
    </div>
</body>

</html>

<?php
$konektor->close();
?>

<script>
function editData(field) {
    var newValue = prompt("Masukkan nilai baru untuk " + field + ":");
    if (newValue !== null) {
        if (newValue.trim() !== "") {
            var formData = new FormData();
            formData.append('field', field);
            formData.append('value', newValue);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_profile.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload halaman setelah pembaruan data
                    window.location.reload();
                }
            };
            xhr.send(formData);
        } else {
            alert("Tidak boleh kosong.");
        }
    }
}
</script>