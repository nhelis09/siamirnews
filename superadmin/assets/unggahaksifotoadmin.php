<?php
$temp = $_FILES['berkas']['tmp_name'];
$name = $_FILES['berkas']['name']; //mengambil nama file asli
$id =   $_POST['idadmin'] . '.jpg'; //mengambil nama file dari url parameter
$size = $_FILES['berkas']['size']; //mengambil ukuran file
$type = $_FILES['berkas']['type']; //mengambil tipe file
$folder = "../../fotoadmin/"; //Folder untuk menampung berkas. Pastikan Anda telah membuatnya
// upload Process
//1 Megabyte = 1000000
if ($size <= 1000000 and $type == 'image/jpeg') {   //Melakukan validasi tipe file dan ukuran file 5 MB
    move_uploaded_file($temp, $folder . $id); //Jika menggunakan nama file berdasarkan url parameter silakan ganti $name dengan $id
    // mengalihkan halaman kembali ke unggah.php atau sesui yang diinginkan
    header("location:../admin.php?pesan=fileterkirim&name=$name&size=$size&type=$type");
} else {
    header("location:../admin.php?pesan=filegagalterkirim&name=$name&size=$size&type=$type");
}
//Catatan: Jika Anda mengunggah file baru dengan nama yang sama dengan file lama maka file yang lama akan dihapus otomatis
//dan digantikan dengan file baru