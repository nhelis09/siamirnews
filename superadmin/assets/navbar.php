<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark"
        style="background-image: url(../assets/navbar.jpg); background-size: cover;">
        <div class="container-fluid">
            <a class="navbar-brand ms-3">
                <img src="../assets/logo.png" width="50px" alt="" style="pointer-events: none;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="beranda.php"><i class="bi bi-house-door-fill"></i> Buana Uyelindo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php"><i class="bi bi-person-fill"></i> Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kategoriberita.php"><i class="bi bi-journal-text"></i> Kategori
                            Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="berita.php"><i class="bi bi-newspaper"></i> Berita</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Komentar <i class="bi bi-chat-right-text"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="komentar1.php"><i class="bi bi-chat-left-text"></i>
                                    Komentar 1</a></li>
                            <li><a class="dropdown-item" href="komentar2.php"><i class="bi bi-chat-left-text"></i>
                                    Komentar 2</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i
                                class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Logout</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="text-center">
                        Apakah Anda yakin ingin logout?
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>