<?php
require "conection.php";

/* if ($_GET[""]==) {
$sqlEstado="UPDATE `habitaciones` SET `estado`=: WHERE ip_tablet=:ip";

$estadoHabitacion=$conexion->prepare($sqlEstado);
$estadoHabitacion->bindParam(":ip",$_SERVER['REMOTE_ADDR']);
$estadoHabitacion->execute();
$estadoHabitacion=$estadoHabitacion->fetch(PDO::FETCH_ASSOC);
    
} */














$sqlEstado="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado` FROM `habitaciones` WHERE ip_tablet=:ip";

$estadoHabitacion=$conexion->prepare($sqlEstado);
$estadoHabitacion->bindParam(":ip",$_SERVER['REMOTE_ADDR']);
$estadoHabitacion->execute();
$estadoHabitacion=$estadoHabitacion->fetch(PDO::FETCH_ASSOC);

if ($estadoHabitacion['estado']=="ocupada") {
    echo "ESTADO=O";
}
if ($estadoHabitacion['estado']=="enviar cuenta") {
    echo "ESTADO=EC";
}
if ($estadoHabitacion['estado']=="disponible"){
    echo "ESTADO=L";
}
if ($estadoHabitacion['estado']=="cobrando"){
    echo "ESTADO=CC";
}
if ($estadoHabitacion['estado']=="MP"){
    echo "ESTADO=MP";
}
if ($estadoHabitacion['estado']=="limpieza"){
    echo "ESTADO=L";
}




?>