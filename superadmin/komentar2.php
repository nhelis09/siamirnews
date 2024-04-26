<?php
include '../assets/konektor.php';

session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:/index.php?pesan=belum_login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - komentar 2</title>
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
                <form action="assets/insertkomentar2.php" method="POST">
                    <p></p>
                    <br>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Komentar</span>
                        <select name="idkomentar1" class="custom-select form-control" required>
                            <?php
                            $data = mysqli_query($konektor, "select * from komentar1 order by idkomentar1 asc");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                                <option value="<?php echo $d['idkomentar1']; ?>"><?php echo $d['isi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">Tanggapan</span>
                        <input name="isi" required type="text" class="form-control" required>
                    </div>

                    <input type="hidden" name="idberita" value="<?php echo $_GET['id']; ?>">

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
                                <th>Komentar</th>
                                <th>Tanggapan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($konektor, "select komentar2.idkomentar2, komentar2.isi as tanggapan, komentar1.isi as komentar from komentar2, komentar1 where komentar1.idkomentar1 = komentar2.idkomentar1 order by komentar2.idkomentar2 desc");
                            while ($d = mysqli_fetch_array($data)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['komentar']; ?></td>
                                    <td><?php echo $d['tanggapan']; ?></td>
                                    <td>
                                        <a href="assets/deletekomentar2.php?q=<?php echo $d['idkomentar2']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data admin ini?')">Hapus</a>
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