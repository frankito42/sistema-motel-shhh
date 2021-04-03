<script>
setInterval(() => {
fetch('preguntaEstado.php?id='+<?php echo $_GET['id'];?>)
  .then(response => response.json())
  .then((data)=>{
    console.log(data.estado)
    if(data.estado=="necesita limpieza"){
      location.href="index.php"
    }  
  });
}, 3000);
</script>

<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires'); 
require "conection.php";




$selec="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado` FROM `habitaciones` WHERE habitacion=:id";
$habitacion=$conexion->prepare($selec);
$habitacion->bindParam(":id",$_GET['id']);
$habitacion->execute();
$habitacion=$habitacion->fetch(PDO::FETCH_ASSOC);



$movtemSelect="SELECT `id`, `id2`, `codigo`, `habitacion`, `fechaActS1`, `horaActS1`, `horaActS2`, `horaDesActS2`, `horaActS3`, `horaDesActS3`, `fechaDesActS1`, `horaDesActS1`, `S1`, `S2`, `S3` FROM `movtemp` WHERE habitacion=:id and id2=''";
$movtem=$conexion->prepare($movtemSelect);
$movtem->bindParam(":id",$_GET['id']);
$movtem->execute();
$movtem=$movtem->fetch(PDO::FETCH_ASSOC);

/* print_r($movtem); */
$sqlcontador="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE idMovtemp=:idMovtemp and (estadoProducto='listo' OR estadoProducto='cocina' OR estadoProducto='sex')";

$contarCart=$conexion->prepare($sqlcontador);

$contarCart->bindParam(":idMovtemp",$movtem['id']);
$contarCart->execute();
$contarCart=$contarCart->fetch(PDO::FETCH_ASSOC);

/* SON TODOS LOS PRODUCTOS DEL CARRITO CON ESTADO LISTO O EN COCINA... QUE SIGNIFICA DESCONTADO DE STOCK Y ENTREGADO */
$sqlCarrito="SELECT c.`idCarrito`,c.`habitacion`,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos = c
INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.idMovtemp=:idMovtemp and (estadoProducto='cocina' OR estadoProducto='listo' OR estadoProducto='sex')";
$carrito=$conexion->prepare($sqlCarrito);
$carrito->bindParam(":idMovtemp",$movtem['id']);
$carrito->execute();
$carrito=$carrito->fetchAll(PDO::FETCH_ASSOC);
/* print_r($carrito); */

/* SON LOS PRODUCTOS PENDIENTES DE LA HABITACION */
$sqlProductosPendientes="SELECT COUNT(cantidad) as productosPendientes FROM carritos WHERE idMovtemp=:idMovtemp and estadoProducto='pendiente'";
$productosPendientes=$conexion->prepare($sqlProductosPendientes);
$productosPendientes->bindParam(":idMovtemp",$movtem['id']);
$productosPendientes->execute();
$productosPendientes=$productosPendientes->fetch(PDO::FETCH_ASSOC);

$sqlProductosCocina="SELECT COUNT(cantidad) as productosCocina FROM carritos WHERE idMovtemp=:idMovtemp and (estadoProducto='cocina' or estadoProducto='listo')";
$productosCocina=$conexion->prepare($sqlProductosCocina);
$productosCocina->bindParam(":idMovtemp",$movtem['id']);
$productosCocina->execute();
$productosCocina=$productosCocina->fetch(PDO::FETCH_ASSOC);

/* print_r($productosCocina); */

/* print_r($productosPendientes); */

