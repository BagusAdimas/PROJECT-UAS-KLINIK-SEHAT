<?php
session_start();

require_once "../models/User.php";

$user = new User();

// ======================
// REGISTER
// ======================
if (isset($_POST['register'])) {

    $nama     = htmlspecialchars($_POST['nama']);
    $email    = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Pasien yang mendaftar sendiri
    $role = "pasien";

    if ($user->register($nama, $email, $password, $role)) {

        echo "<script>
                alert('Registrasi berhasil');
                window.location='../index.php';
              </script>";

    } else {

        echo "<script>
                alert('Email sudah digunakan');
                window.location='../views/register.php';
              </script>";

    }

}


// ======================
// LOGIN
// ======================
if (isset($_POST['login'])) {

    $email    = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $data = $user->login($email,$password,$role);

    if($data){

        $_SESSION['login']=true;
        $_SESSION['id_user']=$data['id_user'];
        $_SESSION['nama']=$data['nama'];
        $_SESSION['role']=$data['role'];

        header("Location: ../views/dashboard.php");
        exit;

    }else{

        echo "<script>

            alert('Email atau Password salah');

            window.location='../index.php';

        </script>";

    }

}