<?php
include '../assets/konektor.php';

$showAllNews = isset($_POST['show_all_news']) && $_POST['show_all_news'] == 'on';

$query = "SELECT kategoriberita.nama, COUNT(berita.idberita) AS total FROM kategoriberita LEFT JOIN berita ON berita.idkategori = kategoriberita.idkategori";

if (!$showAllNews) {
    $query .= " WHERE berita.isi != ''";
}

$query .= " GROUP BY kategoriberita.nama";

$data = mysqli_query($konektor, $query);

$categories = [];
$totals = [];
$colors = [];

function random_color()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

while ($row = mysqli_fetch_assoc($data)) {
    $categories[] = $row['nama'];
    $totals[] = $row['total'];
    $colors[] = random_color();
}

echo json_encode(['categories' => $categories, 'totals' => $totals, 'colors' => $colors]);