<?php 
include "conection.php";

$id=$_GET['id'];
$comando=$_GET['comando'];



$selectArticuloCarrito=$conexion->prepare("SELECT * FROM `carritos` WHERE `idCarrito`=:id");
$selectArticuloCarrito->bindParam(":id",$id);
$selectArticuloCarrito->execute();
$selectArticuloCarrito=$selectArticuloCarrito->fetch(PDO::FETCH_ASSOC);


$selectArticuloArticulo=$conexion->prepare("SELECT * FROM `articulos` WHERE`articulo`=:id");
$selectArticuloArticulo->bindParam(":id",$selectArticuloCarrito['articulo']);
$selectArticuloArticulo->execute();
$selectArticuloArticulo=$selectArticuloArticulo->fetch(PDO::FETCH_ASSOC);


if($comando=="menos"&&$_GET['cantidad']>1){
    if($_GET['cantidad']>=1){
    $cantidad=$_GET['cantidad']-1;
    }
    /* echo "a"; */
}else if($comando=="mas"){
    if($_GET['cantidad']<$selectArticuloArticulo['cantidad']){
    $cantidad=$_GET['cantidad']+1;
    }else{
    $cantidad=$_GET['cantidad'];
    }
    /* echo "b"; */
}else{
    $cantidad=$_GET['cantidad'];
}



$update=$conexion->prepare("UPDATE `carritos`
                            SET 
                            `cantidad`=?
                            WHERE `idCarrito`=?");
$update->execute(array($cantidad,$id));

/* header("location:../cart.php");  */

print "<script>window.history.back()</script>"; 

?>