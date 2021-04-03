<?php
session_start();
require "../conection.php";

print_r($_SESSION['arrayDeArticulosDeCocina']);

foreach ($_SESSION['arrayDeArticulosDeCocina'] as $key) {
    if($key['categoria']=="12"){
        $estado="listo";
        $sql="UPDATE `carritos` SET `estadoProducto`=:estado WHERE `idCarrito`= :idCarrito";
        $update=$conexion->prepare($sql);
        $update->bindParam(":estado",$estado);
        $update->bindParam(":idCarrito",$key['idCarrito']);
        $update->execute();
    }
}

                $vacio="";
                $vacioCocinaEnHabitacion="UPDATE `habitaciones` SET `sex`=:si WHERE `ip_tablet`=:ip";
                $sex=$conexion->prepare($vacioCocinaEnHabitacion);
                $sex->bindParam(":si",$vacio);
                $sex->bindParam(":ip",$_GET['ip']);
                $sex->execute();


$_SESSION['mensaje']=$_GET['habitacion'];
header("location:../sexHotPanel.php");
?>