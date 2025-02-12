<?php
    session_start();
    require_once "../config/app.php";
    $id = $_GET['id'];

    // var_dump($id);
    $query = "DELETE FROM siswa WHERE id_siswa = '$id'";
    mysqli_query($conn, $query);
    // set session berhasil hapus data
    $_SESSION['berhasil'] = "Data berhasil dihapus";
    header('Location: '.BASE_URL.'/siswa/index.php');
    exit();
