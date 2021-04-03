<?php
/*
* Eliminar un producto del carrito
*/
session_start();

require "conection.php";
$eliminar=$conexion->prepare("DELETE FROM `carritos` WHERE idCarrito=:id");
$eliminar->bindParam(":id",$_GET['id']);
$eliminar->execute();
print "<script>window.location='../cart.php';</script>";

?>