/* if ($habitacion['estado']=="limpieza") {
  header("location: index.php");
}
if ($habitacion['estado']=="necesita limpieza") {
  header("location: index.php");
} */



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motel</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body style="background-image: linear-gradient(rgba(0, 0, 0, 0.4),rgba(0, 0, 0, 0.4))">
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Motel VIP</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3" aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="index.php">Habitaciones
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="productos-31" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Productos</a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="productos-31">
              <a class="dropdown-item waves-effect waves-light" href="addProducto/addproduct.php">Añadir producto</a>
              <a class="dropdown-item waves-effect waves-light" href="combos.php">Combos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="servicios-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="servicios-3">
            <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
            <a class="dropdown-item waves-effect waves-light" href="sexHotPanel.php">Sex Hot Panel</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="admin-36" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="admin-36">
            <a class="dropdown-item waves-effect waves-light" href="costosAVM.php">costos</a>
            <a class="dropdown-item waves-effect waves-light" href="caja.php">Caja</a>
            <a class="dropdown-item waves-effect waves-light" href="ventas.php">Ventas</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" onclick="printDiv('imprimir')">Ticket
              <span class="sr-only">(current)</span>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
         <!--  <li class="nav-item">
            <a class="nav-link waves-effect waves-light">
              <i class="fab fa-twitter"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light">
              <i class="fab fa-google-plus-g"></i>
            </a>
          </li> -->
          <li class="nav-item">
          <?php if($contarCart['productos']>0){?>  
              <a href="moduloCarritoHabitacion/categoriasComidas.php?ip=<?php echo $habitacion["ip_tablet"]."&nombreHabitacion=".$habitacion['nombre']?>" class="notification nav-link waves-effect waves-light">
              <i class="fas fa-shopping-cart"></i>
              <span class="badge"><?php echo $contarCart['productos'];?></span>
              </a>
         <?php }else{?>
            <a href="moduloCarritoHabitacion/categoriasComidas.php?ip=<?php echo $habitacion["ip_tablet"]."&nombreHabitacion=".$habitacion['nombre']?>" class="nav-link waves-effect waves-light">
              <i class="fas fa-shopping-cart"></i>
            </a>

         <?php }?>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i> <?php echo $_SESSION['user']['user']?>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item waves-effect waves-light" href="login/login_v5/php/cerrar.php">Cerrar Sesion</a>
            </div>
          </li>
         <!--  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
            </div>
          </li> -->
        </ul>
      </div>
    </nav>
    </header>
<section>
<div class="container">
<?php

if (isset($_SESSION['message2'])) {

  echo "<div id='editadoCorrecto' class='alert alert-dismissible alert-success' style='margin-top:20px;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['message2']."
  </div>";
}
?>
<?php

if (isset($_SESSION['yaTieneTarjeta'])) {

  echo "<div id='editadoCorrecto' class='alert alert-dismissible alert-danger' style='margin-top:20px;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['yaTieneTarjeta']."
  </div>";
}
?>



