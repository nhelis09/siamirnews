<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Sedang Dikembangkan</title>
    <?php include 'assets/cdn.php'; ?>
    <link rel="icon" href="assets/logo.png" type="image/x-icon">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-image: url('https://source.unsplash.com/1600x900/?construction');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.95);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        max-width: 80%;
        backdrop-filter: blur(5px);
        transition: transform 0.3s ease-out;
    }

    h1 {
        color: #333;
        font-size: 3em;
        margin-bottom: 20px;
    }

    p {
        color: #444;
        font-size: 1.5em;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .gif-container {
        max-width: 100%;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .footer-text {
        color: #555;
        font-size: 1.2em;
    }

    .back-button {
        display: inline-block;
        background-color: #007bff;
        /* Warna biru */
        color: white;
        padding: 15px 30px;
        text-align: center;
        text-decoration: none;
        font-size: 1.5em;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border: none;
        outline: none;
    }

    .back-button:hover {
        background-color: #0056b3;
        /* Warna biru lebih gelap saat dihover */
    }

    @media (max-width: 600px) {
        h1 {
            font-size: 2.5em;
        }

        p {
            font-size: 1.2em;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Forum <span style="color: red;">Diskusi</span> Sedang <span style="color: red;">Dikembangkan</span></h1>
        <p>Mohon maaf, Forum <span style="color: red;">Diskusi</span> sedang dalam proses <span
                style="color: red;">pengembangan</span>. Kami akan segera
            kembali!</p>
        <div class="gif-container">
            <img src="https://websiamirnews22110023.my.id/assets/Animationbekerja.gif" draggable="false"
                alt="Under Construction" style="max-width: 100%;">
        </div>
        <p class="footer-text">Terima kasih atas kesabaran Anda.<br>Salam Hangat, Kornelis Andrian Kabo</p>
        <a href="https://websiamirnews22110023.my.id/" class="back-button">Kembali ke Tampilan Awal</a>
    </div>
</body>

</html>

<script>
// Mencegah klik kanan
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});

// Mencegah inspeksi elemen
document.addEventListener('keydown', function(e) {
    if (e.key === 'F12') {
        e.preventDefault();
    }
});
</script>