<?php
/*
* Agrega el producto
*/
//INICIO SESION
session_start();
require "conection.php";
//VARIABLES DEL ARTICULO O PRODUCTO
$articulo=$_GET['articulo'];
$cantidad=$_GET['cantidad'];
$estado="pendiente";
$ip=$_GET["ip"];
$idMovtemp=$_GET["idMovtemp"];

if (isset($_GET['combo'])) {//SI DETECTA QUE EL PRODUCTO ES UN COMBO AÑADE AL CARRITO Y DESCUENTA EL COMBO DE PRODUCTOS

	//SELECCIONO LOS PRODUCTOS DEL COMBO
	$sqlCombo="SELECT c.`idCombo`, c.`idArticuloCombo`, c.`idArticulo`,a.nombre, c.`cantidad` FROM `combos` = c 
	JOIN articulos = a on a.articulo =c.idArticulo WHERE c.`idArticuloCombo` =:idArticuloCombo";
	//ESTADO LISTO PARA QUE EL COMBO NO VAYA A COCINA
	$estado="listo";
	$combo=$conexion->prepare($sqlCombo);
	$combo->bindParam(":idArticuloCombo",$articulo);
	$combo->execute();
	$combo=$combo->fetchAll(PDO::FETCH_ASSOC);
	/* print_r($combo); */
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
	$insert->bindParam(":habitacion",$ip);
	$insert->bindParam(":articulo",$articulo);
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
    	}
	}

	//CARGO UNA VARIABLE DE SESSION PARA UN AVISO
	$_SESSION['addCart']=1;

	//VUELVO A LA PESTAÑA ANTERIOR
	print "<script>window.history.back()</script>"; 




}else{//ELSE SI NO ES UN COMBO VA DIRECTO A LISTO EN CARRITO

 






$selectArticulo=$conexion->query("SELECT `articulo`, `nombre`, `tipoart`, `costo`, `stockmin`, `cantidad`, `descripcion`, `imagen`,precioVenta,categoria FROM `articulos` WHERE `articulo`=".$articulo."");
$selectArticulo=$selectArticulo->fetch();

$insert=$conexion->prepare("INSERT INTO `carritos`(`habitacion`, `articulo`,`nombreDelArticulo`, `cantidad`, `precio`,`estadoProducto`,`idMovtemp`) 
VALUES 
(:habitacion,
:articulo,
:nombreDelArticulo,
:cantidad,
:precio,
:estadoProducto,
:idMovtemp)");
$insert->bindParam(":habitacion",$ip);
$insert->bindParam(":articulo",$articulo);
$insert->bindParam(":nombreDelArticulo",$selectArticulo['nombre']);
$insert->bindParam(":cantidad",$cantidad);
$insert->bindParam(":precio",$selectArticulo['precioVenta']);
$insert->bindParam(":estadoProducto",$estado);
$insert->bindParam(":idMovtemp",$idMovtemp);
$insert->execute();

/* $idCarrito=$conexion->lastInsertId();


$resto=$selectArticulo['cantidad']-$cantidad;
$descontadorDeStockSql="UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id";
$descontando=$conexion->prepare($descontadorDeStockSql);
$descontando->bindParam(":cantidad",$resto);
$descontando->bindParam(":id",$articulo);

if($descontando->execute()){
	echo "ok<br>";
} */

/*     $update="UPDATE `carritos` SET `estadoProducto`=:cocina WHERE `habitacion`=:habitacion AND `estadoProducto`=:pendiente AND idMovtemp=:idMovtemp "; */
/* $update="UPDATE `carritos` SET `estadoProducto`=:cocina WHERE `habitacion`=:habitacion AND `idCarrito`=:idCarrito ";

$upp=$conexion->prepare($update);
if($selectArticulo['categoria']=="12"){
	$sex="sex";
	$upp->bindParam(":cocina",$sex);
}else{
	$upp->bindParam(":cocina",$listo);
}
$upp->bindParam(":habitacion",$ip);
$upp->bindParam(":idCarrito",$idCarrito);

if($upp->execute()){
	echo "ok";
} */





$_SESSION['addCart']=1;




print "<script>window.history.back()</script>"; 
}






	
 

?>

