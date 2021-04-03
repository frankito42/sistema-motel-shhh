<?php
require "../conection.php";

$nombre=$_GET['nombre'];
/* //////////////////////////////////// */
$tipoart=1;
$costo=0;
$stockmin=10;
$cantidad=1000;
$categoria=15;

$insertSql="INSERT INTO `articulos`(`nombre`, `tipoart`, `costo`, `stockmin`, `cantidad`, `categoria`) 
            VALUES (:nombre,
                    :tipoart,
                    :costo,
                    :stockmin,
                    :cantidad,
                    :categoria)";

$insert=$conexion->prepare($insertSql);

$insert->bindParam(":nombre",$nombre);
$insert->bindParam(":tipoart",$tipoart);
$insert->bindParam(":costo",$costo);
$insert->bindParam(":stockmin",$stockmin);
$insert->bindParam(":cantidad",$cantidad);
$insert->bindParam(":categoria",$categoria);

$insert->execute();


header("location: ../combos.php");

?>