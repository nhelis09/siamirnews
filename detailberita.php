<?php
include 'assets/konektor.php'; //koneksi ke database

// Mengambil id berita dari parameter URL
$id = $_GET['id'];

// Mengambil data berita berdasarkan id
$data = mysqli_query($konektor, "SELECT * FROM berita WHERE idberita = $id");
$d = mysqli_fetch_array($data);
$judulBerita = $d['judul'];
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buana Uyelindo <?php echo $d['judul']; ?></title>
    <?php include 'assets/cdn.php'; //mengakses cdn bootstrap 
    ?>
</head>

<body>
    <div class="container pt-0 shadow p-0 mb-0 bg-dark border">
        <!-- <img src="assets/banner.jpg" width="100%" alt="ini bener..." draggable="false"> -->
        <?php include 'assets/banner.php'; ?>
        <?php include 'assets/navbar.php'; ?>

        <br>
        <div class="sm-9">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-3 border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="fotoberita/<?php echo $d['idberita']; ?>.jpg" class="img-fluid rounded-start"
                                    alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $d['judul']; ?></h5>
                                    <hr>
                                    <p class="card-text"><small class="text-muted">Diterbitkan pada
                                            <?php echo date("d F Y H:i", strtotime($d['tanggal'])); ?></small></p>
                                    <p class="card-text"><?php echo $d['isi']; ?></p>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-2"><a href="index.php" class="btn btn-primary"> Kembali</a>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- BAGIAN BAGIKAN BERITA KE MEDIA SOSIAL -->
                                            <?php
                                            // Link berita yang akan dibagikan
                                            $beritaLink = " SiamirNews:$judulBerita. Selengkapnya: http://www.websiamirnews22110023.my.id/detailberita.php?id=$id";

                                            // Fungsi untuk menghasilkan tautan berbagi ke WhatsApp
                                            function shareToWhatsApp($link)
                                            {
                                                return "https://wa.me/?text=" . urlencode($link);
                                            }

                                            // Fungsi untuk menghasilkan tautan berbagi ke Instagram
                                            function shareToInstagram($link)
                                            {
                                                return "https://www.instagram.com/add_to_story?url=" . urlencode($link);
                                            }

                                            // Fungsi untuk menghasilkan tautan berbagi ke Facebook
                                            function shareToFacebook($link)
                                            {
                                                return "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($link);
                                            }
                                            ?>
                                            <!-- BAGIAN AKHIR DARI BAGIKAN BERITA KE MEDIA SOSIAL -->


                                            <!-- Tombol berbagi -->


                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bi bi-share"></i> Bagikan Kemedia Sosial
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="<?php echo shareToWhatsApp($beritaLink); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-whatsapp"></i> WhatsApp</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="<?php echo shareToInstagram($beritaLink); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-instagram"></i> Instagram</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="<?php echo shareToFacebook($beritaLink); ?>"
                                                            target="_blank">
                                                            <i class="bi bi-facebook"></i> Facebook</a></li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- form komentar 1 -->
                                    <hr>
                                    <form action="user/insertkomentar1.php" method="post">
                                        <div class="input-group mb-3">
                                            <input type="text" name="isi" class="form-control" required
                                                placeholder="Tuliskan Komentar anda di sini">
                                            <button class="btn btn-success" type="submit">Kirim</button>
                                        </div>
                                        <input type="hidden" name="idberita" value="<?php echo ($_GET['id']); ?>">
                                    </form>

                                    <?php
                                    $id = $_GET['id'];
                                    $no = 1;
                                    $data_komentar1 = mysqli_query($konektor, "SELECT * FROM komentar1 WHERE idberita = '$id'");
                                    while ($d_komentar1 = mysqli_fetch_array($data_komentar1)) {
                                    ?>
                                    <!-- Mengambil dan menampilkan komentar 1 -->
                                    <div class="alert alert-success">
                                        <strong>Komentar <?php echo $no++; ?>:</strong>
                                        <?php echo $d_komentar1['isi']; ?>

                                        <!-- Tombol untuk membuka form balasan -->
                                        <a class="text-primary"
                                            onclick="toggleReplyForm(<?php echo $d_komentar1['idkomentar1']; ?>)"
                                            style="cursor: pointer;">Balas</a>


                                        <!-- Form balasan -->
                                        <div id="replyForm<?php echo $d_komentar1['idkomentar1']; ?>"
                                            style="display: none;">
                                            <form action="user/insertkomentar2.php" method="post">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="isi" class="form-control" required
                                                        placeholder="Tuliskan Balasan Anda di sini">
                                                    <button class="btn btn-primary" type="submit">Balas</button>
                                                </div>
                                                <input type="hidden" name="idberita" value="<?php echo $_GET['id']; ?>">
                                                <input type="hidden" name="idkomentar1"
                                                    value="<?php echo $d_komentar1['idkomentar1']; ?>">
                                            </form>
                                        </div>

                                        <!-- Menampilkan balasan -->
                                        <?php
                                            $idkomentar1 = $d_komentar1['idkomentar1'];
                                            $data_komentar2 = mysqli_query($konektor, "SELECT * FROM komentar2 WHERE idkomentar1 = '$idkomentar1'");
                                            while ($d_komentar2 = mysqli_fetch_array($data_komentar2)) {
                                            ?>
                                        <div class="alert alert-secondary ml-4">
                                            <strong>Balasan:</strong> <?php echo $d_komentar2['isi']; ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p></p>
        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container">

                <br>
                <center>

                    Dibuat oleh: Kornelis Andrian Kabo
                </center>
                <br>
                <center>
                    Akun Sosial Media Saya:
                </center>
                <ul class="list-unstyled d-flex justify-content-center">
                    <li class="me-3"><a href="https://www.facebook.com/andy.apc.54" class="text-decoration-none"
                            target="_blank"><i class="bi bi-facebook fs-3"></i></a></li>
                    <li class="me-3"><a href="https://www.instagram.com/nhellys09_/" class="text-decoration-none"
                            target="_blank"><i class="bi bi-instagram fs-3"></i></a></li>
                    <li class="me-3"><a href="https://x.com/AndyKabo" class="text-decoration-none" target="_blank"><i
                                class="bi bi-twitter fs-3"></i></sm>
                    </li>
                    <li class="me-3"><a href="https://www.youtube.com/@kornelisandriankabo" class="text-decoration-none"
                            target="_blank"><i class="bi bi-youtube fs-3"></i></a></li>
                    <li class="me-3"><a href="https://github.com/nhelis09" class="text-decoration-none"
                            target="_blank"><i class="bi bi-github fs-3"></i></a></li>
                </ul>
            </div>
        </footer>
    </div>

    <script>
    function toggleReplyForm(commentId) {
        var formId = 'replyForm' + commentId;
        var form = document.getElementById(formId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
    </script>

</body>

</html>