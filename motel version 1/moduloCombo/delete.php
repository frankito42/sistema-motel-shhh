<?php

require "../conection.php";

$combo=$_GET['combo'];
$idCombo=$_GET['idCombo'];
$deleteSql="DELETE FROM `combos` WHERE `idCombo`=:id";
$delete=$conexion->prepare($deleteSql);
$delete->bindParam(":id",$idCombo);
$delete->execute();


header("location: detalleCombo.php?idCombo=$combo");

?>