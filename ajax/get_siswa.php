<?php
include "../config/app.php";

if (isset($_POST['id_siswa'])) {
    $id = $_POST['id_siswa'];

    $query = "SELECT siswa.nama, rekening_tabungan.saldo
              FROM siswa
              JOIN rekening_tabungan ON rekening_tabungan.id_siswa = siswa.id_siswa
              WHERE siswa.id_siswa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nama,$saldo);
    $stmt->fetch();

    echo rupiah($saldo);

    $stmt->close();
}
?>
