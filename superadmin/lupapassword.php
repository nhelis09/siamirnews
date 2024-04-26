<?php include '../assets/konektor.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buanaya Uyelindo - Lupa Password</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <style>
    body {
        width: 100%;
        min-height: 100vh;
        background-image: url(assets/backround.jpg);
        background-size: cover;
        background-position: center;
        background-color: #222;
        color: #fff;
    }

    .login-container {
        margin-top: 10%;
        padding: 20px;
        border-radius: 10px;
        background-color: firebrick;
    }

    .login-container h1 {
        margin-bottom: 20px;
    }

    .login-container form {
        margin-bottom: 0;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 mx-auto">
                <div class="login-container">
                    <div class="text-center">
                        <h1>Lupa Password</h1>
                    </div>
                    <p>Masukkan email Anda di bawah ini. Kami akan mengirimkan instruksi untuk mereset password Anda.
                    </p>
                    <form action="assets/aksilupapassword.php" method="POST" name="aksilupapassword">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Email</span>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <p><input type="submit" class="btn btn-warning" value="Kirim"></p>
                        <p><a href="index.php">Login Sekarang</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>