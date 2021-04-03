<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires'); 
require "../conection.php";

$idArticulo=$_GET['articulo'];
$idMovtemp=$_GET['idMov'];
$ip_tablet=$_GET['ip_tablet'];
$cantidad=$_GET['cantidad'];
$estado="listo";
/* echo $_GET['idMov']."<br>";
echo $_GET['articulo']."<br>";
echo $_GET['cantidad']."<br>"; */


//SELECCIONO LA CANTIDAD DEL ARTICULO PARA ASI LUEGO RESTARLO CON LA CANTIDAD PEDIDA
$selecSQL="SELECT a.`articulo`, a.`nombre`, a.`tipoart`, a.`costo`, a.`stockmin`, a.`cantidad`, a.`descripcion`, a.`imagen`, c.`nombreCategoria`, a.`codBarra`, a.`precioVenta` FROM `articulos` = a 
JOIN categoria = c on c.idCategoria=a.categoria WHERE `articulo`=:id";
$res=$conexion->prepare($selecSQL);
$res->bindParam(":id",$idArticulo);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);
print_r($res);
if($res['nombreCategoria']=="Combo"){
    $sqlCombo="SELECT c.`idCombo`, c.`idArticuloCombo`, c.`idArticulo`,a.nombre, c.`cantidad` FROM `combos` = c 
	JOIN articulos = a on a.articulo =c.idArticulo WHERE c.`idArticuloCombo` =:idArticuloCombo";
	//ESTADO LISTO PARA QUE EL COMBO NO VAYA A COCINA
	$estado="listo";
	$combo=$conexion->prepare($sqlCombo);
	$combo->bindParam(":idArticuloCombo",$idArticulo);
	$combo->execute();
	$combo=$combo->fetchAll(PDO::FETCH_ASSOC);
	print_r($combo);
	//COSTO 0 PORQUE EL PRECIO DEL COMBO VIENE INCLUIDO EN LA HABITACION
	$costo=0;
	//INSERTO EN MI CARRITO Y LE PONGO QUE EL PEDIDO FUE ENTREGADO
	$insert=$conexion->prepare("INSERT INTO `carritos`(`habitacion`, `articulo`, `cantidad`, `precio`,`estadoProducto`,`idMovtemp`) 
	VALUES 
	(:habitacion,
	:articulo,
	:cantidad,
	:precio,
	:estadoProducto,
	:idMovtemp)");
	$insert->bindParam(":habitacion",$ip_tablet);
	$insert->bindParam(":articulo",$idArticulo);
	$insert->bindParam(":cantidad",$cantidad);
	$insert->bindParam(":precio",$costo);
	$insert->bindParam(":estadoProducto",$estado); //LISTO SIGNIFICA PEDIDO ENTREGADO
	$insert->bindParam(":idMovtemp",$idMovtemp);
	$insert->execute();



	//RECORRO EL COMBO DE PRODUCTOS PARA DESCONTARLOS EN STOCK
	foreach ($combo as $key) {
		//SELECCIONO EL UN PRODUCTO DEL ARRAY COMBO PARA TOMAR SU CANTIDAD
		$selecSQL="SELECT `cantidad` FROM `articulos` WHERE `articulo`=:id";
    	$res=$conexion->prepare($selecSQL);
    	$res->bindParam(":id",$key['idArticulo']);
    	$res->execute();
    	$res=$res->fetch(PDO::FETCH_ASSOC);
    	/* print_r($res); */

		//LE RESTO A LA CANTIDAD DEL PRODUCTO LA CANTIDAD DEL PRODUCTO QUE SE LLEVO EN EL COMBO 
    	$resto=$res['cantidad']-$key['cantidad'];
    	$descontadorDeStockSql="UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id";
    	$descontando=$conexion->prepare($descontadorDeStockSql);
    	$descontando->bindParam(":cantidad",$resto);
    	$descontando->bindParam(":id",$key['idArticulo']);
		//EJECUTO CONSULTA
    	if($descontando->execute()){
            echo "ok<br>";
            header("location:../detallesCaja.php?idMov=$idMovtemp");
    	}
	}


}else{
    
//SELECCIONO LA CANTIDAD DEL ARTICULO PARA ASI LUEGO RESTARLO CON LA CANTIDAD PEDIDA
$selecSQL="SELECT `cantidad`,precioVenta FROM `articulos` WHERE `articulo`=:id";
$res=$conexion->prepare($selecSQL);
$res->bindParam(":id",$idArticulo);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);



$selectHabitacion="SELECT * FROM `movtemp` = m
JOIN habitaciones = h on m.habitacion=h.habitacion WHERE `id` = :id";
$habitacionRes=$conexion->prepare($selectHabitacion);
$habitacionRes->bindParam(":id",$idMovtemp);
$habitacionRes->execute();
$habitacionRes=$habitacionRes->fetch(PDO::FETCH_ASSOC);

/* print_r($habitacionRes); */


$resto=$res['cantidad']-$cantidad;
$descontadorDeStockSql="UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id";
$descontando=$conexion->prepare($descontadorDeStockSql);
$descontando->bindParam(":cantidad",$resto);
$descontando->bindParam(":id",$idArticulo);

if($descontando->execute()){
    echo "ok<br>";
    $insert=$conexion->prepare("INSERT INTO `carritos`(`habitacion`, `articulo`, `cantidad`, `precio`,`estadoProducto`,`idMovtemp`) 
    VALUES 
    (:habitacion,
    :articulo,
    :cantidad,
    :precio,
    :estadoProducto,
    :idMovtemp)");
    $insert->bindParam(":habitacion",$habitacionRes['ip_tablet']);
    $insert->bindParam(":articulo",$idArticulo);
    $insert->bindParam(":cantidad",$cantidad);
    $insert->bindParam(":precio",$res['precioVenta']);
    $insert->bindParam(":estadoProducto",$estado);
    $insert->bindParam(":idMovtemp",$idMovtemp);
    $insert->execute();

    //SELECCIONO LA CAJA PARA SUMARLE EL PRODUCTO ADD A EL TOTAL
    $totalArticulo=$cantidad*$res['precioVenta'];
    $selectCaja="SELECT * FROM `cajas` WHERE idMovtemp=:id";
    $caja=$conexion->prepare($selectCaja);
    $caja->bindParam(":id",$idMovtemp);
    $caja->execute();
    $caja=$caja->fetch(PDO::FETCH_ASSOC);
    $caja['total']+=$totalArticulo;
    $updateCaja="UPDATE `cajas` SET `total`=:total WHERE `idMovtemp`=:id";
    $upCaja=$conexion->prepare($updateCaja);
    $upCaja->bindParam(":id",$idMovtemp);
    $upCaja->bindParam(":total",$caja['total']);
    $upCaja->execute();




    header("location:../detallesCaja.php?idMov=$idMovtemp");
}

}









?>