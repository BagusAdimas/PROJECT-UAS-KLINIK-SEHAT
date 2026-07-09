<?php

session_start();

require_once "../models/Pasien.php";

$pasien = new Pasien();
$dataPasien = $pasien->getAll();

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Data Pasien</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header d-flex justify-content-between align-items-center">

<h3>Data Pasien</h3>

<div>

<a href="form_pasien.php" class="btn btn-primary">

Tambah Pasien

</a>

<a href="dashboard.php" class="btn btn-secondary">

Dashboard

</a>

</div>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>No</th>

<th>Nama</th>

<th>Email</th>

<th>Tanggal Lahir</th>

<th>Jenis Kelamin</th>

<th>No HP</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($row = $dataPasien->fetch_assoc()){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama']; ?></td>

<td><?= $row['email']; ?></td>

<td><?= $row['tanggal_lahir']; ?></td>

<td>

<?php

if($row['jenis_kelamin']=="L"){

    echo "Laki-laki";

}else{

    echo "Perempuan";

}

?>

</td>

<td><?= $row['no_hp']; ?></td>

<td width="180">

<a
href="form_pasien.php?id=<?= $row['id_pasien']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="../controllers/PasienController.php?hapus=<?= $row['id_pasien']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus pasien ini?')">

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