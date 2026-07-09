<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

require_once "../config/Database.php";

$db = new Database();
$conn = $db->connect();

$dokter = $conn->query("SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reservasi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>Reservasi Dokter</h4>

</div>

<div class="card-body">

<form action="../controllers/ReservasiController.php" method="POST">

<div class="mb-3">

<label>Dokter</label>

<select
name="id_dokter"
class="form-select"
required>

<option value="">Pilih Dokter</option>

<?php while($row=$dokter->fetch_assoc()){ ?>

<option value="<?= $row['id_dokter'] ?>">

<?= $row['nama_dokter'] ?>

- <?= $row['spesialis'] ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Tanggal Reservasi</label>

<input

type="date"

name="tanggal"

class="form-control"

required>

</div>

<div class="mb-3">

<label>Keluhan</label>

<textarea

name="keluhan"

rows="4"

class="form-control"

required>

</textarea>

</div>

<button

type="submit"

name="simpan"

class="btn btn-success">

Simpan Reservasi

</button>

<a

href="dashboard.php"

class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>