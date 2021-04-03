<?php
require "conection.php";
$ip=$_GET['ip'];
$sql="select habitacion from habitaciones where dirip=:ip";
	$res=$conexion->prepare($sql);
	$res->bindParam(":ip",$ip);
	$res->execute();
    $res=$res->fetch(PDO::FETCH_ASSOC);
    $ocupada="ocupada";
/* date_default_timezone_set('America/Argentina/Buenos_Aires'); */
/* echo date('s')."\n"; */
/* usleep(5000000);
echo date('s')."\n"; */
/* set_time_limit(350);
$timepo1=date('h:i:s');
echo $timepo1;
$nuevafecha = strtotime ( '5 minute' , strtotime ( $timepo1 ) ) ;
$nuevafecha = date ( 'h-i-s' , $nuevafecha );
echo "<br>".$nuevafecha; */
/* $timpo2 */
/* while($timepo1 >= $nuevafecha){ */
    /* sleep(1) */
  /*   echo "El valor del número es ".$timepo1."<br/>";
    $timepo1=date('h:i:s');
} */

$sql="insert into movtemp set habitacion='".$res['habitacion']."', fechaActS1='".date('Y-m-d')."',S1='SI', horaActS1='".date('H:i:s')."'";
$exito=$conexion->prepare($sql);
$exito->execute();

$sqlEstado="UPDATE `habitaciones` SET `estado`=:estado WHERE dirip=:ip";
		$exito2=$conexion->prepare($sqlEstado);
		$exito2->bindParam(":estado",$ocupada);
		$exito2->bindParam(":ip",$ip);
    
        
        if($exito2->execute()){
            echo json_encode($res);
        }
        /* echo json_encode("ocupada"); */
?>