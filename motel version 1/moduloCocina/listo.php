<?php
session_start();
require "../conection.php";

print_r($_SESSION['arrayDeArticulosDeCocina']);

foreach ($_SESSION['arrayDeArticulosDeCocina'] as $key) {
    if($key['categoria']!="12"){
        $estado="listo";
        $sql="UPDATE `carritos` SET `estadoProducto`=:estado WHERE `idCarrito`= :idCarrito";
        $update=$conexion->prepare($sql);
        $update->bindParam(":estado",$estado);
        $update->bindParam(":idCarrito",$key['idCarrito']);
        $update->execute();
    }
}

                $vacio="";
                $vacioCocinaEnHabitacion="UPDATE `habitaciones` SET `cocina`=:si WHERE `ip_tablet`=:ip";
                $cocina=$conexion->prepare($vacioCocinaEnHabitacion);
                $cocina->bindParam(":si",$vacio);
                $cocina->bindParam(":ip",$_GET['ip']);
                $cocina->execute();

$_SESSION['mensaje']=$_GET['habitacion'];
header("location:../cocina.php");
?>