<?php

require_once __DIR__ . "/../config/Database.php";

class Reservasi
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Menampilkan semua reservasi
    public function getAll()
    {
        $sql = "SELECT reservasi.*, users.nama, dokter.nama_dokter
                FROM reservasi
                JOIN users ON reservasi.id_user = users.id_user
                JOIN dokter ON reservasi.id_dokter = dokter.id_dokter
                ORDER BY tanggal DESC";

        return $this->conn->query($sql);
    }

    // Menampilkan reservasi milik pasien
    public function getByUser($id_user)
    {
        $stmt = $this->conn->prepare("
            SELECT reservasi.*, dokter.nama_dokter
            FROM reservasi
            JOIN dokter ON reservasi.id_dokter = dokter.id_dokter
            WHERE id_user=?
            ORDER BY tanggal DESC
        ");

        $stmt->bind_param("i",$id_user);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Tambah reservasi
    public function tambah($id_user,$id_dokter,$tanggal,$keluhan)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO reservasi
            (id_user,id_dokter,tanggal,keluhan,status)
            VALUES (?,?,?,?,?)
        ");

        $status = "Menunggu";

        $stmt->bind_param(
            "iisss",
            $id_user,
            $id_dokter,
            $tanggal,
            $keluhan,
            $status
        );

        return $stmt->execute();
    }

    // Mengubah status reservasi
    public function updateStatus($id,$status)
    {
        $stmt = $this->conn->prepare("
            UPDATE reservasi
            SET status=?
            WHERE id_reservasi=?
        ");

        $stmt->bind_param("si",$status,$id);

        return $stmt->execute();
    }

}