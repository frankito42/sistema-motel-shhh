<?php
require "../conection.php";
$habitacion=$_POST['habitacion'];
$codigo=$_POST['codigo'];
$disponible="disponible";
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
$updateTArjetaSql="UPDATE `veneficios` SET `estado`=:disponible WHERE `codigo`=:codigo";
$updateTarjeta=$conexion->prepare($updateTArjetaSql);
$updateTarjeta->bindParam(":disponible",$disponible);
$updateTarjeta->bindParam(":codigo",$codigo);
$updateTarjeta->execute();


/* AGREGO EL ID TARJETA AL MOVTEMP */
$addTarjetaMovtemp="UPDATE `movtemp` SET `idTarjetaDescuento`=:idTarjetaDescuento,`entroTarjeta`=:entroTarjeta WHERE `id`=:idmov";
$addAMovtemp=$conexion->prepare($addTarjetaMovtemp);
$addAMovtemp->bindParam(":entroTarjeta",$entro);
$addAMovtemp->bindParam(":idTarjetaDescuento",$descuento['id']);
$addAMovtemp->bindParam(":idmov",$selectMov['id']);
$addAMovtemp->execute();





header("location:../habitOcupada.php?id=$habitacion");



?>