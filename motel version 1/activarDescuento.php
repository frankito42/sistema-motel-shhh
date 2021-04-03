<?php
require "conection.php";
$id=$_POST['id'];
$idmov=$_POST['idmov'];
$descuento=$_POST['descuento'];
$sql="UPDATE `movtemp` SET `descuento`=:descuento WHERE `id`=:idmov";
$update=$conexion->prepare($sql);
$update->bindParam(":descuento",$descuento);
$update->bindParam(":idmov",$idmov);

if($update->execute()){
header("location: habitOcupada.php?id=$id");
}
?>