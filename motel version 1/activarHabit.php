<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
session_start();
require "conection.php";
 

if (isset($_GET['id'])) {
    
        $id=$_GET['id'];
        
        $sql="insert into movtemp set habitacion='".$id."', fechaActS1='".date('Y-m-d')."',S1='SI', horaActS1='".date('H:i:s')."',S2='SI',S3='SI'";
        $upp=$conexion->prepare($sql);
        $upp->execute();
        
        $sqlUpdate="UPDATE `habitaciones` SET   estado=?
                                        WHERE habitacion=?";
        $update=$conexion->prepare($sqlUpdate); 
        $update->execute(array("ocupada",$id));
        
        $_SESSION['message2']="Habitacion ocupada";
        
        header("location:detalleHabitacion.php?id=$id");
}else{
$ip= $_SERVER["REMOTE_ADDR"];

// buscar id de habitciones por la ip
$sql2="select habitacion from habitaciones where dirip=:ip";
//echo $sql."<br>";

$res=$conexion->prepare($sql2);
$res->bindParam("ip",$ip);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);

print_r($res);

$sql='';
if (isset($_GET['S1A'])){
	$sql="insert into movtemp set habitacion=:habitacion, fechaActS1='".date('Y-m-d')."',S1='SI', horaActS1='".date('H:i:s')."'";
        echo "sensor 1";
}
if (isset($_GET['S2A'])){
	$sql="update movtemp set S2='SI', horaActS2='".date('H:i:s')."' where habitacion=:habitacion and S2='NO' and S3='NO'";
        echo "sensor 2";
}
if (isset($_GET['S3A'])){
	$sql="update movtemp set S3='SI', horaActS3='".date('H:i:s')."' where habitacion=:habitacion and S1='SI' and S2='SI' and S3='NO'";
        echo "sensor 3";
}
 $arduino=$conexion->prepare($sql);
 $arduino->bindParam(":habitacion",$res['habitacion']); 
 $arduino->execute();
echo "listo";
}

?>