<div style="border-radius: 10px;background: #0066bd91;box-shadow: 0px 5px 30px 10px #0000007a;" class="container my-5 p-5  animated pulse">


  <!--Section: Content-->
  <section class="text-center black-text">

    <!-- Section heading -->
    <h2 style="font-size:50px; color:white;" class="font-weight-bold mb-4 pb-2 text-uppercase"><?php echo $habitacion['nombre']?> <button data-toggle="modal" data-target="#techo" class="btn btn-pink">Techo</button></h2>
    <!-- Section description -->
    <!-- Grid row -->
    <!-- Grid row -->

  </section>
  <!--Section: Content-->
  <div style="width:40%;float:left;">
  
   <?php require "chimichurri/verhab1.php";?>
   <h3 style='color:white;'>
   Carrito: $<?php echo $contarCart['total']."<button href='#addnew' data-toggle='modal' class='btn btn-success' style='color:black;'> Detalles</button>";?>
   </h3>
   <h3 style="border-radius:6px;background:#1dff1d99;color:white;">total: <?php $totalHABITACION=$habitacionjj+$contarCart['total']; echo "$".$totalHABITACION?></h3>
   
   
  </div>

  <div style="width:40%;float:right;display:contents;">
      <?php
      if (isset($_SESSION[$habitacion['ip_tablet']])&&$_SESSION[$habitacion['ip_tablet']]==$habitacion["ip_tablet"]) {
        
        ?>
        
      <a href="moduloCarritoHabitacion/categoriasComidas.php?ip=<?php echo $habitacion["ip_tablet"]."&nombreHabitacion=".$habitacion['nombre']?>" class="btn" style="background-color:#533992;color:white;"><i style="margin-top:10px;" class="fas fa-shopping-cart fa-2x"></i>Agegar al carrito <?php echo $habitacion['nombre'];?></a>
      <a href="metodosDePago.php?id=<?php echo $habitacion["habitacion"]?>" class="btn mercado" style="background-color:#533992;color:black;"> <img src="moduloHabitaciones/IMAGENES/MERCADO.png" style="width:50%;" alt=""></a>
      <a href="cambiarEstado.php?estado=ocupada&habitacion=<?php echo $habitacion['ip_tablet']."&idMovtemp=".$movtem['id']?>" class="btn btn-success " style="color:black;"><i style="margin-top:10px;"  class="fas fa-user fa-2x"></i>Continua</a>
        <?php if($productosPendientes['productosPendientes']<=0){?>
            <a href="metodosDePago.php?fin=fin&id=<?php echo $habitacion["habitacion"]."&id_movtem=".$movtem['id']."&ip_tablet=".$habitacion['ip_tablet']."&ipArduino=".$habitacion['dirip']."&totalCuenta=".$totalHABITACION?>" class="btn btn-danger" style="background-color:#533992;">Fin de pago</a>
        <?php }else{?>
          <a class="btn btn-danger" onclick="toastr.info('Hay pedidos pendientes en el carrito!');">Fin de pago</a>
        <?php }?>
      <?php }else{

      
      ?>
      <?php if(!isset($_SESSION['mostrar'])){?>
      <a href="moduloCarritoHabitacion/categoriasComidas.php?ip=<?php echo $habitacion["ip_tablet"]."&nombreHabitacion=".$habitacion['nombre']?>" class="btn" style="background-color:#533992;color:white;"><i style="margin-top:10px;" class="fas fa-shopping-cart fa-2x"></i>Agegar al carrito <?php echo $habitacion['nombre'];?></a>
      <a href="cambiarEstado.php?id=<?php echo $_GET['id'];?>" class="btn btn-yellow"><i style="margin-top:10px;color:black;" class="fas fa-dollar-sign fa-2x"></i><b style="color:black;">Enviar cuenta</b></a>
      <a href="activarDormida.php?comando=dor&id=<?php echo $movtem['id']."&habit=".$_GET['id'];?>" class="btn" style="background:#2cd889d1;"><i style="margin-top:10px;color:black;" class="fas fa-dollar-sign fa-2x"></i><b style="color:black;">Activar dormida</b></a>
      <a href="activarDormida.php?comando=esta&id=<?php echo $movtem['id']."&habit=".$_GET['id'];?>" class="btn" style="background:aliceblue;"><i style="margin-top:10px;color:black;" class="fas fa-dollar-sign fa-2x"></i><b style="color:black;">Activar Estadia</b></a>
      <a class="btn" data-toggle="modal" data-target="#descuentoModal" style="background:#cc44c1;"><i style="margin-top:10px;color:black;" class="fas fa-dollar-sign fa-2x"></i><b style="color:black;">Activar descuento</b></a>
      <a class="btn btn-blue" data-toggle="modal" data-target="#descuentoTarjeta"><i style="margin-top:10px;color:black;" class="fas fa-dollar-sign fa-2x"></i><b style="color:black;">Tarjeta descuento</b></a>
      <a href="cambiarEstado.php?cobrando=cobrando&habitacion=<?php echo $habitacion['ip_tablet']."&id_habitacion=".$_GET['id']."&ipArduino=".$habitacion['dirip']?>" class="btn btn-danger" style="color:black;"><i style="margin-top:10px;"  class="fas fa-shopping-cart fa-2x"></i>Cerrar cuenta</a>
        <?php if($productosPendientes['productosPendientes']<=0 && $productosCocina['productosCocina']<=0){?>
          <a class="btn" href="falloDeSensor.php?idMovtemp=<?php echo $movtem['id']."&habitacion=".$_GET['id']."&dirip=".$habitacion['dirip']?>" style="background:#948d8d;"><i style="margin-top:10px;color:black;" class="fas fa-times fa-2x"></i><b style="color:black;">Falso de sensor hhh</b></a>
        <?php }else{?>
          <a class="btn" style="background:#948d8d;" onclick="toastr.info('Hay pedidos pendientes en el carrito o en cocina! Elimine todos los pedidos para utilizar esta opcion.');"><i style="margin-top:10px;color:black;" class="fas fa-times fa-2x"></i> Falso de sensor</a>
        <?php }?>
        
      <?php }?> 
      <?php if(isset($_SESSION['mostrar'])){?>
      <a href="cambiarEstado.php?cobrando=cobrando&habitacion=<?php echo $habitacion['ip_tablet']."&id_habitacion=".$_GET['id']."&ipArduino=".$habitacion['dirip']?>" class="btn btn-danger" style="color:black;"><i style="margin-top:10px;"  class="fas fa-shopping-cart fa-2x"></i>Cerrar cuenta</a>
      <a href="cambiarEstado.php?estado=ocupada&habitacion=<?php echo $habitacion['ip_tablet']?>" class="btn btn-success " style="color:black;"><i style="margin-top:10px;"  class="fas fa-shopping-cart fa-2x"></i>Continuar</a>
      <?php } 
      }
      unset($_SESSION['mostrar']);
      
      
      ?> 
  </div>
