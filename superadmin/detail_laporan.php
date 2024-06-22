<?php
include '../assets/konektor.php';

$laporan_id = isset($_GET['laporan_id']) ? $_GET['laporan_id'] : '';

if ($laporan_id) {
    // Query untuk mendapatkan detail laporan berdasarkan ID laporan
    $query = "SELECT a.idadmin, a.nama, 
        COUNT(b.idberita) AS jumlah_berita,
        SUM(CASE WHEN b.status = '2' THEN 1 ELSE 0 END) AS jumlah_publis,
        SUM(CASE WHEN b.status = '3' THEN 1 ELSE 0 END) AS jumlah_arsip,
        SUM(CASE WHEN b.status = '1' THEN 1 ELSE 0 END) AS jumlah_draf
        FROM admin a
        LEFT JOIN berita b ON a.idadmin = b.idadmin
        WHERE a.idadmin = '$laporan_id'
        GROUP BY a.idadmin, a.nama";

    $result = mysqli_query($konektor, $query);
    $data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
</head>

<body>
    <h1>Detail Laporan</h1>
    <?php if ($data) : ?>
        <p><strong>Nama:</strong> <?php echo $data['nama']; ?></p>
        <p><strong>Jumlah Berita:</strong> <?php echo $data['jumlah_berita']; ?></p>
        <p><strong>Publis:</strong> <?php echo $data['jumlah_publis']; ?></p>
        <p><strong>Arsip:</strong> <?php echo $data['jumlah_arsip']; ?></p>
        <p><strong>Draf:</strong> <?php echo $data['jumlah_draf']; ?></p>
    <?php else : ?>
        <p>Data tidak ditemukan.</p>
    <?php endif; ?>
</body>

</html>