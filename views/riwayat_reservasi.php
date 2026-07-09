<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

require_once "../models/Reservasi.php";

// 1. BUAT OBJEK RESERVASI (Ini yang membuat error Undefined)
$reservasi = new Reservasi();

// 2. BAGIAN DEBUGGING SEBELUMNYA SUDAH DIHAPUS AGAR TIDAK TERKENA exit;

// 3. JALANKAN LOGIKA PEMBAGIAN ROLE ADMIN & PASIEN
if ($_SESSION['role'] == "admin") {
    $data = $reservasi->getAll();
} else {
    // Pasien hanya melihat reservasinya sendiri
    $data = $reservasi->getByUser($_SESSION['id_user']);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Reservasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
    <h4>Riwayat Reservasi</h4>
</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>No</th>

<?php if($_SESSION['role']=="admin"){ ?>
<th>Pasien</th>
<?php } ?>

<th>Dokter</th>
<th>Tanggal</th>
<th>Keluhan</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($row = $data->fetch_assoc()){

?>

<tr>

<td><?= $no++ ?></td>

<?php if($_SESSION['role']=="admin"){ ?>

<td><?= $row['nama']; ?></td>

<?php } ?>

<td><?= $row['nama_dokter']; ?></td>

<td><?= $row['tanggal']; ?></td>

<td><?= $row['keluhan']; ?></td>

<td>

<?php

if($row['status']=="Menunggu"){

    echo "<span class='badge bg-warning text-dark'>Menunggu</span>";

}elseif($row['status']=="Diterima"){

    echo "<span class='badge bg-success'>Diterima</span>";

}else{

    echo "<span class='badge bg-danger'>Ditolak</span>";

}

?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<a href="dashboard.php" class="btn btn-secondary">
    Kembali
</a>

</div>

</div>

</div>

</body>

</html>