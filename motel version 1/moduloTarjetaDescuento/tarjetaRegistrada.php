<?php
require "../conection.php";
$habitacion=$_POST['habitacion'];
$descuentoPost=$_POST['descuento'];
$codigo=$_POST['codigo'];
$recarga="recarga";
$entro="si";


$selectMovtemp="select * from movtemp where habitacion='".$habitacion."' and id2=''";
$selectMov=$conexion->prepare($selectMovtemp);
$selectMov->execute();
$selectMov=$selectMov->fetch(PDO::FETCH_ASSOC);

/* SELECCIONO LA NUEVA TARJETA */
$selectDescuento="SELECT * FROM `veneficios` WHERE `codigo`=:codigo";
$descuento=$conexion->prepare($selectDescuento);
$descuento->bindParam(":codigo",$codigo);
$descuento->execute();
$descuento=$descuento->fetch(PDO::FETCH_ASSOC);

/* UPDATEO LA TARJETA PARA QUE QUEDE EN RECARGA */
$updateTArjetaSql="UPDATE `veneficios` SET `estado`=:recarga WHERE `codigo`=:codigo";
$updateTarjeta=$conexion->prepare($updateTArjetaSql);
$updateTarjeta->bindParam(":recarga",$recarga);
$updateTarjeta->bindParam(":codigo",$codigo);
$updateTarjeta->execute();


/* AGREGO EL ID TARJETA AL MOVTEMP */
$descuentoMasTarjeta=$selectMov['descuento']+$descuentoPost;
$addTarjetaMovtemp="UPDATE `movtemp` SET `idTarjetaDescuento`=:idTarjetaDescuento,`descuento`=:descuento,`entroTarjeta`=:entroTarjeta WHERE `id`=:idmov";
$addAMovtemp=$conexion->prepare($addTarjetaMovtemp);
$addAMovtemp->bindParam(":descuento",$descuentoMasTarjeta);
$addAMovtemp->bindParam(":entroTarjeta",$entro);
$addAMovtemp->bindParam(":idTarjetaDescuento",$descuento['id']);
$addAMovtemp->bindParam(":idmov",$selectMov['id']);
$addAMovtemp->execute();





header("location:../habitOcupada.php?id=$habitacion");



?>