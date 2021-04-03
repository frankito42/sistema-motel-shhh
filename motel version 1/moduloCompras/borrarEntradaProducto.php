<?php 
require "../conection.php";

$cantidadADescontar=$_GET['cantidad'];
$idArticulo=$_GET['idArticulo'];
$idFacturaArticulo=$_GET['id'];
/* print_r($_POST); */

/* print_r($_GET); */ 


$selectArticuloEntrada="UPDATE `articulos` SET `cantidad`=(cantidad-:cantidadADescontar) WHERE articulo=:id";
$articuloEntrada=$conexion->prepare($selectArticuloEntrada);
$articuloEntrada->bindParam(":cantidadADescontar",$cantidadADescontar);
$articuloEntrada->bindParam(":id",$idArticulo);
$articuloEntrada->execute();


$sqlDeleteArticuloEntrada="DELETE FROM `facturaentrada` WHERE `id`=:id";
$delete=$conexion->prepare($sqlDeleteArticuloEntrada);
$delete->bindParam(":id",$idFacturaArticulo);

if($delete->execute()){
    echo json_encode("ok");
}

/* header("location:detalleCompra.php?idEntrada=$idEntrada"); */

?>