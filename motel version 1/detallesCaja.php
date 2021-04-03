<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires'); 
require "conection.php";

/* TRAIGO EL DETALLE DE LA CAJA ASI LO MUESTRO EN UNA TABLA */
$sqlDetalle="SELECT c.`idCaja`, c.`total`, c.`cajaFuerte`, c.`idMovtemp`,m.fechaActS1,m.horaActS1,h.nombre,h.ip_tablet, u.user, c.horaCaja FROM `cajas` = c JOIN movtemp = m on c.`idMovtemp`=m.`id` JOIN habitaciones = h on m.habitacion=h.habitacion join usuarios = u on c.idUser=u.idUser WHERE m.`id`=:idMov";
$detalleCaja=$conexion->prepare($sqlDetalle);
$detalleCaja->bindParam(":idMov",$_GET['idMov']);
$detalleCaja->execute();
$detalleCaja=$detalleCaja->fetchAll(PDO::FETCH_ASSOC);

/* SELECIONO TODOS LOS PRODUCTOS DE LA SESION EN LA PIEZA O TICKET */
$sqlCarrito="SELECT c.`idCarrito`, c.`habitacion`, a.`nombre`, c.`cantidad`, c.`precio`, c.`estadoProducto`, c.`idMovtemp` FROM `carritos` = c JOIN articulos = a ON c.`articulo`=a.`articulo` WHERE c.`idMovtemp`=:idMov";
$carrito=$conexion->prepare($sqlCarrito);
$carrito->bindParam(":idMov",$_GET['idMov']);
$carrito->execute();
$carrito=$carrito->fetchAll(PDO::FETCH_ASSOC);


/* TRAIGO TODOS LOS ARTICULOS POR SI QUIEREN AÑADIR UN NUEVO PRODUCTO AL TICKET //SERIA EDITAR */
$sqlArticulos="SELECT `articulo`, `nombre`, `tipoart`, `costo`, `stockmin`, `cantidad`, `descripcion`, `imagen`, a.`categoria`, `codBarra`, nombreCategoria 
FROM `articulos` = a 
JOIN categoria = c on a.`categoria`=c.idCategoria";
$articulos=$conexion->prepare($sqlArticulos);
$articulos->execute();
$articulos=$articulos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">DETALLES </a>
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
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="servicios-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="servicios-3">
            <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
            <a class="dropdown-item waves-effect waves-light" href="sexHotPanel.php">Sex Hot Panel</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="admin-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="admin-3">
            <a class="dropdown-item waves-effect waves-light" href="costosAVM.php">costos</a>
            <a class="dropdown-item waves-effect waves-light" href="caja.php">Caja</a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light">
              <i class="fab fa-twitter"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light">
              <i class="fab fa-google-plus-g"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i> <?php echo $_SESSION['user']['user']?>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item waves-effect waves-light" href="login/login_v5/php/cerrar.php">Cerrar Sesion</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    </header>
<section>
<div class="container">

<h3 style="background: #f5dcf4;border-radius: 12px;width: 19%;">Detalle de ticket</h3>
<table class="table table-hover">
<thead style="background: #19d6f5b0;">
<tr>
<th>Nro ticket</th>
<th>Usuario</th>
<th>Habitacion</th>
<th>Fecha de inicio</th>
<th>Hora de inicio</th>
<th>Fecha y Hora de pago</th>
<th>Action</th>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php foreach ($detalleCaja as $key):?>
<tr>
<td><?php echo $key['idMovtemp'];?></td>
<td><?php echo $key['user'];?></td>
<td><?php echo $key['nombre'];?></td>
<td><?php echo $key['fechaActS1'];?></td>
<td><?php echo $key['horaActS1'];?></td>
<td><?php echo $key['horaCaja'];?></td>
<td><a href="moduloReImprimirTicket/index.php?habitacion=<?php echo $key['nombre']."&movtemp=".$key['idMovtemp']?>" class="btn peach-gradient btn-sm">Re imprimir</a> <a data-toggle="modal" data-target="#centralModalDanger" class="btn btn-blue btn-sm">Edit ticket</a></td>
<td><?php echo "$".$key['total'];?></td>
</tr>
<?php endforeach?>
<tr>
<td style="background:#1dff1dcc;" colspan="7"></td>
<td style="background:#1dff1dcc;"></td>
</tr>
</tbody>
</table>
<h3 style="background: #f5dcf4;border-radius: 12px;width: 19%;">Consumiciones</h3>
<table class="table table-hover">
<thead style="background: #e49d33b0;">
<tr>
<th>Articulo</th>
<th>Cantidad</th>
<th>P/U</th>

