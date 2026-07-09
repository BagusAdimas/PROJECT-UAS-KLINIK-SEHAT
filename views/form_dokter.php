<?php

session_start();

require_once "../models/Dokter.php";

$dokter = new Dokter();

$id = "";
$nama = "";
$spesialis = "";
$str = "";
$email = "";

if(isset($_GET['id'])){

    $data = $dokter->getById($_GET['id']);

    $id = $data['id_dokter'];
    $nama = $data['nama_dokter'];
    $spesialis = $data['spesialis'];
    $str = $data['no_str'];
    $email = $data['email'];

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Form Dokter</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header">

<h4>

<?= isset($_GET['id']) ? "Edit Dokter" : "Tambah Dokter"; ?>

</h4>

</div>

<div class="card-body">

<form action="../controllers/DokterController.php" method="POST">

<input
type="hidden"
name="id_dokter"
value="<?= $id ?>">

<div class="mb-3">

<label>Nama Dokter</label>

<input

type="text"

name="nama_dokter"

class="form-control"

value="<?= $nama ?>"

required>

</div>

<div class="mb-3">

<label>Spesialis</label>

<input

type="text"

name="spesialis"

class="form-control"

value="<?= $spesialis ?>"

required>

</div>

<div class="mb-3">

<label>No STR</label>

<input

type="text"

name="no_str"

class="form-control"

value="<?= $str ?>"

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

<a href="data_dokter.php" class="btn btn-secondary">

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