<?php include '../assets/konektor.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buanaya Uyelindo - Login Admin</title>
    <?php include '../assets/cdn.php'; ?>
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <style>
    body {
        width: 100%;
        min-height: 100vh;
        /* background-image: url('https://scontent.fdps5-1.fna.fbcdn.net/v/t39.30808-6/332868587_732893388389427_3378054504619315945_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeFsqetfFyGLjgpFenKKCrY196MNQ0HtIP73ow1DQe0g_loAskQXB72WgqrAKldKt28rWID87LMLe18U9GnWCIcN&_nc_ohc=cPa2j_vkgTIAX_hqsdw&_nc_ht=scontent.fdps5-1.fna&oh=00_AfCup09OJ_Xk9cMdIgkeYYqF42q7-H0lVoWnrMBYS2pkHg&oe=66119261'); */
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
                        <h1>Login Admin</h1>
                    </div>
                    <p>Selamat datang admin. Silahkan masukkan email dan password kemudian klik tombol login</p>
                    <form action="assets/ceklogin.php" method="POST" name="login">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Email</span>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text">Password</span>
                            <input type="password" name="password" required class="form-control">
                        </div>
                        <p><input type="submit" class="btn btn-warning" value="Login"></p>
                        <p><a href="lupapassword.php">Lupa Password?</a></p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>