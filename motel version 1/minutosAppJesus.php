<?php
require "conection.php";
$movSql="SELECT * FROM `habitaciones` = h 
INNER JOIN movtemp = m on h.`habitacion`=m.`habitacion` AND m.id2=0 AND h.`ip_tablet`=:ip_tablet";
$mov=$conexion->prepare($movSql);
$mov->bindParam(":ip_tablet",$_SERVER['REMOTE_ADDR']);
$mov->execute();
$movtemp=$mov->fetch(PDO::FETCH_ASSOC);

require "chimichurri/verhab1.php";


function algunNombre($m){
    $d = (int)($m/1440);
    $m -= $d*1440;
     
    $h = (int)($m/60);
    $m -= $h*60; 
     
    return array("dias" => $d, "horas" => $h, "minutos" => $m);
    }
     
    $someVar = algunNombre($minTotalesTurno);
     
    $minutosRoundMas0=round($someVar["minutos"]);
    $minutosRoundMas0=($minutosRoundMas0<10) ? "0".$minutosRoundMas0 : $minutosRoundMas0;
    $horasCon0=($someVar["horas"]<10) ? "0".$someVar["horas"] : $someVar["horas"];
    /* echo "días: ".$someVar["dias"]."<br/>";
    echo "horas: ".$someVar["horas"]."<br/>";
    echo "Minutos: ".round($someVar["minutos"])."<br/>"; */

    $totalHorasMin=$horasCon0.":".$minutosRoundMas0;

    echo "duracion".$totalHorasMin.",".$habitacionjj;
?>