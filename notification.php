<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification on Path Change</title>
    <script src="notification.js"></script>
    <?php
    include 'assets/cdn.php';
    ?>
</head>
<div class="container bg-secondary">
    <div class="text-center mt-4">
        <h1>404 Not Found</h1>
        <p>Mohon maaf. Halaman yang coba Anda telusuri tidak ditemukan. Silakan cek kembali URL.</p>
        <p>Kembali ke: <a href="https://www.websiamirnews22110023.my.id">websiamirnews22110023.my.id</a></p>
        <p>Kontak Super Admin: 082237487497</p>

        <script>
        window.onload = function() {
            // Menampilkan path awal
            document.getElementById('currentPath').textContent = window.location.pathname;

            // Mendeteksi perubahan path
            window.onpopstate = function(event) {
                alert(
                    'Anda telah mengubah path URL. Harap perhatikan bahwa fitur di luar path asli mungkin tidak berfungsi dengan benar.'
                );
            };
        };
        </script>
    </div>



    <div class="container">
        <div class="login-container">
            <!-- konten login form -->

            <!-- tambahan untuk laporan masalah -->
            <div class="text-center mt-4">
                <p>Laporan Masalah</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#laporanMasalahModal">Laporkan</button>
            </div>
        </div>
    </div>

    <!-- Modal laporan masalah -->
    <div class="modal fade" id="laporanMasalahModal" tabindex="-1" aria-labelledby="laporanMasalahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporanMasalahModalLabel">Perlu Bantuan ? <br>Laporkan Masalah Anda
                        Kepada
                        Kami Sekarang </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="loginuser/laporkanmasalah.php" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Anda</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email anda agar dapat dihubungi" required>
                        </div>
                        <div class="mb-3">
                            <label for="laporanMasalahTextarea" class="form-label">Deskripsi Masalah</label>
                            <textarea class="form-control" id="laporanMasalahTextarea" name="deskripsi_masalah" rows="3"
                                placeholder="Tulis masalah anda" required></textarea>
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
    <p></p>
    <p></p>
</div>
</body>

</html>