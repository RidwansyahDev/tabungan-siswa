<?php
    session_start();
    include "../config/app.php";
    $id=$_GET['id'];
    $query = "DELETE FROM rekening_tabungan WHERE id='$id'";
    mysqli_query($conn,$query);
    $_SESSION['berhasil'] = "Data berhasil dihapus";
    header("Location:index.php");
    exit();

?>