<br style="clear:both;">
</div>


</section>




</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>





<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->
<div class="modal fade right" id="addnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="background:#dee2e6;" class="modal-content">
      <div style="background: #8e24aa8f;" class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">Articulos consumidos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div style="padding-top: 5px;" class="modal-body">
      <?php

        if (isset($_SESSION['editarTicket'])) {

          echo "<div id='editadoCorrecto' class='alert alert-dismissible alert-$_SESSION[color]'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>"
                .$_SESSION['editarTicket']."
                </div>";
        }?>
        <div class="row">
        <div class="col">
        <h4>Producto</h4>
        </div>
        <div class="col">
        <h4>cantidad</h4>
        </div>
        </div>
        <hr>
      <?php
      foreach ($carrito as $key):
      ?>

      <div class="row">
      <div class="col">
      <h4><?php echo $key['nombre']?></h4>
      </div>
      <div class="col">
      <a href="habitOcupadaSacarPro/menosProduct.php?idCarrito=<?php echo $key['idCarrito']."&habitacion=".$_GET['id']?>" class="btn btn-danger btn-sm"><i class="fas fa-minus fa-2x"></i></a><?php echo "x".$key['cantidad']?><a href="habitOcupadaSacarPro/masProduct.php?idCarrito=<?php echo $key['idCarrito']."&habitacion=".$_GET['id']?>" class="btn btn-success btn-sm"><i class="fas fa-plus fa-2x"></i></a> <a href="habitOcupadaSacarPro/deleteProducto.php?idCarrito=<?php echo $key['idCarrito']."&habitacion=".$_GET['id']?>" class="btn btn-danger btn-sm">Borrar</a>
      </div>
      </div>


      <?php endforeach?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-purple" data-dismiss="modal">Cerrar</button>
        <a href="moduloTicket/index.php?ip=<?php echo $habitacion['ip_tablet']."&habitacion=".$habitacion['nombre']."&movtemp=".$movtem['id']."&idHabitacion=".$_GET['id']?>&comando=articulosCompletos&totalHabit=<?php echo $habitacionjj;?>" class="btn btn-success">ticket</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->


<style>
.mercado{
  display:inline !important;
}
li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
.md-toast-message{
    background: #ff2b2bbd;
    margin-top: -40%;
    padding: 2%;
    margin-left: 75%;
    margin-right:2%;
    color: white;
    position: absolute;
    z-index: 100;
}
</style>

<!-- ////////////////////////////// -->
<!-- ////////////////////////////// -->
<div class="modal fade" id="descuentoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="activarDescuento.php" method="post">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Descuentos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-user prefix grey-text"></i>
          <input type="text" name="id" style="display:none;" value="<?php echo $_GET['id'];?>" class="form-control validate">
          <input type="text" name="idmov" style="display:none;" value="<?php echo $movtem['id'];?>" class="form-control validate">
          <input type="text" name="descuento" id="descuento" class="form-control validate">
          <label data-error="wrong" data-success="right" for="descuento">Descuento</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-indigo">agregar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- ////////////////////////////// -->
