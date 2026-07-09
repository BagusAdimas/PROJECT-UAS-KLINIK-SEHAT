<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

require_once "../models/Dokter.php";

$dokter = new Dokter();
$data = $dokter->getAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Data Dokter</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-4">

<div class="d-flex justify-content-between mb-3">

<h3>Data Dokter</h3>

<div>

<a href="dashboard.php" class="btn btn-secondary">

Dashboard

</a>

<a href="form_dokter.php" class="btn btn-success">

Tambah Dokter

</a>

</div>

</div>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-primary">

<tr>

<th>No</th>

<th>Nama Dokter</th>

<th>Spesialis</th>

<th>No STR</th>

<th>Email</th>

<th width="180">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=$data->fetch_assoc()){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row['nama_dokter'] ?></td>

<td><?= $row['spesialis'] ?></td>

<td><?= $row['no_str'] ?></td>

<td><?= $row['email'] ?></td>

<td>

<a

href="form_dokter.php?id=<?= $row['id_dokter'] ?>"

class="btn btn-warning btn-sm">

Edit

</a>

<a

href="../controllers/DokterController.php?hapus=<?= $row['id_dokter'] ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Hapus data dokter?')">

Hapus

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>