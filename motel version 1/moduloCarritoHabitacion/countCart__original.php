<?php
require "php/conection.php";

$sql="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE `habitacion`=:habitacion";

$res=$conexion->prepare($sql);
$res->bindParam(":habitacion",$_SERVER["REMOTE_ADDR"]);
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
    <style>
 .notification {
  
  color: white;
  text-decoration: none;
  
  position: relative;
  display: inline-block;
  border-radius: 2px;
}
body{
    background:#3C3B3BFE;
}

.notification .badge {
  position: absolute;
  top: -3px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background: red;
  color: white;
}
    </style>
</head>
<body>


<a style="margin:5px;margin-top:10px;" href="#" class="notification">
  <img style="margin-left:15px;width:66px;height:66px;" src="1.png">
  <span class="badge"><?php echo $res['productos']?></span>
</a>
<div style="margin-left:21px;">

  <span style="border-radius: 4%;background: red;padding: 5px;"><b style="color:white;"><?php echo $res['total']?></b></span>
</div>

</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="mdbootstrap/css/all.min.js"></script>
</html>