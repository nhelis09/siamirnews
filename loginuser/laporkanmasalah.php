<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $emailUser = $_POST["email"];
    $deskripsiMasalah = $_POST["deskripsi_masalah"];

    // Validasi alamat email
    if (!filter_var($emailUser, FILTER_VALIDATE_EMAIL)) {
        echo "Email tidak valid";
    } else {
        $emailAdmin = "andyapc09@gmail.com"; // Ganti dengan alamat email admin

        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'mail.websiamirnews22110023.my.id'; // Ganti dengan alamat SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@websiamirnews22110023.my.id'; // Ganti dengan email pengirim
            $mail->Password = '005LzdBUJ'; // Ganti dengan password email pengirim
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set pengirim dan penerima
            $mail->setFrom($emailUser, $nama); // Gunakan alamat email pengguna sebagai pengirim
            $mail->addAddress($emailAdmin); // Tambahkan alamat email admin sebagai penerima
            $mail->addReplyTo($emailUser, $nama); // Tambahkan alamat email pengguna sebagai balasan

            // Set subjek dan isi email
            $mail->isHTML(false);
            $mail->Subject = 'Laporan Masalah';
            $mail->Body = "Hallo admin,\n\nSaya atas nama $nama, email $emailUser ingin melaporkan masalah saya tentang:\n\n$deskripsiMasalah\n\nMohon segera ditindaklanjuti.";

            $mail->send();
            echo 'Email telah terkirim';
        } catch (Exception $e) {
            echo "Email gagal dikirim: {$mail->ErrorInfo}";
        }
    }
}