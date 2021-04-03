<?php
require "../conection.php";

$idCombo=$_GET['combo'];
$articulo=$_GET['articulo'];
$cantidad=$_GET['cantidad'];


$insertSql="INSERT INTO `combos`(`idArticuloCombo`, `idArticulo`, `cantidad`) 
            VALUES (:idcombo,
                    :articulo,
                    :cantidad)";

$insert=$conexion->prepare($insertSql);

$insert->bindParam(":idcombo",$idCombo);
$insert->bindParam(":articulo",$articulo);
$insert->bindParam(":cantidad",$cantidad);

$insert->execute();


header("location: detalleCombo.php?idCombo=$idCombo");

?>