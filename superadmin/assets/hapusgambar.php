<?php
$nama = ($_GET['idberita']);
$target = "../../fotoberita/$nama.jpg";
if (file_exists($target)) {
    unlink($target);
}
header('location:../berita.php');
exit();
