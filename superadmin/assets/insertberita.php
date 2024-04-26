<?php
//Script ini disimpan dengan nama file sendiri. Misalkan insertAdmin.php
// koneksi database
include '../../assets/konektor.php';

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
include '../../assets/cekinput.php';

// menangkap data yang di kirim dari form
$fariabel1 = input($_POST['idadmin']);
$fariabel2 = input($_POST['idkategori']);
$fariabel3 = input($_POST['judul']);
$fariabel4 = input($_POST['isi']);
$fariabel5 = input($_POST['tanggalpublikasi']);
$fariabel6 = input($_POST['status']);

// menginput data ke database
mysqli_query($konektor, "insert into berita (idadmin,idkategori,judul,isi,tanggalpublikasi,status) values('$fariabel1','$fariabel2','$fariabel3','$fariabel4','$fariabel5','$fariabel6')");

// mengalihkan halaman kembali ke index.php
header("location:../berita.php");
