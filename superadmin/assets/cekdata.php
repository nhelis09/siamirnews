<?php
function namaadmin($email)
{
    include '../assets/konektor.php';
    //Mencari data di dalam database sesuai dengan inputan yang dimasukan
    $data = mysqli_query($konektor, "select * from admin where email like '$email'");
    if (mysqli_num_rows($data) > 0) {
        while ($d = mysqli_fetch_array($data)) {
            $hasil = $d['nama'];
        }
    }
    return $hasil;
}

function namauser($idusers)
{
    include 'assets/konektor.php';
    //Mencari data di dalam database sesuai dengan inputan yang dimasukan
    $data = mysqli_query($konektor, "select * from users where idusers like '$idusers'");
    if (mysqli_num_rows($data) > 0) {
        while ($d = mysqli_fetch_array($data)) {
            $hasil = $d['nama'];
        }
    }
    return $hasil;
}



function namaadmintabel($idadmin)
{
    include '../assets/konektor.php';
    //Mencari data di dalam database sesuai dengan inputan yang dimasukan
    $data = mysqli_query($konektor, "select * from admin where idadmin like '$idadmin'");
    $hasil = null; //inisialisasi nilai $hasil
    if (mysqli_num_rows($data) > 0) {
        while ($d = mysqli_fetch_array($data)) {
            $hasil = $d['nama'];
        }
    }
    return $hasil;
}

function namakategori($idkategori)
{
    include '../assets/konektor.php';
    //Mencari data di dalam database sesuai dengan inputan yang dimasukan
    $data = mysqli_query($konektor, "select * from kategoriberita where idkategori like '$idkategori'");
    if (mysqli_num_rows($data) > 0) {
        while ($d = mysqli_fetch_array($data)) {
            $hasil = $d['nama'];
        }
    }
    return $hasil;
}

function namastatus($status)
{
    switch ($status) {
        case "1":
            echo "Draft";
            break;
        case "2":
            echo "Publikasi";
            break;
        default:
            echo "Arsip";
    }
}

function keteranganpublikasi($tanggal)
{
    if ($tanggal == '') {
        $hasil = '-';
    } else {
        $hasil = date("d F Y", strtotime($tanggal));
    }
    return $hasil;
}

function logdate($tanggal)
{
    echo date(" d F Y", strtotime($tanggal));
}