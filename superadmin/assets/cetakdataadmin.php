<?php
include '../../assets/konektor.php';
include 'cekdata2.php';
session_start();
if ($_SESSION['status'] != "login") {
    header("location:/../index.php?pesan=belum_login");
}
?>

<?php
$format = isset($_POST['format']) ? $_POST['format'] : '';
include '../../assets/konektor.php';

if ($format == 'xls') {
    // Generate Excel file
    header("Content-Type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Data_Admin.xls");

    // Output Excel data
    echo "No\tNama\tJumlah Berita\tPublis\tArsip\tDraf\n";

    $no = 1;
    $data = mysqli_query($konektor, "SELECT a.idadmin, a.nama, 
        COUNT(b.idberita) AS jumlah_berita,
        SUM(CASE WHEN b.status = '2' THEN 1 ELSE 0 END) AS jumlah_publis,
        SUM(CASE WHEN b.status = '3' THEN 1 ELSE 0 END) AS jumlah_arsip,
        SUM(CASE WHEN b.status = '1' THEN 1 ELSE 0 END) AS jumlah_draf
        FROM admin a
        LEFT JOIN berita b ON a.idadmin = b.idadmin
        GROUP BY a.idadmin, a.nama");

    while ($d = mysqli_fetch_array($data)) {
        echo $no++ . "\t" . $d['nama'] . "\t" . $d['jumlah_berita'] . "\t" . $d['jumlah_publis'] . "\t" . $d['jumlah_arsip'] . "\t" . $d['jumlah_draf'] . "\n";
    }
    exit;
} elseif ($format == 'pdf') {
    // Generate PDF file
    $nama_dokumen = 'Laporan_Data_Admin';

    include("../../assets/mpdf60/mpdf.php");
    include "../../phpqrcode/qrlib.php"; // Include library phpqrcode

    $mpdf = new mPDF("en-GB-x", "Letter-L", "", "", 10, 10, 10, 10, 6, 3);
    $mpdf->SetHeader('');
    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Data Admin</title>
        <link rel="icon" href="../../assets/logo.png" type="image/x-icon">
    </head>

    <body>
        <strong>Laporan Data Admin</strong>

        <table border="1" style="border-collapse: collapse;" width="100%">
            <thead>
                <tr>
                    <th><small>No</small></th>
                    <th><small>Gambar</small></th>
                    <th><small>Nama</small></th>
                    <th><small>Jumlah Berita</small></th>
                    <th><small>Publis</small></th>
                    <th><small>Arsip</small></th>
                    <th><small>Draf</small></th>
                    <th><small>Tanda Tangan Admin</small></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Query to get admin data
                $data = mysqli_query($konektor, "SELECT a.idadmin, a.nama, 
        COUNT(b.idberita) AS jumlah_berita,
        SUM(CASE WHEN b.status = '2' THEN 1 ELSE 0 END) AS jumlah_publis,
        SUM(CASE WHEN b.status = '3' THEN 1 ELSE 0 END) AS jumlah_arsip,
        SUM(CASE WHEN b.status = '1' THEN 1 ELSE 0 END) AS jumlah_draf
        FROM admin a
        LEFT JOIN berita b ON a.idadmin = b.idadmin
        GROUP BY a.idadmin, a.nama");

                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <tr>
                        <td><small><?php echo $no++; ?></small></td>
                        <td>
                            <?php
                            //Display image
                            $file = $d['idadmin'];
                            if (file_exists("../../fotoadmin/$file.jpg")) {
                            ?><img src="../../fotoadmin/<?php echo $d['idadmin']; ?>.jpg" width="80" height="80" />
                            <?php
                            } else { ?>
                                <img src="../../fotoadmin/fotokosong.jpg" width="80" height="80" />
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $d['nama']; ?></td>
                        <td><?php echo $d['jumlah_berita']; ?></td>
                        <td><?php echo $d['jumlah_publis']; ?></td>
                        <td><?php echo $d['jumlah_arsip']; ?></td>
                        <td><?php echo $d['jumlah_draf']; ?></td>
                    </tr>
                    <?php
                    // Generate QR Code once and display it
                    $penyimpanan = "../../qrcodes/";
                    if (!file_exists($penyimpanan)) {
                        mkdir($penyimpanan);
                    }

                    // Generate unique URL with idadmin
                    $isi = "https://websiamirnews22110023.my.id/superadmin/assets/detail_laporan.php?id=" . $d['idadmin']; // Append idadmin to URL
                    $filename = $penyimpanan . "qrcode_" . $d['idadmin'] . ".png";
                    QRcode::png($isi, $filename);

                    // Menampilkan qrcode 
                    echo '<td><img src="' . $filename . '" width="100" height="100"></td>'; // Tampilkan QR Code
                    ?>
                <?php } ?>
            </tbody>
        </table>


        <br>
        <?php
        date_default_timezone_set('Asia/Makassar');
        echo "Dicetak oleh: " . namaadmin($_SESSION['username']) . " pada tanggal " . ucwords(strtolower(date('j F Y'))) . " Jam: " . date('H:i:s');
        ?>
        <br>
    </body>

    </html>
<?php
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output($nama_dokumen . ".pdf", 'I'); // Output the PDF to the browser
    exit;
}
?>