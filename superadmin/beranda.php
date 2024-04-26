<?php include '../assets/konektor.php';
?>
<!-- cek apakah sudah login -->
<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:/index.php?pesan=belum_login");
}
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - Beranda</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
</head>

<body>
    <?php include 'assets/cekdata.php'; ?>
    <div class="container pt-0 shadow p-0 mb-0 bg-secondary">
        <img src="../assets/banner.jpg" width="100%" alt="">
        <?php include 'assets/navbar.php'; ?>
        <div class="row p-3">
            <p>
            <h5>Selamat datang, <?php echo namaadmin($_SESSION['username']); ?></h5>
            </p>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card bg-warning text-black">
                            <div class="card-body"><strong> Status Berita</strong>
                                <ul>
                                    <?php
                                    $data = mysqli_query($konektor, "SELECT status, CASE WHEN status = 1 THEN 'Draf' WHEN status = 2 THEN 'Publikasi' WHEN status = 3 THEN 'Arsip' END AS NilaiStatus, COUNT(idberita) AS jumlah FROM `berita` WHERE status IN (1, 2, 3) GROUP BY status;");
                                    while ($d = mysqli_fetch_array($data)) {
                                        echo '<li>' . $d['NilaiStatus'] . ' <span class="badge bg-success">' . $d['jumlah'] . '</span></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card bg-info text-black">
                            <div class="card-body"><strong>Kategori Berita</strong>
                                <?php
                                $data = mysqli_query($konektor, "select * from kategoriberita order by nama asc");
                                while ($d = mysqli_fetch_array($data)) {
                                    $idkategori = $d['idkategori'];
                                    $data1 = mysqli_query($konektor, "SELECT count(idberita) as jumlah FROM `berita` WHERE `idkategori` =  $idkategori group by idkategori;");
                                    $jumlah_berita = 0;
                                    if (mysqli_num_rows($data1) > 0) {
                                        while ($d1 = mysqli_fetch_array($data1)) {
                                            $jumlah_berita = $d1['jumlah'];
                                        }
                                    }
                                    echo '<li>' . $d['nama'] . ' <span class="badge bg-success">' . $jumlah_berita . '</span></li>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>