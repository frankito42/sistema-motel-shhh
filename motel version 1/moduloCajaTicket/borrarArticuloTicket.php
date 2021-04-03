<?php
session_start();
require "../conection.php";
$idCarrito=$_GET['idCarrito'];

/* SELECCIONO EL ARTICULO DEL CARRITO DE LA HABITACION O SESSION AHRE */
$selectArticuloCarrito=$conexion->prepare("SELECT * FROM `carritos` WHERE `idCarrito`=:id");
$selectArticuloCarrito->bindParam(":id",$idCarrito);
$selectArticuloCarrito->execute();
$selectArticuloCarrito=$selectArticuloCarrito->fetch(PDO::FETCH_ASSOC);

/* print_r($selectArticuloCarrito);
echo "<br>" */;

$deletaCarritoArticulo=$conexion->prepare("DELETE FROM `carritos` WHERE `idCarrito`=:id");
$deletaCarritoArticulo->bindParam(":id",$idCarrito);
$deletaCarritoArticulo->execute();


$selectArticulo=$conexion->prepare("SELECT * FROM `articulos` WHERE `articulo`=:id");
$selectArticulo->bindParam(":id",$selectArticuloCarrito['articulo']);
$selectArticulo->execute();
$selectArticulo=$selectArticulo->fetch(PDO::FETCH_ASSOC);




if ($selectArticulo['categoria']==15) {
    //SELECCIONO LOS PRODUCTOS DEL COMBO
	$sqlCombo="SELECT c.`idCombo`, c.`idArticuloCombo`, c.`idArticulo`,a.nombre, c.`cantidad` FROM `combos` = c 
	JOIN articulos = a on a.articulo =c.idArticulo WHERE c.`idArticuloCombo` =:idArticuloCombo";
	//ESTADO LISTO PARA QUE EL COMBO NO VAYA A COCINA
	$combo=$conexion->prepare($sqlCombo);
	$combo->bindParam(":idArticuloCombo",$selectArticulo['articulo']);
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

}else{

    $cantidadSumada=$selectArticulo['cantidad']+$selectArticuloCarrito['cantidad'];
    $total2=$selectArticuloCarrito['cantidad']*$selectArticulo['precioVenta'];
    /* echo "<br>".$total2."<br>"; */
    /* UPDATEO EL ARTICULO EN LA CANTIDAD */
    $updateArticulo=$conexion->prepare("UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id");
    $updateArticulo->bindParam(":cantidad",$cantidadSumada);
    $updateArticulo->bindParam(":id",$selectArticulo['articulo']);
    $updateArticulo->execute();
    
    /* print_r($selectArticulo);
    echo "<br>"; */
    $selectCaja=$conexion->prepare("SELECT * FROM `cajas` WHERE `idMovtemp`=:id");
    $selectCaja->bindParam(":id",$selectArticuloCarrito['idMovtemp']);
    $selectCaja->execute();
    $selectCaja=$selectCaja->fetch(PDO::FETCH_ASSOC);
    /* RESTO EL TOC */
    $restaCaja=$selectCaja['total']-$total2;
    /* UPDATEO CAJA */
    $updateCaja=$conexion->prepare("UPDATE `cajas` SET `total`=:total WHERE `idCaja`=:id");
    $updateCaja->bindParam(":total",$restaCaja);
    $updateCaja->bindParam(":id",$selectCaja['idCaja']);
    $updateCaja->execute();

}




/* print_r($selectCaja);
echo "<br>".$restaCaja; */
$idMovTemp=$selectArticuloCarrito['idMovtemp'];
header("location:../detallesCaja.php?idMov=$idMovTemp");
?>