<?php
require "../conection.php";

$codigo=$_GET['codigo'];
$id=$_GET['id'];
$recarga="recarga";

$selectMovtemp="select * from movtemp where habitacion='".$id."' and id2=''";
$selectMov=$conexion->prepare($selectMovtemp);
$selectMov->execute();
$selectMov=$selectMov->fetch(PDO::FETCH_ASSOC);

if($selectMov['entroTarjeta']=="si"){
    echo "Esta habitacion ya tiene un descuento con tarjeta";
}else{


    $sqlCodigo="SELECT * FROM `veneficios` WHERE `codigo`=:codigo";
    $code=$conexion->prepare($sqlCodigo);
    $code->bindParam(":codigo",$codigo);
    $code->execute();
    $code=$code->fetch(PDO::FETCH_ASSOC);
  
  
  
    if($code==null){



        $descuento=10;
        $insertTarjetaSql="INSERT INTO `veneficios`(`codigo`, `veneficio`, `estado`) 
        VALUES (:codigo,
                :veneficio,
                :estado)"; 

        $insertTarjeta=$conexion->prepare($insertTarjetaSql);
        $insertTarjeta->bindParam(":codigo",$codigo);
        $insertTarjeta->bindParam(":veneficio",$descuento);
        $insertTarjeta->bindParam(":estado",$recarga);
        $insertTarjeta->execute();
        /* TRAIGO EL ID DE LA TARJETA INSERTAR */
        $idTarjeta=$conexion->lastInsertId();
        /* AGREGO EL ID TARJETA AL MOVTEMP */
        $addTarjetaMovtemp="UPDATE `movtemp` SET `idTarjetaDescuento`=:idTarjetaDescuento WHERE `id`=:idmov";
        $addAMovtemp=$conexion->prepare($addTarjetaMovtemp);
        $addAMovtemp->bindParam(":idTarjetaDescuento",$idTarjeta);
        $addAMovtemp->bindParam(":idmov",$selectMov['id']);
        $addAMovtemp->execute();







        /* SUMO AL DESCUENTO EL 10% DE LA TARJETA */
        $entro="si";
        $descuentoMasTarjeta=$selectMov['descuento']+$descuento;
        $sql="UPDATE `movtemp` SET `descuento`=:descuento,`entroTarjeta`=:entroTarjeta WHERE `id`=:idmov";
        $update=$conexion->prepare($sql);
        $update->bindParam(":descuento",$descuentoMasTarjeta);
        $update->bindParam(":entroTarjeta",$entro);
        $update->bindParam(":idmov",$selectMov['id']);
        if($update->execute()){
            echo "agreogo una nueva tarjeta";
        }
        




    }else if($code['estado']=="recarga"){
      $disponible="disponible";
      $entro="si";
      /* SELECCIONO LA NUEVA TARJETA */
      $selectDescuento="SELECT * FROM `veneficios` WHERE `codigo`=:codigo";
      $descuento=$conexion->prepare($selectDescuento);
      $descuento->bindParam(":codigo",$codigo);
      $descuento->execute();
      $descuento=$descuento->fetch(PDO::FETCH_ASSOC);
  
      /* UPDATEO LA TARJETA PARA QUE QUEDE EN RECARGA */
      $updateTArjetaSql="UPDATE `veneficios` SET `estado`=:disponible WHERE `codigo`=:codigo";
      $updateTarjeta=$conexion->prepare($updateTArjetaSql);
      $updateTarjeta->bindParam(":disponible",$disponible);
      $updateTarjeta->bindParam(":codigo",$codigo);
      $updateTarjeta->execute();
  
  
      /* AGREGO EL ID TARJETA AL MOVTEMP */
      $addTarjetaMovtemp="UPDATE `movtemp` SET `idTarjetaDescuento`=:idTarjetaDescuento,`entroTarjeta`=:entroTarjeta WHERE `id`=:idmov";
      $addAMovtemp=$conexion->prepare($addTarjetaMovtemp);
      $addAMovtemp->bindParam(":entroTarjeta",$entro);
      $addAMovtemp->bindParam(":idTarjetaDescuento",$descuento['id']);
      $addAMovtemp->bindParam(":idmov",$selectMov['id']);
      

      if($addAMovtemp->execute()){
          echo "entro en recarga";
      }
      
    }else{
      
        $entro="si";
        /* SELECCIONO LA NUEVA TARJETA */
        $selectDescuento="SELECT * FROM `veneficios` WHERE `codigo`=:codigo";
        $descuento=$conexion->prepare($selectDescuento);
        $descuento->bindParam(":codigo",$codigo);
        $descuento->execute();
        $descuento=$descuento->fetch(PDO::FETCH_ASSOC);

        /* UPDATEO LA TARJETA PARA QUE QUEDE EN RECARGA */
        $updateTArjetaSql="UPDATE `veneficios` SET `estado`=:recarga WHERE `codigo`=:codigo";
        $updateTarjeta=$conexion->prepare($updateTArjetaSql);
        $updateTarjeta->bindParam(":recarga",$recarga);
        $updateTarjeta->bindParam(":codigo",$codigo);
        $updateTarjeta->execute();


        /* AGREGO EL ID TARJETA AL MOVTEMP */
        $descuentoMasTarjeta=$selectMov['descuento']+10;
        $addTarjetaMovtemp="UPDATE `movtemp` SET `idTarjetaDescuento`=:idTarjetaDescuento,`descuento`=:descuento,`entroTarjeta`=:entroTarjeta WHERE `id`=:idmov";
        $addAMovtemp=$conexion->prepare($addTarjetaMovtemp);
        $addAMovtemp->bindParam(":descuento",$descuentoMasTarjeta);
        $addAMovtemp->bindParam(":entroTarjeta",$entro);
        $addAMovtemp->bindParam(":idTarjetaDescuento",$descuento['id']);
        $addAMovtemp->bindParam(":idmov",$selectMov['id']);
        
        if($addAMovtemp->execute()){
            echo "la tarjeta estaba disponible";
        }


    }














}
  
  
 
  





?>