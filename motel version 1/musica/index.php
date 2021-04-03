<?php
header("refresh:1");
require "../conection.php";
$_SERVER["REMOTE_ADDR"];
echo $_SERVER["REMOTE_ADDR"];

$sql="SELECT `musica` FROM `teleshabitaciones` WHERE `ipTele`=:iptele";
$res=$conexion->prepare($sql);
$res->bindParam(":iptele",$_SERVER["REMOTE_ADDR"]);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);
/*  */
print_r($res);
echo "<h1>".$res['musica']."</h1>";





?>