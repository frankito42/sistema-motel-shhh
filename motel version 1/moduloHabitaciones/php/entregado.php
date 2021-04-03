 <?php
  require "../../conection.php";
  $idCarrito=$_GET['idCarrito'];
/*     $update="UPDATE `carritos` SET `estadoProducto`=:cocina WHERE `habitacion`=:habitacion AND `estadoProducto`=:pendiente AND idMovtemp=:idMovtemp "; */
  $listo="listo";
  $update="UPDATE `carritos` SET `estadoProducto`=:cocina WHERE `idCarrito`=:idCarrito ";
  $upp=$conexion->prepare($update);
  $upp->bindParam(":cocina",$listo);

  $upp->bindParam(":idCarrito",$idCarrito);
  
  if($upp->execute()){
      echo json_encode("ok");
  }
 
 
 ?>