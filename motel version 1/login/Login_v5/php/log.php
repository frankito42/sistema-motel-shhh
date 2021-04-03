<?php
session_start();
require "../../../conection.php";
$user=$_POST['user'];
$pass=$_POST['pass'];
$sql="SELECT * FROM `usuarios` WHERE `user`=:user AND `pass`=:pass";
$res=$conexion->prepare($sql);
$res->bindParam(":user",$user);
$res->bindParam(":pass",$pass);
$res->execute();
$res=$res->fetch();
/* print_r($res); */
if($res==null){
    $_SESSION['error']="error vuelva a ingresar sus datos";
    header("location:../index.php");
}else{
    $_SESSION["user"]=$res;
    header("location:../../../index.php");
}
?>