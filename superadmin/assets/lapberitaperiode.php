<?php

include '../../assets/konektor.php';
$mulai = $_POST['mulai'];
$selesai = $_POST['selesai'];
$format = $_POST['format'];
?>


<?php
if ($format == 'xls') {
    header("Content-Type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Data Berita.xls");
} else {
    $nama_dokumen = 'Laporan Data Berita'; //Beri nama file PDF hasil.
    include("../../assets/mpdf60/mpdf.php"); //Lokasi file mpdf.php
    //$mpdf = new mPDF('utf-8', 'A4'); // Membuat sebuah file pdf potrait atau tegak lurus
    $mpdf = new mPDF("en-GB-x", "Letter-L", "", "", 10, 10, 10, 10, 6, 3); // Kertas landscape (mendatar)
    $mpdf->SetHeader('');
    //$mpdf->setFooter('{PAGENO}');// Memberi nomor halaman
    ob_start();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Berita</title>
    <link rel="icon" href="../../assets/logo.png" type="image/x-icon">
</head>

<body>
    <?php include 'cekdata2.php'; ?>
    <strong>DATA BERITA</strong>
    <br>
    PRIODE: <?php echo logdate($mulai); ?> s.d <?php echo logdate($selesai); ?>
    <hr>
    <br>
    <table border="1" style="border-collapse: collapse;" width="100%">
        <thead>
            <tr>

                <th><small>No</small></th>
                <?php if ($format == 'pdf') { ?>
                <th><small>Gambar</small></th>
                <?php } ?>
                <th><small>Tanggal</small></th>
                <th><small>Admin</small></th>
                <th><small>Kategori</small></th>
                <th><small>Judul</small></th>
                <th><small>Publikasi</small></th>
                <th><small>Status</small></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $dr = 0;
            $p = 0;
            $a = 0;
            $t = 0;
            $data = mysqli_query($konektor, "SELECT * FROM berita WHERE DATE(tanggal) BETWEEN '$mulai' AND '$selesai' ORDER BY idberita DESC");
            while ($d = mysqli_fetch_array($data)) {
            ?>
            <tr <?php if ($d['status'] == '1' or $d['status'] == '3') {
                        echo ' style="background-color: yellow;"';
                    } ?>>

                <td><small><?php echo $no++; ?></small></td>
                <?php if ($format == 'pdf') { ?>
                <td><?php
                            //Display image
                            $file = $d['idberita'];
                            if (file_exists("../../fotoberita/$file.jpg")) {
                            ?><img src="../../fotoberita/<?php echo $d['idberita']; ?>.jpg" width="80" height="80" />
                    <?php
                            } else { ?>
                    <img src="../../fotoberita/fotokosong.jpg" width="80" height="80" />
                    <?php
                            }
                            ?>
                </td>
                <?php } ?>
                <td><small><?php echo $d['tanggal']; ?></small></td>
                <td><small><?php echo namaadmintabel($d['idadmin']); ?></small></td>
                <td><small><?php echo namakategori($d['idkategori']); ?></small></td>
                <td><small><?php echo $d['judul']; ?></small></td>
                <td><small><?php echo logdate($d['tanggalpublikasi']); ?></small></td>
                <td><small><?php echo namastatus($d['status']);

                                if ($d['status'] == '1') {
                                    $dr = $dr + 1;
                                }
                                if ($d['status'] == '2') {
                                    $p = $p + 1;
                                }
                                if ($d['status'] == '3') {
                                    $a = $a + 1;
                                }

                                ?></small></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>


    <!-- Melacak tanggal dan waktu -->
    <!-- ('Asia/Jayapura'); // Set zona waktu ke Waktu Indonesia Timur (WIT) -->
    <!-- ('Asia/Jakarta'); // Set zona waktu ke Waktu Indonesia Barat (WIB) -->

    <?php
    date_default_timezone_set('Asia/Makassar'); // Set zona waktu ke Waktu Indonesia Barat (WITA)
    // Tampilkan tanggal dalam format yang diinginkan
    echo "Dicetak Tanggal " . ucwords(strtolower(date('j F Y')));
    // Contoh lain 

    echo " Jam : " . date('H:i:a');
    ?>
    <!--selesai  Melacak tanggal dan waktu -->


</body>

</html>


<?php
if ($format == 'pdf') {

    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output($nama_dokumen . ".pdf", 'I');
    exit;
}
?>