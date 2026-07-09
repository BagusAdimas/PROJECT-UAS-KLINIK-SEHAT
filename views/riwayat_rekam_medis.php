<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'dokter') {
    header("Location: ../index.php");
    exit;
}

require_once "../config/Database.php";
$db = new Database();
$conn = $db->connect();

$id_user_dokter = $_SESSION['id_user'];

// 1. Cari id_dokter berdasarkan user login
$query_dokter = $conn->prepare("SELECT id_dokter FROM dokter WHERE email = (SELECT email FROM users WHERE id_user = ?)");
$query_dokter->bind_param("i", $id_user_dokter);
$query_dokter->execute();
$id_dokter = $query_dokter->get_result()->fetch_assoc()['id_dokter'];

// 2. Ambil data riwayat rekam medis yang pernah diinput oleh dokter ini
$query_riwayat = $conn->prepare("
    SELECT rm.*, r.tanggal, u.nama AS nama_pasien
    FROM rekam_medis rm
    JOIN reservasi r ON rm.id_reservasi = r.id_reservasi
    JOIN users u ON r.id_user = u.id_user
    WHERE r.id_dokter = ?
    ORDER BY r.tanggal DESC
");
$query_riwayat->bind_param("i", $id_dokter);
$query_riwayat->execute();
$data_riwayat = $query_riwayat->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Rekam Medis - Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Riwayat Penanganan Rekam Medis Pasien</h4>
            <a href="dashboard.php" class="btn btn-sm btn-light">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Periksa</th>
                        <th>Diagnosa</th>
                        <th>Tindakan Medis</th>
                        <th>Resep Obat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = $data_riwayat->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= htmlspecialchars($row['diagnosa']); ?></td>
                        <td><?= htmlspecialchars($row['tindakan']); ?></td>
                        <td><?= htmlspecialchars($row['resep']); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($data_riwayat->num_rows == 0) { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada riwayat rekam medis yang diisi.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>