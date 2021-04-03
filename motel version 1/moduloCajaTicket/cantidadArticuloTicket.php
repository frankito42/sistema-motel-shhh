<?php
session_start();
require "../conection.php";
$idCarrito=$_GET['idCarrito'];


/* SELECCIONO EL ARTICULO DEL CARRITO DE LA HABITACION O SESSION AHRE */
$selectArticuloCarrito=$conexion->prepare("SELECT * FROM `carritos` WHERE `idCarrito`=:id");
$selectArticuloCarrito->bindParam(":id",$idCarrito);
$selectArticuloCarrito->execute();
$selectArticuloCarrito=$selectArticuloCarrito->fetch(PDO::FETCH_ASSOC);
/* cantidad mas uno */
$cantidadMasUno=$selectArticuloCarrito['cantidad']+1;

$upCantidadArticulo=$conexion->prepare("UPDATE `carritos` SET `cantidad`=:cantidad WHERE `idCarrito`=:id");
$upCantidadArticulo->bindParam(":cantidad",$cantidadMasUno);
$upCantidadArticulo->bindParam(":id",$idCarrito);
$upCantidadArticulo->execute();


/* print_r($selectArticuloCarrito);
echo "<br>" */;


$selectArticulo=$conexion->prepare("SELECT * FROM `articulos` WHERE `articulo`=:id");
$selectArticulo->bindParam(":id",$selectArticuloCarrito['articulo']);
$selectArticulo->execute();
$selectArticulo=$selectArticulo->fetch(PDO::FETCH_ASSOC);
$cantidadRestada=$selectArticulo['cantidad']-1;
$total2=1*$selectArticulo['precioVenta'];
/* echo "<br>".$total2."<br>"; */
/* UPDATEO EL ARTICULO EN LA CANTIDAD */
$updateArticulo=$conexion->prepare("UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id");
$updateArticulo->bindParam(":cantidad",$cantidadRestada);
$updateArticulo->bindParam(":id",$selectArticulo['articulo']);
$updateArticulo->execute();

/* print_r($selectArticulo);
echo "<br>"; */
$selectCaja=$conexion->prepare("SELECT * FROM `cajas` WHERE `idMovtemp`=:id");
$selectCaja->bindParam(":id",$selectArticuloCarrito['idMovtemp']);
$selectCaja->execute();
$selectCaja=$selectCaja->fetch(PDO::FETCH_ASSOC);
/* RESTO EL TOC */
$restaCaja=$selectCaja['total']+$total2;
/* UPDATEO CAJA */
$updateCaja=$conexion->prepare("UPDATE `cajas` SET `total`=:total WHERE `idCaja`=:id");
$updateCaja->bindParam(":total",$restaCaja);
$updateCaja->bindParam(":id",$selectCaja['idCaja']);
$updateCaja->execute();

/* print_r($selectCaja);
echo "<br>".$restaCaja; */
$idMovTemp=$selectArticuloCarrito['idMovtemp'];
header("location:../detallesCaja.php?idMov=$idMovTemp");



?>