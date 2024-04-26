<?php
include '../assets/konektor.php'; //koneksi ke database
include 'assets/cekdata.php'; ?>


<!-- cek apakah sudah login -->
<!-- Cara 1 Jika halaman login terpisah dengan halaman index -->
<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buana Uyelindo - Admin</title>
    <?php include '../assets/cdn.php'; //mengakses cdn bootstrap 
    ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <style>
    body {
        background-color: black;
    }
    </style>
</head>

<body>

    <div class="container pt-0 shadow p-0 mb-0 bg-dark">
        <img src="../assets/banner.jpg" width="100%" alt="">
        <?php include 'assets/navbar.php'; ?>

        <div class="row p-3">
            <p>
            <h5>Selamat datang, <?php echo namaadmin($_SESSION['username']); ?></h5>
            </p>
            <div class="col-md-4">

                <div class="text-center">
                    <p> Tambah Data Admin Baru</p>
                </div>
                <form action="assets/insertadmin.php" method="POST">
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Kategori</span>
                        <select name="kategori" class="custom-select form-control" required>
                            <option value="1">Admin Input</option>
                            <option value="2">Admin Approve</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Nama</span>
                        <input name="nama" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Email</span>
                        <input name="email" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text text-light">Telepon</span>
                        <input name="telepon" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Jenis Kelamin</span>
                        <select name="jeniskelamin" class="custom-select form-control" required>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Alamat</span>
                        <input name="alamat" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Tempat Lahir</span>
                        <input name="tempatlahir" type="text" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text  text-light">Tanggal Lahir</span>
                        <input name="tanggallahir" type="date" class="form-control" required>
                    </div>

                    <p></p>
                    <input type="hidden" name="status" value="1">
                    <input type="hidden" name="password" value="<?php echo rand(100000, 999999); ?>">
                    <p></p>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table width="100%" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($konektor, "select * from admin");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <?php
                                        //Display image
                                        $file = $d['idadmin'];
                                        if (file_exists("../fotoadmin/$file.jpg")) {
                                        ?>
                                    <a href="../fotoadmin/<?php echo $file; ?>.jpg" target="_blank">
                                        <img src="../fotoadmin/<?php echo $file; ?>.jpg" width="80" height="80" />
                                    </a>
                                    <center>
                                        <small>
                                            <a onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')"
                                                href="assets/hapusgambaradmin.php?idadmin=<?php echo $file; ?>">Hapus</a>
                                        </small>
                                    </center>
                                    <?php
                                        } else {
                                        ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#mymodalimg<?php echo $file; ?>">
                                        <img src="../fotoadmin/fotokosong.jpg" width="80px" height="80px" />
                                    </a>
                                    <?php
                                        }
                                        ?>

                                    <!--  Modal untuk UPLOAD GAMBAR -->
                                    <div class="modal" id="mymodalimg<?php echo $d['idadmin']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <img src="../fotoadmin/fotokosong.jpg" alt="Deskripsi gambar">
                                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="alert alert-info">
                                                        Hanya bisa menerima gambar dalam format <span
                                                            style=" color: red;">jpg </span> dengan ukuran kurang dari
                                                        <span style=" color: red;">1MB</span>
                                                    </div>
                                                    <form action="assets/unggahaksifotoadmin.php" method="post"
                                                        enctype="multipart/form-data">
                                                        <input type="hidden" name="idadmin"
                                                            value="<?php echo $d['idadmin']; ?>">
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
                                <td><?php if ($d['kategori'] == '1') {
                                            echo 'Admin Input';
                                        } else {
                                            echo 'Admin Approve';
                                        } ?></td>
                                <td><?php echo $d['nama']; ?></td>

                                <td><?php echo $d['telepon']; ?></td>
                                <td><?php if ($d['jeniskelamin'] == '1') {
                                            echo 'Laki-laki';
                                        } else {
                                            echo 'Perempuan';
                                        } ?></td>
                                <td><?php echo $d['tempatlahir']; ?></td>
                                <td><?php echo $d['tanggallahir']; ?></td>

                                <td>
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#myModal<?php echo $d['idadmin']; ?>">Ubah</a>
                                    <a href="assets/deleteadmin.php?idadmin=<?php echo $d['idadmin']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data admin ini?')">Hapus</a>
                                </td>

                                </td>
                            </tr>
                            <!-- The Modal -->
                            <div class="modal fade" id="myModal<?php echo $d['idadmin']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ubah Data Admin</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="assets/updateadmin.php" method="POST">
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Kategori</span>
                                                    <select name="kategori" class="custom-select form-control" required>
                                                        <option value="1"
                                                            <?php if ($d['kategori'] == '1') echo 'selected' ?>>Admin
                                                            Input </option>
                                                        <option value="2"
                                                            <?php if ($d['kategori'] == '2') echo 'selected' ?>>Admin
                                                            Approve</option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Nama</span>
                                                    <input value="<?php echo $d['nama']; ?>" name="nama" type="text"
                                                        class="form-control" required>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Email</span>
                                                    <input value="<?php echo $d['email']; ?>" name="email" type="text"
                                                        class="form-control" required>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text text-light">Telepon</span>
                                                    <input value="<?php echo $d['telepon']; ?>" name="telepon"
                                                        type="text" class="form-control" required>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Jenis Kelamin</span>
                                                    <select name="jeniskelamin" class="custom-select form-control"
                                                        required>
                                                        <option value="1"
                                                            <?php if ($d['jeniskelamin'] == '1') echo 'selected' ?>>
                                                            Laki-laki</option>
                                                        <option value="2"
                                                            <?php if ($d['jeniskelamin'] == '2') echo 'selected' ?>>
                                                            Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Alamat</span>
                                                    <input value="<?php echo $d['alamat']; ?>" name="alamat" type="text"
                                                        class="form-control" required>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Tempat Lahir</span>
                                                    <input value="<?php echo $d['tempatlahir']; ?>" name="tempatlahir"
                                                        type="text" class="form-control" required>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text  text-light">Tanggal Lahir</span>
                                                    <input value="<?php echo $d['tanggallahir']; ?>" name="tanggallahir"
                                                        type="date" class="form-control" required>
                                                </div>

                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">Status</span>
                                                    <select name="status" class="custom-select form-control" required>
                                                        <option value="1"
                                                            <?php if ($d['status'] == '1') echo 'selected' ?>>Aktif
                                                        </option>
                                                        <option value="2"
                                                            <?php if ($d['status'] == '0') echo 'selected' ?>>Tidak
                                                            Aktif</option>
                                                    </select>
                                                </div>
                                                <input value="<?php echo $d['idadmin']; ?>" name="idadmin"
                                                    type="hidden">

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <input type="submit" value="Simpan" class="btn btn-success">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </form>
                                        </div>
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
<?php
include '../assets/emstable.php'; //koneksi ke database
?>

</html>