<?php
session_start();
require_once '../config/app.php';

$id =$_GET['id'];
$query = "DELETE FROM kelas WHERE id='$id'";
mysqli_query($conn,$query);

 // set session berhasil hapus data
 $_SESSION['berhasil'] = "Data berhasil dihapus";
 header('Location: '.BASE_URL.'/kelas/index.php');
 exit();
