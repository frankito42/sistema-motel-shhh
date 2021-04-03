<?php
session_start();
require "../conection.php";
$habitacion=$_GET['id'];
$sqlDelete="DELETE FROM `habitaciones` WHERE habitacion=?";
$borrar=$conexion->prepare($sqlDelete);
$borrar->execute(array($habitacion));

$_SESSION['message']="Se elimino una habitacion";
header("location:../index.php")

?>