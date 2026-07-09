<?php

require_once "../models/RekamMedis.php";
require_once "../models/Reservasi.php";

$rekam = new RekamMedis();
$reservasi = new Reservasi();

if(isset($_POST['simpan'])){

    $id_reservasi = $_POST['id_reservasi'];

    $diagnosa = $_POST['diagnosa'];

    $tindakan = $_POST['tindakan'];

    $resep = $_POST['resep'];

    if($rekam->simpan(
        $id_reservasi,
        $diagnosa,
        $tindakan,
        $resep
    )){

        // Ubah status reservasi menjadi selesai
        $reservasi->updateStatus(
            $id_reservasi,
            "Selesai"
        );

        echo "<script>

        alert('Rekam medis berhasil disimpan');

        window.location='../views/data_reservasi.php';

        </script>";

    }else{

        echo "<script>

        alert('Gagal menyimpan');

        history.back();

        </script>";

    }

}