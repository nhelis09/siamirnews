<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SimairNews</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        font-family: 'Arial', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .login-container p {
        color: #666;
        margin-bottom: 20px;
    }

    .alert {
        margin-bottom: 20px;
        color: #d9534f;
    }

    .form-label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .position-relative {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
    }

    .btn {
        display: inline-block;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #ff7e5f;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #feb47b;
    }

    a {
        color: #ff7e5f;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 500px) {
        .login-container {
            padding: 15px;
        }
    }

    .login-container img {
        width: 50px;
        height: auto;
        /* Maintain aspect ratio */
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <center>
        <div class="container">
            <div class="login-container">
                <h2>Login</h2>
                <?php if (isset($_GET['error'])) { ?>
                <?php if ($_GET['error'] == 'email_password_incorrect') { ?>
                <div class="alert alert-danger" role="alert">
                    Email atau password anda salah. Silakan coba lagi.
                </div>
                <?php } elseif ($_GET['error'] == 'email_not_registered') { ?>
                <div class="alert alert-danger" role="alert">
                    Email belum terdaftar. Silakan lakukan pendaftaran akun terlebih dahulu.
                </div>
                <?php } ?>
                <?php } ?>
                <img src="key.png" alt="gambar login" draggable="false">
                <form action="aksilogin1.php" method="POST">
                    <div class="mb-3 position-relative">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <div>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
                <p class="mt-3">Belum punya akun? <a href="registerakun1.php">Daftar disini</a></p>
                <p class="mt-3">Tidak mau login? <a href="../index.php">Baca Berita Saja Disini</a></p>

                <div class="text-center mt-4">
                    <p>Laporan Masalah</p>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#laporanMasalahModal">Laporkan</button>
                </div>
            </div>

            <!-- Modal laporan masalah -->
            <div class="modal fade" id="laporanMasalahModal" tabindex="-1" aria-labelledby="laporanMasalahModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="laporanMasalahModalLabel">Perlu Bantuan? <br>Laporkan
                                Masalah Anda Kepada Kami Sekarang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="laporkanmasalah.php" method="POST">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="emailMasalah" class="form-label">Email Anda</label>
                                    <input type="email" class="form-control" id="emailMasalah" name="email"
                                        placeholder="Masukkan email anda agar dapat dihubungi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="laporanMasalahTextarea" class="form-label">Deskripsi Masalah</label>
                                    <textarea class="form-control" id="laporanMasalahTextarea" name="deskripsi_masalah"
                                        rows="3" placeholder="Tulis masalah anda" required></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary">Kirim</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>