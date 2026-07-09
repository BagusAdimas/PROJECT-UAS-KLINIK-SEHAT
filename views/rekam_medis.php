<?php
session_start();

// Proteksi halaman: Hanya role dokter yang bisa masuk
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'dokter') {
    header("Location: ../index.php");
    exit;
}

require_once "../config/Database.php";
$db = new Database();
$conn = $db->connect();

// Validasi parameter URL id_reservasi
if (!isset($_GET['id_res'])) {
    header("Location: reservasi_masuk.php");
    exit;
}

$id_reservasi   = $_GET['id_res'];
$id_user_dokter = $_SESSION['id_user'];

// 1. Cari id_dokter terlebih dahulu berdasarkan user yang sedang login
$query_dokter = $conn->prepare("SELECT id_dokter FROM dokter WHERE email = (SELECT email FROM users WHERE id_user = ?)");
$query_dokter->bind_param("i", $id_user_dokter);
$query_dokter->execute();
$res_dokter = $query_dokter->get_result()->fetch_assoc();
$id_dokter = $res_dokter['id_dokter'];

// 2. Ambil data pasien dan keluhan berdasarkan id_reservasi (Proteksi agar dokter hanya bisa mengisi reservasi miliknya)
$query_pasien = $conn->prepare("
    SELECT r.id_reservasi, r.keluhan, u.nama AS nama_pasien 
    FROM reservasi r
    JOIN users u ON r.id_user = u.id_user
    WHERE r.id_reservasi = ? AND r.id_dokter = ?
");
$query_pasien->bind_param("ii", $id_reservasi, $id_dokter);
$query_pasien->execute();
$data_pasien = $query_pasien->get_result()->fetch_assoc();

// Jika data reservasi tidak ditemukan atau bukan milik dokter tersebut, tendang kembali
if (!$data_pasien) {
    header("Location: reservasi_masuk.php");
    exit;
}

// 3. Proses simpan rekam medis saat tombol klik submit
if (isset($_POST['simpan_rm'])) {
    $diagnosa = htmlspecialchars($_POST['diagnosa']);
    $tindakan = htmlspecialchars($_POST['tindakan']);
    $resep    = htmlspecialchars($_POST['resep']);

    // Query INSERT disesuaikan pas dengan kolom database kamu (id_reservasi, diagnosa, tindakan, resep)
    $stmt_rm = $conn->prepare("INSERT INTO rekam_medis (id_reservasi, diagnosa, tindakan, resep) VALUES (?, ?, ?, ?)");
    $stmt_rm->bind_param("isss", $id_reservasi, $diagnosa, $tindakan, $resep);
    
    if ($stmt_rm->execute()) {
        // Set status reservasi menjadi 'Selesai' setelah rekam medis diisi
        $stmt_update = $conn->prepare("UPDATE reservasi SET status = 'Selesai' WHERE id_reservasi = ?");
        $stmt_update->bind_param("i", $id_reservasi);
        $stmt_update->execute();

        echo "<script>
                alert('Data Rekam Medis Pasien Berhasil Disimpan!');
                window.location='reservasi_masuk.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data rekam medis.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Rekam Medis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Input Hasil Rekam Medis Pasien</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pasien</label>
                            <input type="text" class="form-control bg-secondary-subtle" value="<?= htmlspecialchars($data_pasien['nama_pasien']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Keluhan Awal Pasien</label>
                            <textarea class="form-control bg-secondary-subtle" rows="2" readonly><?= htmlspecialchars($data_pasien['keluhan']); ?></textarea>
                        </div>
                        <hr>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Diagnosa Penyakit</label>
                            <textarea name="diagnosa" class="form-control" rows="3" placeholder="Tulis hasil analisa diagnosa penyakit pasien..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tindakan Medis</label>
                            <textarea name="tindakan" class="form-control" rows="3" placeholder="Tulis tindakan/penanganan medis yang diberikan..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Resep Obat</label>
                            <textarea name="resep" class="form-control" rows="3" placeholder="Tuliskan resep obat dan aturan dosis pemakaian..." required></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="simpan_rm" class="btn btn-success flex-fill">Simpan Rekam Medis</button>
                            <a href="reservasi_masuk.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>