<?php

require_once __DIR__ . "/../config/Database.php";

class RekamMedis
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Menampilkan semua rekam medis
    public function getAll()
    {
        $sql = "SELECT
                    rekam_medis.*,
                    users.nama,
                    dokter.nama_dokter,
                    reservasi.tanggal
                FROM rekam_medis
                JOIN reservasi ON rekam_medis.id_reservasi = reservasi.id_reservasi
                JOIN users ON reservasi.id_user = users.id_user
                JOIN dokter ON reservasi.id_dokter = dokter.id_dokter
                ORDER BY rekam_medis.id_rekam DESC";

        return $this->conn->query($sql);
    }

    // Menampilkan rekam medis berdasarkan reservasi
    public function getByReservasi($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM rekam_medis
            WHERE id_reservasi=?
        ");

        $stmt->bind_param("i",$id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Simpan rekam medis
    public function simpan($id_reservasi,$diagnosa,$tindakan,$resep)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO rekam_medis
            (id_reservasi,diagnosa,tindakan,resep)
            VALUES (?,?,?,?)
        ");

        $stmt->bind_param(
            "isss",
            $id_reservasi,
            $diagnosa,
            $tindakan,
            $resep
        );

        return $stmt->execute();
    }
}