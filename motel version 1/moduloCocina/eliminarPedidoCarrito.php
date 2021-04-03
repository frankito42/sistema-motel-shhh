<?php
require "../conection.php";
$ip=$_GET['ip'];
$habitacion=$_GET['habitacion'];
$id=$_GET['idCarrito'];

/* echo $ip." ".$habitacion." ".$id; */

$sqlSelectCarritoArticulo="SELECT `idCarrito`, `habitacion`, `articulo`, `cantidad`, `precio`, `estadoProducto`, `idMovtemp` FROM `carritos` WHERE `idCarrito`=:id";
$SelectCarritoArticulo=$conexion->prepare($sqlSelectCarritoArticulo);
$SelectCarritoArticulo->bindParam(":id",$id);
$SelectCarritoArticulo->execute();
$SelectCarritoArticulo=$SelectCarritoArticulo->fetch(PDO::FETCH_ASSOC);


$sqlSelectArticuloStock="SELECT * FROM `articulos` WHERE `articulo`=:id";
$articuloSeleccionado=$conexion->prepare($sqlSelectArticuloStock);
$articuloSeleccionado->bindParam(":id",$SelectCarritoArticulo['articulo']);
$articuloSeleccionado->execute();
$articuloSeleccionado=$articuloSeleccionado->fetch(PDO::FETCH_ASSOC);


$sumar=$SelectCarritoArticulo['cantidad']+$articuloSeleccionado['cantidad'];
$updateStockArticuloSql="UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id";
$updateStock=$conexion->prepare($updateStockArticuloSql);
$updateStock->bindParam(":cantidad",$sumar);
$updateStock->bindParam(":id",$SelectCarritoArticulo['articulo']);
$updateStock->execute();




$deleteCarrito="DELETE FROM `carritos` WHERE `idCarrito`=:id";
$delete=$conexion->prepare($deleteCarrito);
$delete->bindParam(":id",$id);
$delete->execute();

header("location: ../cocina.php");


?>