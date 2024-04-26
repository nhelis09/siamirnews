<?php include 'assets/konektor.php'; //koneksi ke database 
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Buana Uyelindo</title>
    <?php include 'assets/cdn.php'; //mengakses cdn bootstrap 
    ?>
</head>

<body>

    <div class="container pt-0">
        <img src="assets/banner.jpg" width="100%" alt="">
        <?php include 'assets/navbar.php'; ?>

        <br>
        <div class="row">
            <div class="col-sm-3">


                <!-- Profil -->
                <div class="accordion" id="accordionProfil">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProfil">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfil" aria-expanded="false" aria-controls="collapseProfil">
                                <h5 class="card-title">Profil</h5>
                            </button>
                        </h2>
                        <div id="collapseProfil" class="accordion-collapse collapse" aria-labelledby="headingProfil" data-bs-parent="#accordionProfil">
                            <div class="accordion-body">
                                <div class="list-group">
                                    <?php
                                    $result = mysqli_query($konektor, "SELECT * FROM profil");
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id_profil = $row['idprofil'];
                                            $isi_profil = $row['isiprofil'];
                                    ?>
                                            <div class="">
                                                <div class="">
                                                    <p class="card-text"><?php echo $isi_profil; ?></p>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                        mysqli_free_result($result);
                                    } else {
                                        echo "Error: " . mysqli_error($konektor);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Kontak -->
                <div class="accordion" id="accordionKontak">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingKontak">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKontak" aria-expanded="false" aria-controls="collapseKontak">
                                <h5 class="card-title">Kontak</h5>
                            </button>
                        </h2>
                        <div id="collapseKontak" class="accordion-collapse collapse" aria-labelledby="headingKontak" data-bs-parent="#accordionKontak">
                            <div class="accordion-body">
                                <div class="">
                                    <!-- Tambahkan class card pada div berikut -->

                                    <?php
                                    $result = mysqli_query($konektor, "SELECT * FROM portal");
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $no_telepon = $row['telepon'];
                                            $email = $row['email'];
                                            $peta_lokasi = $row['petalokasi'];

                                            // Tampilkan data kontak
                                            echo "Peta Lokasi: " . $peta_lokasi . "<br>";
                                            echo '<a href="#" class="list-group-item list-group-item-action">';
                                            echo "No Telepon: " . $no_telepon . "<br>";
                                            echo "Email: " . $email . "<br>";

                                            echo '</a>';
                                        }
                                        mysqli_free_result($result);
                                    } else {
                                        echo "Error: " . mysqli_error($konektor);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Kategori Berita -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Kategori Berita</h5>
                        <ul class="list-group">
                            <?php
                            $kategori = mysqli_query($konektor, "select * from kategoriberita");
                            while ($kat = mysqli_fetch_array($kategori)) {
                            ?>
                                <a href="kategoriberita.php?id=<?php echo $kat['idkategori']; ?>" class="list-group-item list-group-item-action"><?php echo $kat['nama']; ?></a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <?php
                $data = mysqli_query($konektor, "select * from berita where status like '2'");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="fotoberita/<?php echo $d['idberita']; ?>.jpg" class="img-fluid rounded-start" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $d['judul']; ?></h5>
                                    <p class="card-text"><small class="text-muted">Diterbitkan pada <?php echo date("d F Y H:i", strtotime($d['tanggal'])); ?></small></p>
                                    <p class="card-text"><?php echo substr($d['isi'], 0, 400) . '...'; ?> <a href="detailberita.php?id=<?php echo $d['idberita']; ?>">Selengkapnya</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

</body>

</html>