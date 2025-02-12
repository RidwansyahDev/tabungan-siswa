<?php
require_once "database.php";
$qryIdRekening = $conn->query("SELECT MAX(id_rekening) FROM rekening_tabungan");
$resultRekening = $qryIdRekening->fetch_array();
$empty = $resultRekening[0];
$num = (int)substr($empty, 4);
$num++;
$car = "REK-";
$idRekening = sprintf("%s%04s", $car, $num);
