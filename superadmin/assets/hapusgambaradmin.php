<?php
$nama = ($_GET['idadmin']);
$target = "../../fotoadmin/$nama.jpg";
if (file_exists($target)) {
    unlink($target);
}
header('location:../admin.php');
exit();