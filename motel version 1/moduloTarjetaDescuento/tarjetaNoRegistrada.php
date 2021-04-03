<?php
require "../conection.php";
$habitacion=$_POST['habitacion'];
$codigo=$_POST['codigo'];
$descuento=$_POST['descuento'];
$recarga="recarga";


$selectMovtemp="select * from movtemp where habitacion='".$habitacion."' and id2=''";
$selectMov=$conexion->prepare($selectMovtemp);
$selectMov->execute();
$selectMov=$selectMov->fetch(PDO::FETCH_ASSOC);

/* INSERTO LA NUEVA TARJETA */
$insertTarjetaSql="INSERT INTO `veneficios`(`codigo`, `veneficio`, `estado`) 
                   VALUES (:codigo,
                           :veneficio,
                           :estado)"; 

$insertTarjeta=$conexion->prepare($insertTarjetaSql);
$insertTarjeta->bindParam(":codigo",$codigo);
$insertTarjeta->bindParam(":veneficio",$descuento);
$insertTarjeta->bindParam(":estado",$recarga);
$insertTarjeta->execute();
/* TRAIGO EL ID DE LA TARJETA INSERTAR */
$idTarjeta=$conexion->lastInsertId();
/* AGREGO EL ID TARJETA AL MOVTEMP */
$addTarjetaMovtemp="UPDATE `movtemp` SET `idTarjetaDescuento`=:idTarjetaDescuento WHERE `id`=:idmov";
$addAMovtemp=$conexion->prepare($addTarjetaMovtemp);
$addAMovtemp->bindParam(":idTarjetaDescuento",$idTarjeta);
$addAMovtemp->bindParam(":idmov",$selectMov['id']);
$addAMovtemp->execute();







/* SUMO AL DESCUENTO EL 10% DE LA TARJETA */
$entro="si";
$descuentoMasTarjeta=$selectMov['descuento']+$descuento;
$sql="UPDATE `movtemp` SET `descuento`=:descuento,`entroTarjeta`=:entroTarjeta WHERE `id`=:idmov";
$update=$conexion->prepare($sql);
$update->bindParam(":descuento",$descuentoMasTarjeta);
$update->bindParam(":entroTarjeta",$entro);
$update->bindParam(":idmov",$selectMov['id']);
$update->execute();



header("location:../habitOcupada.php?id=$habitacion");



?>