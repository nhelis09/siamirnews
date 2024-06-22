<?php
include '../assets/konektor.php';
session_start();
if ($_SESSION['status'] != "login") {
    header("location:/index.php?pesan=belum_login");
}

// Mengambil data dari form jika ada, jika tidak tampilkan semua berita
$startDate = isset($_POST['start_date']) && !empty($_POST['start_date']) ? $_POST['start_date'] : null;
$endDate = isset($_POST['end_date']) && !empty($_POST['end_date']) ? $_POST['end_date'] : null;
$showAllNews = isset($_POST['show_all_news']) && $_POST['show_all_news'] == 'on';

$query = "SELECT kategoriberita.nama, ";
if ($showAllNews) {
    $query .= "COUNT(berita.idberita) AS total ";
} else {
    $query .= "COUNT(CASE WHEN berita.isi != '' THEN berita.idberita END) AS total ";
}
$query .= "FROM kategoriberita
          LEFT JOIN berita ON berita.idkategori = kategoriberita.idkategori";

if (!$showAllNews) {
    $query .= " WHERE berita.isi != ''";
}

if ($startDate && $endDate) {
    $query .= " AND DATE(berita.tanggal) BETWEEN ? AND ?";
}

$query .= " GROUP BY kategoriberita.nama";

$stmt = mysqli_prepare($konektor, $query);

if ($startDate && $endDate) {
    mysqli_stmt_bind_param($stmt, 'ss', $startDate, $endDate);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$categories = [];
$totals = [];

// Warna tetap untuk setiap kategori
$colors = [
    '#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#A633FF',
    '#33FFF5', '#F5FF33', '#FF8233', '#FF3380', '#80FF33'
];

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['nama'];
    $totals[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buanaya Uyelindo - Beranda</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <?php include 'assets/cekdata.php'; ?>
    <div class="container pt-0 shadow p-0 mb-0 bg-secondary border">
        <!-- <img src="assets/banner.jpg" width="100%" alt="ini bener..." draggable="false"> -->
        <?php include 'assets/banner.php'; ?>

        <?php include 'assets/navbar.php'; ?>
        <div class="row p-3">

            <p>
            <h5>Selamat datang, <?php echo namaadmin($_SESSION['username']); ?></h5>
            </p>

            <hr>
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
                                $data = mysqli_query($konektor, "SELECT * FROM kategoriberita ORDER BY nama ASC");
                                while ($d = mysqli_fetch_array($data)) {
                                    $idkategori = $d['idkategori'];
                                    $data1 = mysqli_query($konektor, "SELECT COUNT(idberita) AS jumlah FROM `berita` WHERE `idkategori` =  $idkategori GROUP BY idkategori;");
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

                    <div class="col-sm-4">
                        <div class="card bg-white text-black">
                            <center>
                                <h2>Grafik Berita</h2>
                            </center>
                            <canvas id="newsChart" class="mt-4"></canvas>

                            <!-- <hr>
                            <center>
                                <h6>Sortir berdasarkan tanggal</h6>
                            </center>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?php echo isset($startDate) ? $startDate : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?php echo isset($endDate) ? $endDate : ''; ?>">
                                </div>
                                <div id="clearDates" style="cursor: pointer;  color: blue;">
                                    Clear Tanggal</div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="show_all_news"
                                        name="show_all_news" <?php echo $showAllNews ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="show_all_news">Tampilkan Semua Berita</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form> -->
                            <!-- 
                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_all_news" name="show_all_news"
                                    <?php echo $showAllNews ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="show_all_news">Tampilkan Semua Berita</label>
                            </div> -->

                            <hr>
                            <center>
                                <h6>Pilih Jenis Diagram</h6>
                            </center>
                            <select id="chartType" class="form-select">
                                <option value="bar">Diagram Batang</option>
                                <option value="pie">Diagram Lingkaran</option>
                                <option value="line">Diagram Garis</option>
                                <option value="radar">Diagram Radar</option>
                                <option value="polarArea">Diagram Polar Area</option>
                                <option value="doughnut">Diagram Donat</option>
                            </select>

                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <p></p>
        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container">

                <br>
                <center>

                    Dibuat oleh: Kornelis Andrian Kabo
                </center>
                <br>
                <center>
                    Akun Sosial Media Saya:
                </center>
                <ul class="list-unstyled d-flex justify-content-center">
                    <li class="me-3"><a href="https://www.facebook.com/andy.apc.54" class="text-decoration-none"
                            target="_blank"><i class="bi bi-facebook fs-3"></i></a></li>
                    <li class="me-3"><a href="https://www.instagram.com/nhellys09_/" class="text-decoration-none"
                            target="_blank"><i class="bi bi-instagram fs-3"></i></a></li>
                    <li class="me-3"><a href="https://x.com/AndyKabo" class="text-decoration-none" target="_blank"><i
                                class="bi bi-twitter fs-3"></i></sm>
                    </li>
                    <li class="me-3"><a href="https://www.youtube.com/@kornelisandriankabo" class="text-decoration-none"
                            target="_blank"><i class="bi bi-youtube fs-3"></i></a></li>
                    <li class="me-3"><a href="https://github.com/nhelis09" class="text-decoration-none"
                            target="_blank"><i class="bi bi-github fs-3"></i></a></li>
                </ul>
            </div>
        </footer>
    </div>

    <script>
    // Mengambil data dari PHP
    const categories = <?php echo json_encode($categories); ?>;
    const totals = <?php echo json_encode($totals); ?>;
    const colors = <?php echo json_encode($colors); ?>;

    // Membuat grafik menggunakan Chart.js
    const ctx = document.getElementById('newsChart').getContext('2d');
    let newsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Total Berita',
                data: totals,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Fungsi untuk mengganti jenis diagram
    document.getElementById('chartType').addEventListener('change', function() {
        const selectedType = this.value;
        newsChart.destroy(); // Menghancurkan grafik sebelumnya
        newsChart = new Chart(ctx, {
            type: selectedType,
            data: {
                labels: categories,
                datasets: [{
                    label: 'Total Berita',
                    data: totals,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    document.getElementById('clearDates').addEventListener('click', function() {
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
    });
    </script>


    <!-- tombol -->
    <script>
    document.getElementById('show_all_news').addEventListener('change', function() {
        const showAllNews = this.checked;

        // Membuat permintaan AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_news_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                updateChart(response.categories, response.totals, response.colors);
            }
        };
        xhr.send('show_all_news=' + (showAllNews ? 'on' : 'off'));
    });

    // Fungsi untuk memperbarui diagram
    function updateChart(categories, totals, colors) {
        newsChart.data.labels = categories;
        newsChart.data.datasets[0].data = totals;
        newsChart.data.datasets[0].backgroundColor = colors;
        newsChart.data.datasets[0].borderColor = colors;
        newsChart.update();
    }
    </script>


</body>

</html>