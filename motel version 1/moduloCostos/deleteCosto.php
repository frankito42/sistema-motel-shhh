<?php
require "../conection.php";
$id=$_GET['id'];


$sql="DELETE FROM `costos` WHERE `costo`=:id";

$delete=$conexion->prepare($sql);

$delete->bindParam(":id",$id);

$delete->execute();


header("location:../costosAVM.php");





?>