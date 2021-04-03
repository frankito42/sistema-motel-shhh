<?php
session_start();
require "../conection.php";
$sql="INSERT INTO `habitaciones`(`dirip`,
                                `letra`,
                                `nombre`, 
                                `descripcion`, 
                                `costo`, 
                                `ip_tablet`, 
                                `estado`) VALUES 
                                                (?,
                                                 ?,
                                                 ?,
                                                 ?,
                                                 ?,
                                                 ?,
                                                 ?)";

$insertarHabitacion=$conexion->prepare($sql);
$insertarHabitacion->execute(array($_POST['dirip'],
                                   $_POST['letra'],
                                   $_POST['nombre'],
                                   $_POST['descripcion'],
                                   $_POST['costo'],
                                   $_POST['iptablet'],
                                   $_POST['estado']));

$_SESSION['message']="Se añadio la habitacion ".$_POST['nombre'];
header("location:../index.php");






?>