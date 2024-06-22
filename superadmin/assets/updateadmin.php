<?php
include '../../assets/konektor.php'; //koneksi ke database

// ambil data yang dikirim dari form
$idadmin = $_POST['idadmin'];
$kategori = $_POST['kategori'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$jeniskelamin = $_POST['jeniskelamin'];
$alamat = $_POST['alamat'];
$tempatlahir = $_POST['tempatlahir'];
$tanggallahir = $_POST['tanggallahir'];
$status = $_POST['status'];

// update data admin
$query = "UPDATE admin SET kategori='$kategori', nama='$nama', email='$email', telepon='$telepon', jeniskelamin='$jeniskelamin', alamat='$alamat', tempatlahir='$tempatlahir', tanggallahir='$tanggallahir', status='$status' WHERE idadmin='$idadmin'";

// eksekusi query update
if (mysqli_query($konektor, $query)) {
    // jika berhasil, kembali ke halaman admin.php
    header("location:../admin.php");
} else {
    // jika gagal, tampilkan pesan error
    echo "Error: " . $query . "<br>" . mysqli_error($konektor);
}

mysqli_close($konektor); // tutup koneksi database
