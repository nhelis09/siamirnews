<?php
//Script ini disimpan dengan nama file sendiri. Misalkan insertAdmin.php
// koneksi database
include '../../assets/konektor.php';

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
include '../../assets/cekinput.php';

// menangkap data yang di kirim dari form

$fariabel2 = input($_POST['nama']);
$fariabel3 = input($_POST['keterangan']);
// menginput data ke database
mysqli_query($konektor, "insert into kategoriberita (nama, keterangan) values('$fariabel2','$fariabel3')");

// mengalihkan halaman kembali ke index.php
header("location: ../kategoriberita.php");
