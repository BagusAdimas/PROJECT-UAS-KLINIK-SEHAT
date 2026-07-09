<?php

require_once __DIR__ . "/../config/Database.php";

class Pasien
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================
    // TAMPILKAN SEMUA PASIEN
    // ==========================
    public function getAll()
    {
        $query = "
            SELECT
                pasien.id_pasien,
                users.id_user,
                users.nama,
                users.email,
                pasien.tanggal_lahir,
                pasien.jenis_kelamin,
                pasien.alamat,
                pasien.no_hp
            FROM pasien
            INNER JOIN users
            ON pasien.id_user = users.id_user
            ORDER BY users.nama ASC
        ";

        return $this->conn->query($query);
    }

    // ==========================
    // TAMPILKAN SATU PASIEN
    // ==========================
    public function getById($id)
    {
        $query = $this->conn->prepare("
            SELECT
                pasien.*,
                users.nama,
                users.email
            FROM pasien
            INNER JOIN users
            ON pasien.id_user = users.id_user
            WHERE pasien.id_pasien = ?
        ");

        $query->bind_param("i", $id);
        $query->execute();

        return $query->get_result()->fetch_assoc();
    }

    // ==========================
    // TAMBAH PASIEN
    // ==========================
    public function tambah($id_user, $tanggal_lahir, $jenis_kelamin, $alamat, $no_hp)
    {
        $stmt = $this->conn->prepare("INSERT INTO pasien (id_user, tanggal_lahir, jenis_kelamin, alamat, no_hp) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "issss",
            $id_user,
            $tanggal_lahir,
            $jenis_kelamin,
            $alamat,
            $no_hp
        );

        return $stmt->execute();
    }

    // ==========================
    // UPDATE PASIEN
    // ==========================
    public function update($id_pasien, $tanggal_lahir, $jenis_kelamin, $alamat, $no_hp)
    {
        $query = $this->conn->prepare("
            UPDATE pasien
            SET
                tanggal_lahir=?,
                jenis_kelamin=?,
                alamat=?,
                no_hp=?
            WHERE id_pasien=?
        ");

        $query->bind_param(
            "ssssi",
            $tanggal_lahir,
            $jenis_kelamin,
            $alamat,
            $no_hp,
            $id_pasien
        );

        return $query->execute();
    }

    // ==========================
    // HAPUS PASIEN
    // ==========================
    public function hapus($id)
    {
        $query = $this->conn->prepare("
            DELETE FROM pasien
            WHERE id_pasien=?
        ");

        $query->bind_param("i", $id);

        return $query->execute();
    }

}

?>