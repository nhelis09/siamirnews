<?php
include '../../assets/konektor.php';
include '../../assets/cekinput.php';

// Sanitize the input
$idadmin = mysqli_real_escape_string($konektor, $_GET['idadmin']);

$query = "DELETE FROM admin WHERE idadmin='$idadmin'";
$result = mysqli_query($konektor, $query);
$nama = ($_GET['idadmin']);
$target = "../assets/fotoadmin/$nama.jpg";
if (file_exists($target)) {
    unlink($target);
}
if ($result) {
    header("location:../admin.php");
}