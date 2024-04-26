<?php
include '../assets/konektor.php';

session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - komentar 1</title>
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
            <div class="col-sm-4">
                <form action="assets/insertkomentar1.php" method="POST">
                    <p></p>
                    <br>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Berita</span>
                        <select name="idberita" class="custom-select form-control" required>
                            <option value=""></option>
                            <?php
                            $data = mysqli_query($konektor, "select * from berita order by judul asc");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                                <option value="<?php echo $d['idberita']; ?>"><?php echo $d['judul']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">Isi</span>
                        <input name="isi" required type="text" class="form-control">
                    </div>
                    <p></p>
                    <input type="submit" class="btn btn-success" value="Simpan">
                </form>
            </div>
            <div class="col-sm-8">
                <br>
                <div class="table-responsive">
                    <table width="100%" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Berita</th>
                                <th>Komentar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($konektor, "select komentar1.idkomentar1, komentar1.idberita, komentar1.isi, berita.judul from komentar1, berita where komentar1.idberita = berita.idberita order by komentar1.idkomentar1 desc");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['judul']; ?></td>
                                    <td><?php echo $d['isi']; ?></td>
                                    <td>
                                        <a href="assets/deletekomentar1.php?q=<?php echo $d['idkomentar1']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data admin ini?')">Hapus</a>
                                    </td>
                                </tr>
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