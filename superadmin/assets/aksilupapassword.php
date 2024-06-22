<?php
include '../../assets/konektor.php'; // Menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Query untuk mengambil password berdasarkan email
        $query = "SELECT password FROM admin WHERE email = ?";
        $stmt = $konektor->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            // Memeriksa apakah email ditemukan di database
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($password);
                $stmt->fetch();

                // Mengirim email dengan password
                $to = $email;
                $subject = "Reset Password";
                $message = "Password anda adalah ini: " . $password;
                $headers = "From: noreply@websiamirnews22110023.com";

                if (mail($to, $subject, $message, $headers)) {
                    echo "Password has been sent to your email.";
                } else {
                    echo "Failed to send email.";
                }
            } else {
                echo "Email not found.";
            }

            $stmt->close();
        } else {
            echo "Failed to prepare statement.";
        }
    } else {
        echo "Invalid email format.";
    }

    $konektor->close();
}
