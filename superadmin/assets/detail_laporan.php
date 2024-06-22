<?php
include '../../assets/konektor.php';
include 'cekdata2.php';
session_start();

if (!isset($_GET['id'])) {
    echo "ID admin tidak ditemukan.";
    exit;
}

$idadmin = $_GET['id'];

// Query to get admin data
$query = "SELECT a.idadmin, a.nama, 
        COUNT(b.idberita) AS jumlah_berita,
        SUM(CASE WHEN b.status = '2' THEN 1 ELSE 0 END) AS jumlah_publis,
        SUM(CASE WHEN b.status = '3' THEN 1 ELSE 0 END) AS jumlah_arsip,
        SUM(CASE WHEN b.status = '1' THEN 1 ELSE 0 END) AS jumlah_draf
        FROM admin a
        LEFT JOIN berita b ON a.idadmin = b.idadmin
        WHERE a.idadmin = '$idadmin'
        GROUP BY a.idadmin, a.nama";
$result = mysqli_query($konektor, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Data admin tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Admin</title>
    <link rel="icon" href="../../assets/logo.png" type="image/x-icon">
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <h1>Detail Laporan Admin</h1>

    <table>
        <tr>
            <th>Nama</th>
            <td><?php echo $data['nama']; ?></td>
        </tr>
        <tr>
            <th>Foto Admin</th>
            <td>
                <?php
                //Display image
                $file = $data['idadmin'];
                if (file_exists("../../fotoadmin/$file.jpg")) {
                ?><img src="../../fotoadmin/<?php echo $data['idadmin']; ?>.jpg" width="80" height="80" /><?php
                                                                                                        } else {
                                                                                                            ?><img
                    src="../../fotoadmin/fotokosong.jpg" width="80"
                    height="80" /><?php
                                                                                                                                                                                    }
                                                                                                                                                                                        ?>
            </td>
        </tr>
        <tr>
            <th>Jumlah Berita</th>
            <td><?php echo $data['jumlah_berita']; ?></td>
        </tr>
        <tr>
            <th>Jumlah Publis</th>
            <td><?php echo $data['jumlah_publis']; ?></td>
        </tr>
        <tr>
            <th>Jumlah Arsip</th>
            <td><?php echo $data['jumlah_arsip']; ?></td>
        </tr>
        <tr>
            <th>Jumlah Draf</th>
            <td><?php echo $data['jumlah_draf']; ?></td>
        </tr>
        <tr>
            <th>Total Berita</th>
            <td><?php echo $data['jumlah_berita']; ?></td>
        </tr>
    </table>

    <br>
    <h2>Daftar Berita</h2>

    <table>
        <thead>
            <tr>
                <th>Nama Berita</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal Publikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to get detailed list of berita
            $berita_query = "SELECT idberita, idkategori, judul, status, tanggalpublikasi 
                             FROM berita 
                             WHERE idadmin = '$idadmin'";
            $berita_result = mysqli_query($konektor, $berita_query);

            if ($berita_result && mysqli_num_rows($berita_result) > 0) {
                while ($berita = mysqli_fetch_assoc($berita_result)) {
            ?>
            <tr>
                <td><?php echo $berita['judul']; ?></td>
                <td><?php echo  namakategori($berita['idkategori']); ?></td>
                <td><?php echo  namastatus($berita['status']); ?></td>
                <td><?php echo $berita['tanggalpublikasi']; ?></td>
            </tr>
            <?php
                }
            } else {
                ?>
            <tr>
                <td colspan="3">Tidak ada berita ditemukan.</td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>