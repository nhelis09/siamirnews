<?php
session_start();
include '../assets/konektor.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:/index.php?pesan=belum_login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - Kategori Berita</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <style>
    body {
        background-color: black;
    }
    </style>
</head>

<body>
    <?php include 'assets/cekdata.php'; ?>
    <div class="container pt-0 shadow p-0 mb-0 bg-dark">
        <img src="../assets/banner.jpg" width="100%" alt="">
        <?php include 'assets/navbar.php'; ?>
        <div class="row p-3">
            <p>
            <h5>Selamat datang, <?php echo namaadmin($_SESSION['username']); ?></h5>
            </p>
            <div class="col-sm-4 ">
                <div class="text-center">
                    <p> Tambah Kategori Berita Baru</p>
                </div>
                <form action="assets/insertkategoriberita.php" method="POST">

                    <div class="input-group mb-3">
                        <span class="input-group-text">Nama</span>
                        <input placeholder="Nama kategori berita" name="nama" type="text" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Keterangan</span>
                        <input name="keterangan" type="text" class="form-control" required>
                    </div>

                    <p></p>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
            </div>
            <div class="col-sm-8">
                <div class="table-responsive">
                    <table width="100%" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($konektor, "SELECT * FROM kategoriberita order by idkategori desc");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['nama']; ?></td>
                                <td><?php echo $d['keterangan']; ?></td>
                                <td>
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#myModal<?php echo $d['idkategori']; ?>">Ubah</a>
                                    <a href="assets/deletekategoriberita.php?idkategori=<?php echo $d['idkategori']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data admin ini?')">Hapus</a>
                                </td>
                            </tr>

                            <!-- The Modal -->
                            <div class="modal" id="myModal<?php echo $d['idkategori']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ubah Kategori</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <form action="assets/updatekategoriberita.php" method="POST">
                                            <div class="modal-body">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Nama</span>
                                                    <input name="nama" value="<?php echo $d['nama']; ?>" type="text"
                                                        class="form-control">
                                                </div>

                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Keterangan</span>
                                                    <input name="keterangan" value="<?php echo $d['keterangan']; ?>"
                                                        type="text" class="form-control">
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <input name="idkategori" value="<?php echo $d['idkategori']; ?>"
                                                    type="hidden">
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
                </div>
            </div>
        </div>
    </div>
</body>
<?php include '../assets/emstable.php'; ?>

</html>