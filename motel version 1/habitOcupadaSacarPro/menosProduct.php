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

/* cantidad menos uno */
$cantidadMenosUno=$selectArticuloCarrito['cantidad']-1;





if($cantidadMenosUno>=1){

    $upCantidadArticulo=$conexion->prepare("UPDATE `carritos` SET `cantidad`=:cantidad WHERE `idCarrito`=:id");
    $upCantidadArticulo->bindParam(":cantidad",$cantidadMenosUno);
    $upCantidadArticulo->bindParam(":id",$idCarrito);
    $upCantidadArticulo->execute();
    
    
    /* print_r($selectArticuloCarrito);
    echo "<br>" */;
    
    
    $selectArticulo=$conexion->prepare("SELECT * FROM `articulos` WHERE `articulo`=:id");
    $selectArticulo->bindParam(":id",$selectArticuloCarrito['articulo']);
    $selectArticulo->execute();
    $selectArticulo=$selectArticulo->fetch(PDO::FETCH_ASSOC);
    $cantidadSumada=$selectArticulo['cantidad']+1;
    /* echo "<br>".$total2."<br>"; */
    /* UPDATEO EL ARTICULO EN LA CANTIDAD */
    $updateArticulo=$conexion->prepare("UPDATE `articulos` SET `cantidad`=:cantidad WHERE `articulo`=:id");
    $updateArticulo->bindParam(":cantidad",$cantidadSumada);
    $updateArticulo->bindParam(":id",$selectArticulo['articulo']);
    $updateArticulo->execute();
    
    $_SESSION['color']='success';
    $_SESSION['editarTicket']="Restaste un producto.";


}else{
    $_SESSION['color']='danger';
    $_SESSION['editarTicket']="NO SE PUEDE RESTAR MENOS QUE 1!!!.";
}






header("location:../habitOcupada.php?id=$habitacion");



?>