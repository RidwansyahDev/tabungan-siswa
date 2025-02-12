<?php
    include"../config/app.php";

    $id =$_GET['id'];
    $query = "DELETE FROM petugas WHERE id='$id'";
    mysqli_query($conn,$query);
    $_SESSION['berhasil'] = "Data berhasil dihapus";
    header("Location:index.php");

?>
