<?php
include '../assets/konektor.php';

session_start();
if ($_SESSION['status'] != "login") {
    header("location:/index.php?pesan=belum_login");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - Berita</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
</head>

<?php
//Mencari idamin yang sedang login
$email = $_SESSION['username'];
$data = mysqli_query($konektor, "select * from admin where email like '$email'");
if (mysqli_num_rows($data) > 0) {
    while ($d = mysqli_fetch_array($data)) {
        $idadmin = $d['idadmin'];
    }
}
?>

<body>

    <?php include 'assets/cekdata.php'; ?>
    <div class="container pt-0 shadow p-0 mb-0 bg-dark">
        <img src="../assets/banner.jpg" width="100%" alt="">
        <?php include 'assets/navbar.php'; ?>
        <div class="row p-3">
            <p>
            <h5>Selamat datang, <?php echo namaadmin($_SESSION['username']); ?>! </h5>
            </p>
            <div class="col-sm-4">
                <div class="text-center">
                    <p>Tambah Berita Baru</p>
                </div>
                <form action="assets/insertberita.php" method="POST">
                    <div class="input-group mb-2">
                        <span class="input-group-text">Kategori</span>
                        <select name="idkategori" class="custom-select form-control" required>
                            <?php
                            $data = mysqli_query($konektor, "select * from kategoriberita order by nama asc");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                            z<option value="<?php echo $d['idkategori']; ?>"><?php echo $d['nama']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Judul</span>
                        <input name="judul" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Isi</span>
                        <input name="isi" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Publikasi</span>
                        <input name="tanggalpublikasi" type="date" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Status</span>
                        <select name="status" class="form-control" required>
                            <option option value="1">Draft</option>
                            <option option value="2">Publikasi</option>
                            <option option value="3">Arsip</option>
                        </select>
                    </div>
                    <p></p>
                    <input type="hidden" name="idadmin" value="<?php echo $idadmin; ?>">
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
            </div>
            <div class="col-sm-8">
                <table width="100%" class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th>Admin</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Publikasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $data = mysqli_query($konektor, "select * from berita order by idberita desc ");
                        while ($d = mysqli_fetch_array($data)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <?php
                                    //Display image
                                    $file = $d['idberita'];
                                    if (file_exists("../fotoberita/$file.jpg")) {
                                    ?><a target="_blank" href="../fotoberita/<?php echo $d['idberita']; ?>.jpg"><img
                                        src="../fotoberita/<?php echo $d['idberita']; ?>.jpg" width="80"
                                        height="80" /></a>
                                <center><small><a
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')"
                                            href="assets/hapusgambar.php?idberita=<?php echo $d['idberita']; ?>">Hapus</a></small>
                                </center>
                                <?php
                                    } else { ?>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#mymodalimg<?php echo $d['idberita']; ?>"> <img
                                        src="../fotoberita/fotokosong.jpg" width="80px" height="80px" /></a>
                                <?php
                                    }
                                    ?>
                                <!--  Modal untuk UPLOAD GAMBAR -->
                                <div class="modal" id="mymodalimg<?php echo $d['idberita']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <img src="../fotoberita/fotokosong.jpg" alt="Deskripsi gambar">
                                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    Hanya bisa menerima gambar dalam format <span
                                                        style=" color: red;">jpg </span> dengan ukuran kurang dari <span
                                                        style=" color: red;">1MB</span></div>
                                                <form action="assets/unggahaksi.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="idberita"
                                                        value="<?php echo $d['idberita']; ?>">
                                                    <!-- Untuk penamaan file -->
                                                    <input type="file" class="form-control" name="berkas"><br>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button class="btn btn-info" type="submit">Unggah</button>
                                                </form>
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                            <!--  BAGAIAN AKHIR UPLOAD GAMBAR -->
                            </td>
                            <td><?php echo $d['tanggal']; ?></td>
                            <td><?php echo namaadmintabel($d['idadmin']); ?></td>
                            <td><?php echo namakategori($d['idkategori']); ?></td>
                            <td><?php echo $d['judul']; ?></td>
                            <td><?php echo logdate($d['tanggalpublikasi']); ?></td>
                            <td><?php echo namastatus($d['status']); ?></td>
                            <td>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#myModal<?php echo $d['idberita']; ?>">Ubah</a>
                                <a href="assets/deleteberita.php?idberita=<?php echo $d['idberita']; ?>"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Hapus</a>

                            </td>
                        </tr>

                        <!-- Modal Untuk UBAH BERITA -->
                        <div class="modal" id="myModal<?php echo $d['idberita']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Ubah Berita</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="assets/updateberita.php" method="POST">
                                            <input type="hidden" name="idberita" value="<?php echo $d['idberita']; ?>">

                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Kategori</span>
                                                <select name="idkategori" class="custom-select form-control" required>
                                                    <?php
                                                        $kategori = $d['idkategori'];
                                                        $data_kategori = mysqli_query($konektor, "SELECT * FROM kategoriberita ORDER BY nama ASC");
                                                        while ($k = mysqli_fetch_array($data_kategori)) {
                                                            $selected = ($kategori == $k['idkategori']) ? 'selected' : '';
                                                            echo "<option value='{$k['idkategori']}' $selected>{$k['nama']}</option>";
                                                        }
                                                        ?>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Judul</span>
                                                <input type="text" name="judul" class="form-control"
                                                    value="<?php echo $d['judul']; ?>" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Isi</span>
                                                <input type="text" name="isi" class="form-control"
                                                    value="<?php echo $d['isi']; ?>" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Publikasi</span>
                                                <input type="date" name="tanggalpublikasi" class="form-control"
                                                    value="<?php echo $d['tanggalpublikasi']; ?>" required>
                                            </div>
                                            <!-- MULAI LOGIKA JIKA TIDAK ADA FOTO OPTION PUBLIKASI TIDAK AKAN MUNCUL -->
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Status</span>
                                                <select name="status" class="custom-select form-control" required>
                                                    <?php
                                                        $status = $d['status'];
                                                        $status_options = [
                                                            ['value' => 1, 'label' => 'Draft'],
                                                            ['value' => 3, 'label' => 'Arsip']
                                                        ];
                                                        if (file_exists("../fotoberita/{$d['idberita']}.jpg")) {
                                                            $status_options[] = ['value' => 2, 'label' => 'Publikasi'];
                                                        }
                                                        foreach ($status_options as $option) {
                                                            $selected = ($status == $option['value']) ? 'selected' : '';
                                                            echo "<option value='{$option['value']}' $selected>{$option['label']}</option>";
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success" value="Simpan">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                    </tbody>
                </table>
                <hr>
                <!-- cetak laporan -->
                <form action="assets/lapberitaperiode.php" target="_blank" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Periode</span>
                        <input name="mulai" type="date" class="form-control" required>
                        <input name="selesai" type="date" class="form-control" required>
                        <select name="format" class="form-control" required>
                            <option value="pdf">PDF</option>
                            <option value="xls">Excel</option>
                        </select>
                        <input class="btn btn-success" type="submit" value="cetak">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<?php
include '../assets/emstable.php'; //koneksi ke database
?>

</html>