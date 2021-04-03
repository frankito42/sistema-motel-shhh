<?php
$segundos=3;
header("refresh:".$segundos);
require "php/conection.php"; 

$sql="SELECT * FROM `habitaciones` WHERE `ip_tablet`=:ip_tablet";
$habit=$conexion->prepare($sql);
$habit->bindParam(":ip_tablet",$_SERVER["REMOTE_ADDR"]);
$habit->execute();
$habit=$habit->fetch(PDO::FETCH_ASSOC);

$movtemSelect="SELECT `id`, `id2`, `codigo`, `habitacion`, `fechaActS1`, `horaActS1`, `horaActS2`, `horaDesActS2`, `horaActS3`, `horaDesActS3`, `fechaDesActS1`, `horaDesActS1`, `S1`, `S2`, `S3` FROM `movtemp` WHERE habitacion=:id order by id desc";
$movtem=$conexion->prepare($movtemSelect);
$movtem->bindParam(":id",$habit['habitacion']);
$movtem->execute();
$movtem=$movtem->fetch(PDO::FETCH_ASSOC);
/* print_r($movtem); */

$sql="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE `idMovtemp`=:idMovtemp";

$res=$conexion->prepare($sql);
$res->bindParam(":idMovtemp",$movtem["id"]);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);
/* print_r($res); */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cantidad carrito</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
   
</head>
<body style="background-color: #3C3B3BFE ">

<div class="contenedor">
<img src="CARRITO4.PNG" style="width: 120px;height: 120px;" >
<div class="texto-encima"><h4 style="font-size:30px;color:white;text-shadow: 1px 0px 3px #00d8ff;"><?php echo $res['productos']?></h4></div>
<div class="centrado"><h5 style="font-size:20px;color:white;text-shadow: 1px 0px 2px #e04dc5;" class="h5"><?php echo $res['total']?></h5></div>
</div>


        
        
       
<style>
.contenedor{
    position:relative;
    display:inline-block;
    text-align:center;
}
.texto-encima{
    position:absolute;
    top:21px;
    left:50px;
    
    
}
.centrado{
    position:absolute;
    top:82%;
    left:48%;
    transform:translate(-50%,-50%);
    
}
</style>

</body>

<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="mdbootstrap/css/all.min.js"></script>
</html>