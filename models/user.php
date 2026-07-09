<?php

require_once __DIR__ . "/../config/Database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================
    // REGISTER / TAMBAH USER
    // ==========================
    public function register($nama, $email, $password, $role)
    {
        // Cek email
        $cek = $this->conn->prepare("
            SELECT id_user
            FROM users
            WHERE email = ?
        ");

        $cek->bind_param("s", $email);
        $cek->execute();

        if ($cek->get_result()->num_rows > 0) {
            return false;
        }

        // Hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->conn->prepare("
            INSERT INTO users
            (nama, email, password, role)
            VALUES (?, ?, ?, ?)
        ");

        $query->bind_param(
            "ssss",
            $nama,
            $email,
            $password,
            $role
        );

        if ($query->execute()) {
            return $this->conn->insert_id;
        }

        return false;
    }

    // ==========================
    // LOGIN
    // ==========================
    public function login($email, $password, $role)
    {
        $query = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE email = ? AND role = ?
        ");

        $query->bind_param("ss", $email, $role);
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                return $user;
            }

        }

        return false;
    }

    // ==========================
    // GET USER BERDASARKAN ID
    // ==========================
    public function getUserById($id)
    {
        $query = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE id_user = ?
        ");

        $query->bind_param("i", $id);
        $query->execute();

        return $query->get_result()->fetch_assoc();
    }

    // ==========================
    // GET SEMUA USER
    // ==========================
    public function getAllUser()
    {
        return $this->conn->query("
            SELECT *
            FROM users
            ORDER BY nama ASC
        ");
    }

    // ==========================
    // UPDATE USER
    // ==========================
    public function updateUser($id_user, $nama, $email)
    {
        $query = $this->conn->prepare("
            UPDATE users
            SET
                nama = ?,
                email = ?
            WHERE id_user = ?
        ");

        $query->bind_param(
            "ssi",
            $nama,
            $email,
            $id_user
        );

        return $query->execute();
    }

    // ==========================
    // HAPUS USER
    // ==========================
    public function deleteUser($id_user)
    {
        $query = $this->conn->prepare("
            DELETE FROM users
            WHERE id_user = ?
        ");

        $query->bind_param("i", $id_user);

        return $query->execute();
    }

}
?>