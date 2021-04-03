<?php
session_start();
require "../conection.php";
/* $ip=$_GET['ip']; */
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



if($articuloSeleccionado['categoria']==15){
    //SELECCIONO LOS PRODUCTOS DEL COMBO
	$sqlCombo="SELECT c.`idCombo`, c.`idArticuloCombo`, c.`idArticulo`,a.nombre, c.`cantidad` FROM `combos` = c 
	JOIN articulos = a on a.articulo =c.idArticulo WHERE c.`idArticuloCombo` =:idArticuloCombo";
	//ESTADO LISTO PARA QUE EL COMBO NO VAYA A COCINA
	$combo=$conexion->prepare($sqlCombo);
	$combo->bindParam(":idArticuloCombo",$SelectCarritoArticulo['articulo']);
	$combo->execute();
	$combo=$combo->fetchAll(PDO::FETCH_ASSOC);
	

	//RECORRO EL COMBO DE PRODUCTOS PARA sumar EN STOCK
	foreach ($combo as $key) {
		//SELECCIONO EL UN PRODUCTO DEL ARRAY COMBO PARA TOMAR SU CANTIDAD
		$selecSQL="SELECT `cantidad` FROM `articulos` WHERE `articulo`=:id";
    	$res=$conexion->prepare($selecSQL);
    	$res->bindParam(":id",$key['idArticulo']);
    	$res->execute();
    	$res=$res->fetch(PDO::FETCH_ASSOC);
    	/* print_r($res); */

		//LE sumo A LA CANTIDAD DEL PRODUCTO LA CANTIDAD DEL PRODUCTO QUE SE LLEVO EN EL COMBO 
    	$suma=$res['cantidad']+$key['cantidad'];
    	$sumadoDeStockSql="UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id";
    	$sumado=$conexion->prepare($sumadoDeStockSql);
    	$sumado->bindParam(":cantidad",$suma);
    	$sumado->bindParam(":id",$key['idArticulo']);
		//EJECUTO CONSULTA
    	if($sumado->execute()){
        	echo "ok<br>";
    	}
	}
    $deleteCarrito="DELETE FROM `carritos` WHERE `idCarrito`=:id";
    $delete=$conexion->prepare($deleteCarrito);
    $delete->bindParam(":id",$id);
    $delete->execute();

}else{
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
}



$_SESSION['editarTicket']="Eliminaste un producto.";
$_SESSION['color']='danger';
header("location: ../habitOcupada.php?id=$habitacion");


?>