<?php

require_once "../models/Dokter.php";

$dokter = new Dokter();


// ==========================
// Tambah Dokter
// ==========================

if(isset($_POST['tambah'])){

    $nama = $_POST['nama_dokter'];
    $spesialis = $_POST['spesialis'];
    $str = $_POST['no_str'];
    $email = $_POST['email'];

    if($dokter->tambah($nama,$spesialis,$str,$email)){

        echo "<script>

            alert('Data dokter berhasil ditambahkan');

            window.location='../views/data_dokter.php';

        </script>";

    }else{

        echo "<script>

            alert('Gagal menambahkan data');

            history.back();

        </script>";

    }

}



// ==========================
// Update Dokter
// ==========================

if(isset($_POST['update'])){

    $id = $_POST['id_dokter'];

    $nama = $_POST['nama_dokter'];
    $spesialis = $_POST['spesialis'];
    $str = $_POST['no_str'];
    $email = $_POST['email'];

    $dokter->update(
        $id,
        $nama,
        $spesialis,
        $str,
        $email
    );

    header("Location: ../views/data_dokter.php");

}



// ==========================
// Hapus Dokter
// ==========================

if(isset($_GET['hapus'])){

    $dokter->delete($_GET['hapus']);

    header("Location: ../views/data_dokter.php");

}