<!-- ////////////////////////////// -->
<!-- ////////////////////////////// -->
<!-- ////////////////////////////// -->
<div class="modal fade" id="descuentoTarjeta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div style="background: #dee2e6 !important;" class="modal-content">
    <form action="moduloTarjetaDescuento/tarjetaDescuento.php" method="post">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Tarjeta de cliente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-barcode prefix grey-text fa-3x"></i>
          <input type="text" name="id" style="display:none;" value="<?php echo $_GET['id'];?>" class="form-control validate">
          <input type="text" name="idmov" style="display:none;" value="<?php echo $movtem['id'];?>" class="form-control validate">
          <input type="text" name="codigo" id="tarjetaDescuento" class="form-control validate">
          <label data-error="wrong" data-success="right" for="tarjetaDescuento">Codigo de tarjeta</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-indigo">Buscar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- ////////////////////////////// -->
<!-- ////////////////////////////// -->
<div id="imprimir" style="display:none;" class="modal-body">

      <?php
      foreach ($carrito as $key):
      ?>
      <div class="row">
        <div class="col">
          <p><?php echo $key['nombre']?></p>
        </div>
        <div class="col">
        <p><?php echo "x".$key['cantidad']?></p>
        </div>
        <div class="col">
          <p><?php echo "$".$key['precio']?></p>
        </div>
      
      </div>
      
      
      

      <?php endforeach?>
      
</div>
<!-- //////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////// -->
<div class="modal fade right" id="techo" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div style="background:#dee2e6;" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="" id="exampleModalPreviewLabel">CAMBIAR COLO DE TECHOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <button type="button" onclick="azul('<?php echo $habitacion['dirip']; ?>')" class="btn btn-primary">AZUL</button>
        
      <!-- Default button -->
      <button type="button" onclick="rojo('<?php echo $habitacion['dirip']; ?>')" class="btn btn-danger">ROJO</button>
      
      <!-- Secondary button -->
      <button type="button" onclick="lila('<?php echo $habitacion['dirip']; ?>')" class="btn btn-secondary">LILA</button>
      
      <!-- Indicates a successful or positive action -->
      <button type="button" onclick="verde('<?php echo $habitacion['dirip']; ?>')" class="btn btn-success">VERDE</button>
      
      <!-- Contextual button for informational alert messages -->
      <button type="button" onclick="celeste('<?php echo $habitacion['dirip']; ?>')" class="btn btn-info">CELESTE</button>
      
      <!-- Indicates caution should be taken with this action -->
      <button type="button" onclick="amarillo('<?php echo $habitacion['dirip']; ?>')" class="btn btn-warning">AMARILLO</button>
      
      <!-- Indicates a dangerous or potentially negative action -->
      <button type="button" onclick="flash('<?php echo $habitacion['dirip']; ?>')" class="btn btn-grey">FLASH</button>
      
      <!-- Indicates a dangerous or potentially negative action -->
      <button type="button" onclick="apagar('<?php echo $habitacion['dirip']; ?>')" class="btn btn-black">APAGAR</button>
      
      <!-- Indicates a dangerous or potentially negative action -->
      <button type="button" onclick="prender('<?php echo $habitacion['dirip']; ?>')" class="btn btn-brown">PRENDER</button>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- //////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////// -->





<script language="Javascript">
function printDiv(nombreDiv) {
             let contenido = document.getElementById(nombreDiv).innerHTML;
             let contenidoOriginal = document.body.innerHTML;

             document.body.innerHTML = contenido;

             /* $(nombreDiv).css("media", "print");
             $(nombreDiv).css("background-color", "white");
             $(nombreDiv).css("border-color", "white"); */
             /* $(nombreDiv).css("width", "0%");
             $(nombreDiv).css("height", "0%"); */
             /* $(nombreDiv).css("white-space", "pre-wrap");
             $(nombreDiv).css("margin", "-23px -40px 0") */; /*$("#myPrintArea").css("margin", "-30px -35px 0")*/
             window.print();

             document.body.innerHTML = contenidoOriginal;
}
	</script>


  <?php if(isset($_SESSION['editarTicket'])){
    echo "<script>$('#addnew').modal('show')</script>";
  }?>
  <?php unset($_SESSION['message2'])?>
  <?php unset($_SESSION['yaTieneTarjeta'])?>
  <?php unset($_SESSION['editarTicket'])?>

  <script src="js/js.js"></script>
</html>