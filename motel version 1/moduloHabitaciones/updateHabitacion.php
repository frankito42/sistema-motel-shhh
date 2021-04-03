<?php
session_start();
require "../conection.php";
$dirip=$_POST['dirip'];
$letra=$_POST['letra'];
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$iptablet=$_POST['iptablet'];
$habitacion=$_GET['id'];
$sqlUpdate="UPDATE `habitaciones` SET   `dirip`=?,
                                        `letra`=?,
                                        `nombre`=?,
                                        `descripcion`=?,
                                        `ip_tablet`=?
                                  WHERE habitacion=?";
$update=$conexion->prepare($sqlUpdate);
$update->execute(array($dirip,$letra,$nombre,$descripcion,$iptablet,$habitacion));

$_SESSION['message']="Se edito correctamente";

header("location:../detalleHabitacion.php?id=$habitacion")

?>