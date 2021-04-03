<?php
session_start();
require "../conection.php";
$cocina="cocina";
$pendiente="pendiente";
$ip=$_GET["ip"];
$productos=$_SESSION['productos'];


$movSql="SELECT * FROM `habitaciones` = h 
INNER JOIN movtemp = m on h.`habitacion`=m.`habitacion` AND m.id2=0 AND h.`ip_tablet`=:ip_tablet";
$mov=$conexion->prepare($movSql);
$mov->bindParam(":ip_tablet",$_GET['ip']);
$mov->execute();
$mov=$mov->fetch(PDO::FETCH_ASSOC);



/* print_r($productos); */

foreach ($productos as $key) {
    $selecSQL="SELECT `cantidad` FROM `articulos` WHERE `articulo`=:id";
    $res=$conexion->prepare($selecSQL);
    $res->bindParam(":id",$key['idProducto']);
    $res->execute();
    $res=$res->fetch(PDO::FETCH_ASSOC);
    /* print_r($res); */
 

    $resto=$res['cantidad']-$key['cantidad'];
    $descontadorDeStockSql="UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id";
    $descontando=$conexion->prepare($descontadorDeStockSql);
    $descontando->bindParam(":cantidad",$resto);
    $descontando->bindParam(":id",$key['idProducto']);
    
    if($descontando->execute()){
        echo "ok<br>";
    }

/*     $update="UPDATE `carritos` SET `estadoProducto`=:cocina WHERE `habitacion`=:habitacion AND `estadoProducto`=:pendiente AND idMovtemp=:idMovtemp "; */
    $update="UPDATE `carritos` SET `estadoProducto`=:cocina WHERE `habitacion`=:habitacion AND `idCarrito`=:idCarrito ";

    $upp=$conexion->prepare($update);
    if($key['categoria']=="12"){
        $sex="sex";
        $upp->bindParam(":cocina",$sex);
    }else if($key['categoria']=="16"){
        $listo="listo";
        $upp->bindParam(":cocina",$listo);
    }else{
        $upp->bindParam(":cocina",$cocina);
    }
    $upp->bindParam(":habitacion",$ip);
    $upp->bindParam(":idCarrito",$key['idCarrito']);
    
    if($upp->execute()){
        echo "ok";
    }



}



/* $_SESSION['pedidoCarrito']="claroQueSi"; */
/* VACIO LA VARIABLE QUE HABRE EL MODAL EN CATEGORIAS COMIDAS */
/* unset($_SESSION["addCart"]); */

print "<script>window.history.back()</script>"; 
?>