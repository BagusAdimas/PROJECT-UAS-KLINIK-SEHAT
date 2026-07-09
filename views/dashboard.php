<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Dashboard Klinik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand" href="#">
            Klinik Sehat
        </a>

        <div class="ms-auto">

            <span class="text-white me-3">

                Selamat Datang,
                <b><?= $nama; ?></b>

            </span>

            <a href="logout.php" class="btn btn-danger">Logout</a>



        </div>

    </div>

</nav>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-body">

            <h3>Dashboard</h3>

            <hr>

            <p>

                Nama :

                <b><?= $nama; ?></b>

            </p>

            <p>

                Role :

                <span class="badge bg-success">

                    <?= ucfirst($role); ?>

                </span>

            </p>

        </div>

    </div>

<?php

if($role=="admin"){

?>

<div class="row mt-4">

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h5>Kelola Dokter</h5>

                <a href="form_dokter.php" class="btn btn-primary">

                    Buka

                </a>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h5>Kelola Pasien</h5>

                <a href="form_pasien.php" class="btn btn-primary">

                    Buka

                </a>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h5>Data Reservasi</h5>

                <a href="riwayat_reservasi.php" class="btn btn-primary">

                    Buka

                </a>

            </div>

        </div>

    </div>

</div>

<?php
}
?>

<?php

if($role=="dokter"){

?>

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <h5>Reservasi Masuk</h5>

                <a href="reservasi_masuk.php" class="btn btn-success">

                    Lihat

                </a>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <h5>Rekam Medis</h5>

                <a href="riwayat_rekam_medis.php" class="btn btn-success">

                    Lihat

                </a>

            </div>

        </div>

    </div>

</div>

<?php
}
?>

<?php

if($role=="pasien"){

?>

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <h5>Buat Reservasi</h5>

                <a href="reservasi.php" class="btn btn-warning">

                    Reservasi

                </a>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <h5>Riwayat Reservasi</h5>

                <a href="riwayat_reservasi.php" class="btn btn-warning">

                    Lihat

                </a>

            </div>

        </div>

    </div>

</div>

<?php
}
?>

</div>

</body>

</html>