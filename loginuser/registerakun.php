<?php
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun - Forum Diskusi Siamir News</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        font-family: 'Arial', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .register-container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .register-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .register-container p {
        color: #666;
        margin-bottom: 20px;
    }

    .alert {
        margin-bottom: 20px;
        color: #d9534f;
    }

    .form-label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .position-relative {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
    }

    .btn {
        display: inline-block;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #ff7e5f;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #feb47b;
    }

    a {
        color: #ff7e5f;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 500px) {
        .register-container {
            padding: 15px;
        }
    }
    </style>
</head>

<body>
    <center>
        <div class="container">
            <div class="register-container">
                <h2>Daftar Akun</h2>
                <p>Bergabunglah dengan kami untuk mengakses forum diskusi</p>
                <?php if ($error === 'email_terdaftar') { ?>
                <div class="alert alert-danger" role="alert">
                    Email sudah terdaftar. Silakan gunakan email lain.
                </div>
                <?php } ?>
                <form action="aksiregister.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <div>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <!-- <i class="fas fa-eye toggle-password"></i> -->
                        </div>
                    </div>
                    <button type="submit" class="btn">Daftar</button>
                </form>
                <p class="mt-3">Sudah punya akun? <a href="login.php">Login Sekarang</a></p>
                <p class="mt-3">Tidak mau login? <a href="../index.php">Baca Berita Saja Disini</a></p>
            </div>
        </div>
    </center>

    <!-- <script>
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>