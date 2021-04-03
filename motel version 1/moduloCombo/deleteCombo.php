<?php
require "../conection.php";



$comboId=$_GET['idCombo'];
$deleteSql="DELETE FROM `articulos` WHERE `articulo`=:id";
$delete=$conexion->prepare($deleteSql);
$delete->bindParam(":id",$comboId);
$delete->execute();

$deleteTodosArticulosCombos="DELETE FROM `combos` WHERE `idArticuloCombo`=:id";
$deleteComboArticulo=$conexion->prepare($deleteTodosArticulosCombos);
$deleteComboArticulo->bindParam(":id",$comboId);
$deleteComboArticulo->execute();



header("location: ../combos.php");



?>