<?php 
include "conection.php";

$id=$_GET['id'];
$comando=$_GET['comando'];

if($comando=="menos"&&$_GET['cantidad']>1){
    $cantidad=$_GET['cantidad']-1;
    
}else if($comando=="mas"){
    $cantidad=$_GET['cantidad']+1;
    
    
}else{
    $cantidad=$_GET['cantidad'];
}



$update=$conexion->prepare("UPDATE `carritos`
                            SET 
                            `cantidad`=?
                            WHERE `idCarrito`=?");
$update->execute(array($cantidad,$id));

header("location:../cart.php"); 

?>