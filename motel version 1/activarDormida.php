<?php
session_start();    
require "conection.php";
$id=$_GET['id'];
$comando=$_GET['comando'];
$habit=$_GET['habit'];
$si="SI";


$consulta="SELECT `id`, `id2`, `codigo`, `habitacion`, `fechaActS1`, `horaActS1`, `horaActS2`, `horaDesActS2`, `horaActS3`, `horaDesActS3`, `fechaDesActS1`, `horaDesActS1`, `S1`, `S2`, `S3`, `activarDormida`, `activarEstadia` FROM `movtemp` WHERE `id`=:id";
$res=$conexion->prepare($consulta);
$res->bindParam(":id",$id);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);
 
if($comando=="dor" && $res['activarEstadia']==""){
    $sql="UPDATE `movtemp` SET `activarDormida`=:dor WHERE id=:id";
    $activar=$conexion->prepare($sql);
    $activar->bindParam(":id",$id);
    $activar->bindParam(":dor",$si);
    $activar->execute();
    $_SESSION['message2']="<h1>Se activo dormida</h1>";
    header("location:habitOcupada.php?id=$habit");

}
if($comando=="esta" && $res['activarDormida']==""){
    $sql="UPDATE `movtemp` SET `activarEstadia`=:es WHERE id=:id";
    $activar=$conexion->prepare($sql);
    $activar->bindParam(":id",$id);
    $activar->bindParam(":es",$si);
    $activar->execute();
    $_SESSION['message2']="<h1>Se activo estadia</h1>";
    header("location:habitOcupada.php?id=$habit");
}

header("location:habitOcupada.php?id=$habit");










?>