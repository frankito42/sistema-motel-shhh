<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
require "../conection.php";
require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

$ip=$_GET['ip'];



if ($_GET['comando']=="sex") {
	$estado="sex";
	$sql="SELECT c.`idCarrito`,c.`habitacion`,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos = c
	INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:ip and c.estadoProducto=:estado";
	$res=$conexion->prepare($sql);
	$res->bindParam(":ip",$ip);
	$res->bindParam(":estado",$estado);
	$res->execute();
	$res=$res->fetchAll(PDO::FETCH_OBJ);
	$redirecion="sex";
	
}else if($_GET['comando']=='articulosCompletos'){
	$id=$_GET['movtemp'];
	$sql="SELECT c.`idCarrito`,c.`habitacion`,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos = c
	INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:ip and idMovtemp=:idmov";
	$res=$conexion->prepare($sql);
	$res->bindParam(":ip",$ip);
	$res->bindParam(":idmov",$id);
	$res->execute();
	$res=$res->fetchAll(PDO::FETCH_OBJ);
	$redirecion="total";
}else {
	$estado="cocina";
	$sql="SELECT c.`idCarrito`,c.`habitacion`,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos = c
	INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:ip and c.estadoProducto=:estado";
	$res=$conexion->prepare($sql);
	$res->bindParam(":ip",$ip);
	$res->bindParam(":estado",$estado);
	$res->execute();
	$res=$res->fetchAll(PDO::FETCH_OBJ);
	$redirecion="cocina";
}


/*
Este ejemplo imprime un hola mundo en una impresora de tickets
en Windows.
La impresora debe estar instalada como genérica y debe estar
compartida
 */

/*
Conectamos con la impresora
 */

/*
Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
escribe el nombre de la tuya. Recuerda que debes compartirla
desde el panel de control
 */




 
/*
	Vamos a simular algunos productos. Estos
	podemos recuperarlos desde $_POST o desde
	cualquier entrada de datos. Yo los declararé
	aquí mismo
*/
 

/*
	Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/
 
$nombre_impresora = "tmu admin"; 
 
 
$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
 
 
/*
	Vamos a imprimir un logotipo
	opcional. Recuerda que esto
	no funcionará en todas las
	impresoras
 
	Pequeña nota: Es recomendable que la imagen no sea
	transparente (aunque sea png hay que quitar el canal alfa)
	y que tenga una resolución baja. En mi caso
	la imagen que uso es de 250 x 250
*/
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("user: ".$_SESSION['user']['user']. "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Nro ".$id. "\n");
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);
 

 
/*
	Ahora vamos a imprimir un encabezado
*/
 
$printer->text("Motel SHHH" . "\n");
$printer->text($_GET['habitacion'] . "\n");
#La fecha también
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->text("----------------------------------------\n");
 
 
/*
	Ahora vamos a imprimir los
	productos
*/
 
# Para mostrar el total
$total = 0;
foreach ($res as $producto) {
	$total += $producto->cantidad * $producto->precio;
 
	/*Alinear a la izquierda para la cantidad y el nombre*/
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($producto->nombre." ".$producto->cantidad."x".$producto->precio. "\n");
 
    /*Y a la derecha para el importe*/
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text(' $' . $producto->precio*$producto->cantidad . "\n");
}
 
/*
	Terminamos de imprimir
	los productos, ahora va el total
*/
$printer->text("----------------------------------------\n");
if ($_GET['comando']=="articulosCompletos") {
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Costo ".$_GET['habitacion']."\n");
 
    /*Y a la derecha para el importe*/
	$printer->setJustification(Printer::JUSTIFY_RIGHT);
	$total=$total+$_GET['totalHabit'];
    $printer->text(' $' . $_GET['totalHabit'] . "\n");
	$printer->text("----------------------------------------\n");
	function title(Printer $printer, $text){
    	$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    	$printer -> text($text);
    	$printer -> selectPrintMode(); // Reset
	}
	
	/* $printer->text("TOTAL: $". $total ."\n"); */
	title($printer, "TOTAL: $". $total ."\n");
	

	$printer->text("---------------------------------\n");
}else{
	$printer->text("TOTAL: $<h1>". $total ."</h1>\n");
}
 
 
/*
	Podemos poner también un pie de página
*/
$printer->text("Muchas gracias por su visita\nMotel SHHH");
 
 
 
/*Alimentamos el papel 3 veces*/
$printer->feed(3);
 
/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
$printer->cut();
 
/*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
$printer->pulse();

 
/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();
$nombre=$_GET['habitacion'];
if ($redirecion=="cocina") {
	header("location:../cocina.php?ip=$ip&nombre=$nombre");
}
if ($redirecion=="sex") {
	header("location:../sexHotPanel.php?ip=$ip&nombre=$nombre");
}
if ($redirecion=="total") {
	header("location:../habitOcupada.php?id=".$_GET['idHabitacion']);
}