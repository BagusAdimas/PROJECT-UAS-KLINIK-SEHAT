<?php

session_start();

require_once "../models/Reservasi.php";

$reservasi = new Reservasi();

if(isset($_POST['simpan'])){

    // FIX: Definisikan id_user dari session dan hapus baris debug/die()
    $id_user = $_SESSION['id_user'];

    $id_dokter = $_POST['id_dokter'];

    $tanggal = $_POST['tanggal'];

    $keluhan = $_POST['keluhan'];

    if($reservasi->tambah(
        $id_user,
        $id_dokter,
        $tanggal,
        $keluhan
    )){

        echo "<script>
        alert('Reservasi berhasil dibuat');
        window.location='../views/dashboard.php';
        </script>";

    }else{

        echo "<script>
        alert('Reservasi gagal');
        history.back();
        </script>";

    }

}