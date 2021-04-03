<?php
require "conection.php";
$ipAr=$_SERVER["REMOTE_ADDR"];

$selec="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado` FROM `habitaciones` WHERE dirip=:ipAr";
$habitacion=$conexion->prepare($selec);
$habitacion->bindParam(":ipAr",$ipAr);
$habitacion->execute();
$habitacion=$habitacion->fetch(PDO::FETCH_ASSOC);


$sqlMovtemp="SELECT h.`habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado`,m.fechaActS1,m.horaActS1,m.id FROM `habitaciones`= h  JOIN movtemp = m on h.habitacion =m.habitacion and m.id2!=m.id WHERE h.ip_tablet=:ip_tablet";

$movtemp=$conexion->prepare($sqlMovtemp);
$movtemp->bindParam(":ip_tablet",$habitacion['ip_tablet']);
$movtemp->execute();
$movtemp=$movtemp->fetch(PDO::FETCH_ASSOC);





?>