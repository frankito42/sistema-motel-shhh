<?php
/*
* Agrega el producto
*/
session_start();
require "conection.php";
$articulo=$_GET['articulo'];
$cantidad=$_GET['cantidad'];
$pendiente="pendiente";


$sqlMovtemp="SELECT h.`habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado`,m.fechaActS1,m.horaActS1,m.id FROM `habitaciones`= h  JOIN movtemp = m on h.habitacion =m.habitacion and m.id2!=m.id WHERE h.ip_tablet=:ip_tablet";

$movtemp=$conexion->prepare($sqlMovtemp);
$movtemp->bindParam(":ip_tablet",$_SERVER['REMOTE_ADDR']);
$movtemp->execute();
$movtemp=$movtemp->fetch(PDO::FETCH_ASSOC);


$select=$conexion->query("SELECT `articulo`, `nombre`, `tipoart`, `costo`, `stockmin`, `cantidad`, `descripcion`, `imagen`, `precioVenta` FROM `articulos` WHERE `articulo`=".$articulo."");

$select=$select->fetch();



$insert=$conexion->prepare("INSERT INTO `carritos`(`habitacion`, `articulo`, `nombreDelArticulo`, `cantidad`, `precio`,`estadoProducto`,idMovtemp) 
VALUES 
(:habitacion,
:articulo,
:nombreDelArticulo,
:cantidad,
:precio,
:estadoProducto,
:idMovtemp)");
$insert->bindParam(":habitacion",$_SERVER['REMOTE_ADDR']);
$insert->bindParam(":articulo",$articulo);
$insert->bindParam(":nombreDelArticulo",$select['nombre']);
$insert->bindParam(":cantidad",$cantidad);
$insert->bindParam(":precio",$select['precioVenta']);
$insert->bindParam(":estadoProducto",$pendiente);
$insert->bindParam(":idMovtemp",$movtemp['id']);
$insert->execute();

$_SESSION['addCart']=1;



	 print "<script>window.history.back()</script>"; 
	
 

?>

