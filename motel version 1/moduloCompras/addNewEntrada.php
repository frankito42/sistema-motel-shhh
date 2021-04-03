<?php
require "../conection.php";
$factura=$_POST['factura'];
/* $provedor=$_POST['provedor']; */
$observacion=$_POST['observacion'];


$idArticulo=$_POST['idArticulo'];
$costo=$_POST['costo'];
$cantidad=$_POST['cantidad'];
$precioVenta=$_POST['precioventa'];

echo $factura."<br>";
/* echo $provedor."<br>"; */
echo $observacion."<br>";

print_r($idArticulo);
echo "<br>";
print_r($costo);
echo "<br>";
print_r($cantidad);

$fecha=date('Y-m-d');


$entradaSql="INSERT INTO `entrada`(`fecha`, `nFactura`, `observacion`) VALUES 
                                                                    (:fecha,
                                                                     :nFactura,
                                                                     :observacion)";
$entrada=$conexion->prepare($entradaSql);
$entrada->bindParam(":fecha",$fecha);
$entrada->bindParam(":nFactura",$factura);
$entrada->bindParam(":observacion",$observacion);
$entrada->execute();
/* el id insertado en la entrada */
$elIdEntrada=$conexion->lastInsertId();

for ($i=0; $i < count($idArticulo) ; $i++) { 
    $sqlSelectArticulo="SELECT * FROM `articulos` WHERE `articulo`=:id";
    $sellArticulo=$conexion->prepare($sqlSelectArticulo);
    $sellArticulo->bindParam(":id",$idArticulo[$i]);
    $sellArticulo->execute();
    $sellArticulo=$sellArticulo->fetch(PDO::FETCH_ASSOC);

    $sumaStock=$sellArticulo['cantidad']+$cantidad[$i];

        $sqlUpdateStock="UPDATE `articulos` SET `costo`=:costo, `cantidad`=:cantidad, `precioVenta`=:precioVenta WHERE `articulo`=:id";
        $upCantidad=$conexion->prepare($sqlUpdateStock);
        $upCantidad->bindParam(":id",$idArticulo[$i]);
        $upCantidad->bindParam(":precioVenta",$precioVenta[$i]);
        $upCantidad->bindParam(":cantidad",$sumaStock);
        $upCantidad->bindParam(":costo",$costo[$i]);
        $upCantidad->execute();
    

    $sql="INSERT INTO `facturaentrada`(`idEntrada`, `idArticulo`, `cantidad`, `fecha`, `costo`) 
            VALUES 
            (:idEntrada,
             :idArticulo,
             :cantidad,
             :fecha,
             :costo)";
    $facturaentrada=$conexion->prepare($sql);
    $facturaentrada->bindParam(":idEntrada",$elIdEntrada);
    $facturaentrada->bindParam(":idArticulo",$idArticulo[$i]);
    $facturaentrada->bindParam(":cantidad",$cantidad[$i]);
    $facturaentrada->bindParam(":costo",$costo[$i]);
    $facturaentrada->bindParam(":fecha",$fecha);
    $facturaentrada->execute();
}


header("location:../compras.php");


?>