<?php

session_start();

require_once "../models/User.php";
require_once "../models/Pasien.php";

$user = new User();
$pasien = new Pasien();


// ===========================
// TAMBAH PASIEN
// ===========================
if(isset($_POST['tambah'])){

    $nama            = htmlspecialchars($_POST['nama']);
    $email           = htmlspecialchars($_POST['email']);
    $password        = "pasien123"; // Password default
    $role            = "pasien";

    $tanggal_lahir   = $_POST['tanggal_lahir'];
    $jenis_kelamin   = $_POST['jenis_kelamin'];
    $alamat          = htmlspecialchars($_POST['alamat']);
    $no_hp           = htmlspecialchars($_POST['no_hp']);

    // Simpan ke tabel users
    $id_user = $user->register(
    $nama,
    $email,
    $password,
    $role
);

    if($id_user){

        // Simpan ke tabel pasien
        $pasien->tambah(
            $id_user,
            $tanggal_lahir,
            $jenis_kelamin,
            $alamat,
            $no_hp
        );

        header("Location: ../views/data_pasien.php");
        exit;

    }else{

        echo "<script>
                alert('Email sudah digunakan');
                window.location='../views/form_pasien.php';
              </script>";

    }

}


// ===========================
// UPDATE PASIEN
// ===========================
if(isset($_POST['update'])){

    $id_pasien       = $_POST['id_pasien'];

    $tanggal_lahir   = $_POST['tanggal_lahir'];
    $jenis_kelamin   = $_POST['jenis_kelamin'];
    $alamat          = htmlspecialchars($_POST['alamat']);
    $no_hp           = htmlspecialchars($_POST['no_hp']);

    $pasien->update(
        $id_pasien,
        $tanggal_lahir,
        $jenis_kelamin,
        $alamat,
        $no_hp
    );

    header("Location: ../views/data_pasien.php");
    exit;

}


// ===========================
// HAPUS PASIEN
// ===========================
if(isset($_GET['hapus'])){

    $pasien->hapus($_GET['hapus']);

    header("Location: ../views/data_pasien.php");
    exit;

}

?>