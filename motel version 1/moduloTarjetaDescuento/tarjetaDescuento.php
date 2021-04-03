<?php
session_start();
require "../conection.php";

$codigo=$_POST['codigo'];
$id=$_POST['id'];


$selectMovtemp="select * from movtemp where habitacion='".$id."' and id2=''";
$selectMov=$conexion->prepare($selectMovtemp);
$selectMov->execute();
$selectMov=$selectMov->fetch(PDO::FETCH_ASSOC);


if($selectMov['entroTarjeta']=="si"){
  $_SESSION['yaTieneTarjeta']="Esta habitacion ya tiene el descuento de cliente frecuente.";
  header("location:../habitOcupada.php?id=$id");
}


$sqlCodigo="SELECT * FROM `veneficios` WHERE `codigo`=:codigo";
$code=$conexion->prepare($sqlCodigo);
$code->bindParam(":codigo",$codigo);
$code->execute();
$code=$code->fetch(PDO::FETCH_ASSOC);








/* print_r($code); */
/* echo $_POST['idmov']; */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjetas</title>
    <link rel="stylesheet" type="text/css" href="../mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="../mdbootstrap/all.min.css">
</head>
<body>
<!-- MNODALES MODALES MODALES MODALES MODALES MODALES -->
<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="tarjetaNoRegistrada.php" method="post">
    <div style="background: #dee2e6;" class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Tarjeta no registrada</h4>
         
        </button>
      </div>
      <div class="modal-body mx-3">

        <div class="md-form mb-4">
          <i class="fas fa-plus-circle prefix grey-text"></i>
          <input style="display:none;" name="codigo" value="<?php echo $codigo;?>" type="text">
          <input style="display:none;" name="habitacion" value="<?php echo $id;?>" type="text">
          <input type="number" required name="descuento" id="descuento-pass" class="form-control validate">
          <label data-error="wrong" data-success="right" for="descuento-pass">Añadir un descuento</label>
        </div>

      </div>
      <div class="modal-footer d-flex">
      <a href="../habitOcupada.php?id=<?php echo $id?>" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-default">Registrar tarjeta</button>
      </div>
    </div>
  </div>
  </form>
</div>




<!-- MNODALES MODALES MODALES MODALES MODALES MODALES -->
<div class="modal fade" id="tarjetaDescuento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <form action="tarjetaRegistrada.php" method="post">
  <div class="modal-dialog" role="document">
    <div style="background: #dee2e6;" class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Aplicar descuento</h4>
         
        </button>
      </div>
      <div class="modal-body mx-3">

        <div class="md-form mb-4">
          <i class="fas fa-gift prefix grey-text"></i>
          <input style="display:none;" name="codigo" value="<?php echo $codigo;?>" type="text">
          <input style="display:none;" name="habitacion" value="<?php echo $id;?>" type="text">
          <input type="number" id="defaultForm-pass" name="descuento" value="<?php echo $code['veneficio']?>" class="form-control validate">
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Descuento del <?php echo $code['veneficio']."%"?></label>
        </div>

      </div>
      <div class="modal-footer d-flex">
        <a href="../habitOcupada.php?id=<?php echo $id?>" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-default">Añadir descuento</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!-- ///////////////////////////////////////////////////// -->
<!-- MNODALES MODALES MODALES MODALES MODALES MODALES -->
<div class="modal fade" id="tarjetaDisponible" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <form action="recargaTarjeta.php" method="post">
  <div class="modal-dialog" role="document">
    <div style="background: #dee2e6;" class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Recargar tarjeta <i class="fas fa-charging-station fa-2x"></i></h4>
         
        </button>
      </div>
      <div class="modal-body mx-3">

        <div class="md-form mb-4">
          <input style="display:none;" name="codigo" value="<?php echo $codigo;?>" type="text">
          <input style="display:none;" name="habitacion" value="<?php echo $id;?>" type="text">
        </div>
        <h5>La tarjeta esta en recarga.</h5>
        <h6>Desea ponela disponible para la siguiente sesion?</h6>
      </div>
      <div class="modal-footer d-flex">
        <a href="../habitOcupada.php?id=<?php echo $id?>" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-default">Disponible</button>
      </div>
    </div>
  </div>
  </form>
</div>

</body>

<script src="../mdbootstrap/js/jquery.min.js"></script>
<script src="../mdbootstrap/js/bootstrap.min.js"></script>
<script src="../mdbootstrap/js/mdb.min.js"></script>
<script src="../js/all.min.js"></script>


<script>

</script>
<?php

  if($code==null){
    /*   echo"1"; */
    echo '<script>
    $("#agregar").modal({backdrop: "static", keyboard: false})
    $("#agregar").modal("show")
    </script>';
  }else if($code['estado']=="recarga"){
    /* echo"2"; */
    echo '<script>
    $("#tarjetaDisponible").modal({backdrop: "static", keyboard: false})
    $("#tarjetaDisponible").modal("show")
    </script>'; 
    
  }else{
    echo '<script>
    $("#tarjetaDescuento").modal({backdrop: "static", keyboard: false})
    $("#tarjetaDescuento").modal("show")
    </script>'; 
  }
  
  ?>
</html>