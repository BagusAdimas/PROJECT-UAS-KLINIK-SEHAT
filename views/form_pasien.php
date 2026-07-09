<?php

session_start();

require_once "../models/Pasien.php";

$pasien = new Pasien();

$id = "";
$nama = "";
$email = "";
$tanggal_lahir = "";
$jenis_kelamin = "";
$alamat = "";
$no_hp = "";

if(isset($_GET['id'])){

    $data = $pasien->getById($_GET['id']);

    $id = $data['id_pasien'];
    $nama = $data['nama'];
    $email = $data['email'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $alamat = $data['alamat'];
    $no_hp = $data['no_hp'];

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Form Pasien</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header">

<h4>

<?= isset($_GET['id']) ? "Edit Pasien" : "Tambah Pasien"; ?>

</h4>

</div>

<div class="card-body">

<form action="../controllers/PasienController.php" method="POST">

<input
type="hidden"
name="id_pasien"
value="<?= $id ?>">

<div class="mb-3">

<label>Nama Pasien</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= $nama ?>"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= $email ?>"
required>

</div>

<div class="mb-3">

<label>Tanggal Lahir</label>

<input
type="date"
name="tanggal_lahir"
class="form-control"
value="<?= $tanggal_lahir ?>"
required>

</div>

<div class="mb-3">

<label>Jenis Kelamin</label>

<select
name="jenis_kelamin"
class="form-select"
required>

<option value="">-- Pilih --</option>

<option value="L"
<?= ($jenis_kelamin=="L") ? "selected" : ""; ?>>

Laki-laki

</option>

<option value="P"
<?= ($jenis_kelamin=="P") ? "selected" : ""; ?>>

Perempuan

</option>

</select>

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"
rows="3"
required><?= $alamat ?></textarea>

</div>

<div class="mb-3">

<label>No HP</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= $no_hp ?>"
required>

</div>

<?php

if(isset($_GET['id'])){

?>

<button
type="submit"
name="update"
class="btn btn-warning">

Update

</button>

<?php

}else{

?>

<button
type="submit"
name="tambah"
class="btn btn-success">

Simpan

</button>

<?php

}

?>

<a href="data_pasien.php" class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>