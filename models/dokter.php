<?php

require_once __DIR__ . "/../config/Database.php";

class Dokter
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Menampilkan semua dokter
    public function getAll()
    {
        $sql = "SELECT * FROM dokter ORDER BY id_dokter DESC";
        return $this->conn->query($sql);
    }

    // Menampilkan satu dokter
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM dokter WHERE id_dokter=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Menambah dokter
    public function tambah($nama,$spesialis,$str,$email)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO dokter
            (nama_dokter,spesialis,no_str,email)
            VALUES (?,?,?,?)
        ");

        $stmt->bind_param(
            "ssss",
            $nama,
            $spesialis,
            $str,
            $email
        );

        return $stmt->execute();
    }

    // Mengubah dokter
    public function update($id,$nama,$spesialis,$str,$email)
    {
        $stmt = $this->conn->prepare("
            UPDATE dokter
            SET
            nama_dokter=?,
            spesialis=?,
            no_str=?,
            email=?
            WHERE id_dokter=?
        ");

        $stmt->bind_param(
            "ssssi",
            $nama,
            $spesialis,
            $str,
            $email,
            $id
        );

        return $stmt->execute();
    }

    // Menghapus dokter
    public function delete($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM dokter
            WHERE id_dokter=?
        ");

        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }
}