<?php
session_start();
require "../conection.php";
$habitacion=$_GET['habitacion'];
$idCarrito=$_GET['idCarrito'];




/* SELECCIONO EL ARTICULO DEL CARRITO DE LA HABITACION O SESSION AHRE */
$selectArticuloCarrito=$conexion->prepare("SELECT * FROM `carritos` WHERE `idCarrito`=:id");
$selectArticuloCarrito->bindParam(":id",$idCarrito);
$selectArticuloCarrito->execute();
$selectArticuloCarrito=$selectArticuloCarrito->fetch(PDO::FETCH_ASSOC);







$selectArticuloArticulo=$conexion->prepare("SELECT * FROM `articulos` WHERE`articulo`=:id");
$selectArticuloArticulo->bindParam(":id",$selectArticuloCarrito['articulo']);
$selectArticuloArticulo->execute();
$selectArticuloArticulo=$selectArticuloArticulo->fetch(PDO::FETCH_ASSOC);


/* cantidad mas uno */
$cantidadMasUno=$selectArticuloCarrito['cantidad']+1;

if($selectArticuloArticulo['cantidad']>=1){

    

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
/* echo "<br>".$total2."<br>"; */
/* UPDATEO EL ARTICULO EN LA CANTIDAD */
$updateArticulo=$conexion->prepare("UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id");
$updateArticulo->bindParam(":cantidad",$cantidadRestada);
$updateArticulo->bindParam(":id",$selectArticulo['articulo']);
$updateArticulo->execute();

 
$_SESSION['editarTicket']="Sumaste un producto.";

$_SESSION['color']='success';
}else{
$_SESSION['editarTicket']="ATENCION!!! STOCK INSUFICIENTE."; 
$_SESSION['color']='danger';
}

header("location:../habitOcupada.php?id=$habitacion");



?>