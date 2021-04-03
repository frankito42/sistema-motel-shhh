<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires'); 
require "conection.php";

$selec="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado` FROM `habitaciones` WHERE habitacion=:id";
$habitacion=$conexion->prepare($selec);
$habitacion->bindParam(":id",$_GET['id']);
$habitacion->execute();
$habitacion=$habitacion->fetch(PDO::FETCH_ASSOC);

echo json_encode($habitacion);
?>