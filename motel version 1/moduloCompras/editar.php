<?php 
require "../conection.php";
$idArticulo=$_GET['articulo'];
$cantidadAnterior=$_GET['cantidadAnterior'];
$cantidad = $_GET['cantidad'];
$id=$_GET['id'];
$idEntrada=$_GET['idEntrada'];
$articuloOriginal=$_GET['articuloOriginal'];

print_r($_GET);

/* SI EL ARTICULO ES EL MISMO SOLO ACTUALIZO LA CANTIDAD */
if($articuloOriginal==$idArticulo){

    $selectArticuloEntrada="UPDATE `articulos` SET `cantidad`=(cantidad-:cantidadAnterior)+:cantidad WHERE articulo=:id";
    $articuloEntrada=$conexion->prepare($selectArticuloEntrada);
    $articuloEntrada->bindParam(":id",$articuloOriginal);
    $articuloEntrada->bindParam(":cantidadAnterior",$cantidadAnterior);
    $articuloEntrada->bindParam(":cantidad",$cantidad);
    $articuloEntrada->execute();


    $editarEntradaArticuloSql="UPDATE `facturaentrada` 
                                SET `cantidad`=:cantidad
                                WHERE `id`=:id";
    $edit=$conexion->prepare($editarEntradaArticuloSql);
    $edit->bindParam(":cantidad",$cantidad);
    $edit->bindParam(":id",$id);
    $edit->execute();

    header("location:detalleCompra.php?idEntrada=$idEntrada");

}else{/* DE LO CONTRARIO RESTO LA CANTIDAD AL PRODUCTO ANTERIOR Y LE SUMO AL NUEVO SELECCIONADO */
    $selectArticuloEntrada="UPDATE `articulos` SET `cantidad`=(cantidad-:cantidadAnterior) WHERE articulo=:id";
    $articuloEntrada=$conexion->prepare($selectArticuloEntrada);
    $articuloEntrada->bindParam(":id",$articuloOriginal);
    $articuloEntrada->bindParam(":cantidadAnterior",$cantidadAnterior);
    $articuloEntrada->execute();

    $sumoSql="UPDATE `articulos` SET `cantidad`=(cantidad+:cantidadAnterior) WHERE articulo=:id";
    $sumaCantidadNewArticulo=$conexion->prepare($sumoSql);
    $sumaCantidadNewArticulo->bindParam(":id",$idArticulo);
    $sumaCantidadNewArticulo->bindParam(":cantidadAnterior",$cantidadAnterior);
    $sumaCantidadNewArticulo->execute();

    $cambioEntradaSql="UPDATE `facturaentrada` 
                        SET `idArticulo`=:idArticulo
                        WHERE `id`=:id";
    $cambioArticulo=$conexion->prepare($cambioEntradaSql);
    $cambioArticulo->bindParam(":idArticulo",$idArticulo);
    $cambioArticulo->bindParam(":id",$id);
    $cambioArticulo->execute();

    header("location:detalleCompra.php?idEntrada=$idEntrada");
}



?>