<th>Total</th>
<th>Action</th>

</tr>
</thead>
<tbody>
<?php $total=0; foreach ($carrito as $key): $total+=$key['cantidad']*$key['precio']?>
<tr>
<td><?php echo $key['nombre'];?></td>
<td><a href="moduloCajaTicket/menosCantidadTicket.php?idCarrito=<?php echo $key['idCarrito']?>" class="btn btn-danger btn-sm"><i style="color:black;" class="fas fa-minus-circle fa-3x"></i></a> <?php echo $key['cantidad'];?> <a href="moduloCajaTicket/cantidadArticuloTicket.php?idCarrito=<?php echo $key['idCarrito']?>" class="btn btn-success btn-sm"><i style="color:black;" class="fas fa-plus-circle fa-3x"></i></a></td>
<td><?php echo $key['precio'];?></td>
<td><?php echo $key['cantidad']*$key['precio'].".00";?></td>
<td style="width: 1%;"><button data-toggle="modal" data-target="<?php echo "#as".$key['idCarrito']?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt fa-2x"></i></button></td>
</tr>

<?php require "moduloCajaTicket/modalDelete.php"; endforeach?>
<?php 
if($carrito==null){
    echo '<td style="text-align:center;" colspan="5"><h5>No consumio nada</h5></td>';
}
?>

<tr>
<td style="background:#1dff1dcc;" colspan="3">TOTAL</td>
<td style="background:#1dff1dcc;" colspan="2"><?php echo "$".$total?></td>
</tr>
</tbody>
</table>

</div>
</section>


</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
<script src="js/js.js"></script>

<section>
<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////MODALES//////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<div class="modal fade" id="centralModalDanger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-info" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead">ticket N°<?php echo $detalleCaja[0]['idMovtemp']?></p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>
       <form action="moduloCajaTicket/addProductoTicket.php" method="get">

       <!--Body-->
       <div class="modal-body">
       <h5>Añadir un producto</h5>
         <div class="text-center">
         
          <input required type="text" name="idMov" value="<?php echo $_GET['idMov']?>" style="display:none;">
          <input required type="text" name="ip_tablet" value="<?php echo $detalleCaja[0]['ip_tablet']?>" style="display:none;">
          <select required name="articulo" class="mdb-select md-form" searchable="Buscar">
          <option value="" disabled selected>Productos</option>
          <?php foreach ($articulos as $key):?>
          <option value="<?php echo $key['articulo']?>"><?php echo $key['nombre']?></option>
          <?php endforeach?>
          </select>
          <div class="md-form">
            <input type="number" required min="1" name="cantidad" id="labelCantidad" class="form-control">
            <label for="labelCantidad">Cantidad</label>
          </div>


         </div>
         
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
         <button type="submit" class="btn btn-success">Añadir <i class="far fa-gem ml-1 text-white"></i></button>
       </div>
     </div>
     <!--/.Content-->
   </div>
  </form>
 </div>

<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
</section>
<script>
// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});
</script>
<style>
.select-dropdown{
  position: absolute;
    top: 24px;
    left: 0px;
    background: white;
    z-index: 1;
    box-shadow: 0 11px 20px black;
    position: initial;
    list-style-type: none; 
    padding: 3%;
    max-height: 400px !important;
    overflow-y: scroll;/*le pones scroll*/
}
.initialized{
  display:none;
}
.caret{
  display:none;
}
li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}


</style>
</html>