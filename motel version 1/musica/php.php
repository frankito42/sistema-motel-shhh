<?php
/* header("refresh:1"); */
require "../conection.php";
/* $_SERVER["REMOTE_ADDR"];
echo $_SERVER["REMOTE_ADDR"]; */

if(isset($_GET['musica'])){


$ip="192.168.100.251";
$sql="UPDATE `teleshabitaciones` SET `musica`=:musica WHERE `ipTele`=:iptele";
$res=$conexion->prepare($sql);
$res->bindParam(":iptele",$ip);
$res->bindParam(":musica",$_GET['musica']);
$res->execute();
/* $res=$res->fetch(PDO::FETCH_ASSOC); */

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hola</title>
</head>
<body>
<form action="php.php" method="get">
<input type="text" name="musica"><button type="submit">enviar</button>
</form>
    
</body>
</html>
