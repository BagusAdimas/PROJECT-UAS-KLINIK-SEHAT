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

// 1. Cari id_dokter berdasarkan email user login
$query_dokter = $conn->prepare("SELECT id_dokter FROM dokter WHERE email = (SELECT email FROM users WHERE id_user = ?)");
$query_dokter->bind_param("i", $id_user_dokter);
$query_dokter->execute();
$res_dokter = $query_dokter->get_result()->fetch_assoc();
$id_dokter = $res_dokter['id_dokter'];

// ==================================================
// 2. PERBAIKAN: Aksi Ganti Status Terima/Tolak 
// ==================================================
if (isset($_GET['action']) && isset($_GET['id_res'])) {
    $id_res = $_GET['id_res'];
    
    // Hapus spasi tersembunyi & ubah ke huruf kecil semua agar aman
    $action = trim(strtolower($_GET['action'])); 
    
    if ($action === 'terima') {
        $status_baru = 'Diterima';
    } elseif ($action === 'tolak') {
        $status_baru = 'Ditolak';
    } else {
        // Jika action tidak valid, jangan lakukan apa-apa
        header("Location: reservasi_masuk.php");
        exit;
    }
    
    $stmt_update = $conn->prepare("UPDATE reservasi SET status = ? WHERE id_reservasi = ? AND id_dokter = ?");
    $stmt_update->bind_param("sii", $status_baru, $id_res, $id_dokter);
    $stmt_update->execute();
    
    header("Location: reservasi_masuk.php");
    exit;
}

// 3. Ambil data reservasi
$query_reservasi = $conn->prepare("
    SELECT r.*, u.nama AS nama_pasien 
    FROM reservasi r
    JOIN users u ON r.id_user = u.id_user
    WHERE r.id_dokter = ?
    ORDER BY r.tanggal DESC
");
$query_reservasi->bind_param("i", $id_dokter);
$query_reservasi->execute();
$data_reservasi = $query_reservasi->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Masuk - Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Reservasi Pasien Masuk</h4>
            <a href="dashboard.php" class="btn btn-sm btn-light">Kembali ke Dashboard</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Berkunjung</th>
                        <th>Keluhan Pasien</th>
                        <th>Status</th>
                        <th class="text-center">Aksi Pemrosesan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = $data_reservasi->fetch_assoc()) { 
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= htmlspecialchars($row['keluhan']); ?></td>
                        <td>
                            <?php if($row['status'] == "Menunggu"){ ?>
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            <?php } elseif($row['status'] == "Diterima") { ?>
                                <span class="badge bg-success">Diterima</span>
                            <?php } elseif($row['status'] == "Selesai") { ?>
                                <span class="badge bg-primary">Selesai Diperiksa</span>
                            <?php } elseif($row['status'] == "Ditolak") { ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php } else { ?>
                                <span class="badge bg-dark">Error/Tidak Dikenali: '<?= htmlspecialchars($row['status']); ?>'</span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if($row['status'] == "Menunggu"){ ?>
                                <a href="reservasi_masuk.php?action=terima&id_res=<?= $row['id_reservasi']; ?>" class="btn btn-sm btn-success">Terima</a>
                                <a href="reservasi_masuk.php?action=tolak&id_res=<?= $row['id_reservasi']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tolak reservasi ini?')">Tolak</a>
                            <?php } elseif($row['status'] == "Diterima") { ?>
                                <a href="rekam_medis.php?id_res=<?= $row['id_reservasi']; ?>" class="btn btn-sm btn-primary">⚡ Isi Rekam Medis</a>
                            <?php } else { ?>
                                <span class="text-muted">-</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($data_reservasi->num_rows == 0) { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data reservasi masuk.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>