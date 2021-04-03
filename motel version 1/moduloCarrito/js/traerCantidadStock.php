<?php
require "../../conection.php";
$sql="SELECT * FROM `articulos`";
$res=$conexion->prepare($sql);
$res->execute();
$res=$res->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res);
?>