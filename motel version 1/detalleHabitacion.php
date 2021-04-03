<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
session_start();
require "conection.php";

$id=$_GET['id'];


$selec="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado` FROM `habitaciones` WHERE habitacion=:id";
$habitacion=$conexion->prepare($selec);
$habitacion->bindParam(":id",$_GET['id']);
$habitacion->execute();
$habitacion=$habitacion->fetch(PDO::FETCH_ASSOC);

if ($habitacion['estado']=="ocupada") {
  header("location: habitOcupada.php?id=$id");
}
if ($habitacion['estado']=="enviar cuenta") {
  header("location: habitOcupada.php?id=$id");
}
if ($habitacion['estado']=="coche") {
  header("location: habitOcupada.php?id=$id");
}
if ($habitacion['estado']=="cobrando") {
  header("location: habitOcupada.php?id=$id");
}
if ($habitacion['estado']=="MP") {
  header("location: habitOcupada.php?id=$id");
}
if ($habitacion['estado']=="limpieza") {
  header("location: limpieza.php?id=$id");
}
if ($habitacion['estado']=="necesita limpieza") {
  header("location: verificarHabitacion/verificacion1.php?id=$id");
}
if ($habitacion['estado']=="verificacion2") {
  header("location: verificarHabitacion/verificacion2.php?id=$id");
}


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
<body style="background: #3C3B3BFE;">
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
          <!-- <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="moduloCarrito/categoriasComidas.php">Productos</a>
          </li> -->
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
<?php

if (isset($_SESSION['message'])) {

  echo "<div id='editadoCorrecto' class='alert alert-dismissible alert-success' style='margin-top:20px;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['message']."
  </div>";
}
?>
</div>
<div style="border-radius: 10px;background: #2bbbada8;box-shadow: 0px 5px 30px 10px #0000007a;" class="container my-5 p-5  animated pulse">


  <!--Section: Content-->
  <section class="text-center black-text">

    <!-- Section heading -->
    <h2 style="font-size:50px;" class="font-weight-bold mb-4 pb-2 text-uppercase"><?php echo $habitacion['nombre']?></h2>
    <!-- Section description -->
    <p style="font-size:25px;" class="lead mx-auto mb-5"><?php echo $habitacion['descripcion'];?></p>

    <!-- Grid row -->
    <div style="justify-content: space-evenly;" class="row">

      <!-- Grid column -->
      <div id="eliminar" style="background:#ff4444;border-radius:10px;box-shadow: 0px 5px 20px 10px #0000007a;" class="waves-light col-md-3 mb-4 animated pulse">

        <i style="margin-top:5px;" class="fas fa-glass-whiskey fa-6x black-text"></i>
        <h5 class="font-weight-bold my-4 text-uppercase">Eliminar habitacion</h5>
    
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div id="editar" style="background:#9933CC;border-radius:10px;box-shadow: 0px 5px 20px 10px #0000007a;" class="waves-light col-md-3 mb-4 animated pulse">

        <i style="margin-top:5px;" class="fas fa-edit fa-6x black-text"></i>
        <h5 class="font-weight-bold my-4 text-uppercase">Editar habitacion</h5>
    
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div id="activar" style="background:#00C851;border-radius:10px;box-shadow: 0px 5px 20px 10px #0000007a;" class="waves-light col-md-3 mb-4 animated pulse">

        <i style="margin-top:5px;" class="fas fa-door-open fa-6x black-text"></i>
        <h5 class="font-weight-bold my-4 text-uppercase">Activar habiacion</h5>
     
      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!--Section: Content-->


</div>
</section>
<!--///////////////////// SECCION DE LOS MODALES ///////////////////-->
<section>
<!-- MODAL ELIMINAR HABITACION -->
<div style="margin-top:10%;" class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger">
        <div class="modal-content">
            <div class="modal-header">
            	<center><h4 class="modal-title white-text w-100 font-weight-bold py-2" id="myModalLabel">Borrar habitacion</h4></center>
                <button style="color:white;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">	
            	<p class="text-center">¿Estas seguro en borrar?</p>
				<h2 class="text-center"><?php echo $habitacion['nombre']; ?></h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
                <a href="moduloHabitaciones/deleteHabitacion.php?id=<?php echo $habitacion['habitacion']; ?>" class="btn btn-danger"><span class="fa fa-trash"></span> Si</a>
            </div>

        </div>
    </div>
</div>
<!-- FIN MODAL ELIMINAR -->
<!-- MODAL DE EDITAR -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div  class="modal-dialog">
        <div class="modal-content">
            <div style="background:#9933CC;" class="modal-header">
            	 <center><h4 class="modal-title white-text w-100 font-weight-bold py-2" id="myModalLabel">Editar habitacion</h4></center>
                <button style="color:white;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="moduloHabitaciones/updateHabitacion.php?id=<?php echo $habitacion['habitacion']; ?>">
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Nombre:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nombre" value="<?php echo $habitacion['nombre']; ?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Descrip:</label>
					</div>
					<div class="col-sm-10">
            <textarea name="descripcion" class="form-control" id="" cols="30" rows="4"><?php echo $habitacion['descripcion'];?></textarea>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Estado:</label>
					</div>
					<div class="col-sm-10">
            <select class="form-control" name="estado">
              <option value="disponible">Disponible</option>
            </select>
					</div>
				</div>
        <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Letra:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="letra" value="<?php echo $habitacion['letra']; ?>">
					</div>
				</div>
        <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Dirip:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="dirip" value="<?php echo $habitacion['dirip']; ?>">
					</div>
				</div>
        <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Iptablet:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="iptablet" value="<?php echo $habitacion['ip_tablet']; ?>">
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
                <button type="submit" name="edit" class="btn btn-success"><span class="fa fa-check"></span> Actualizar</a>
			</form>
            </div>

        </div>
    </div>
</div>
<!-- FIN MODAL EDITAR -->


<!-- ////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////// -->

<div style="margin-top:5%;" class="modal fade" id="activar1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h4 class="modal-title white-text w-100 font-weight-bold py-2">Activacion</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <form action="activarHabit.php?id=<?php echo $habitacion['habitacion']?>" method="post">
      <div class="modal-body">
       
       <!--  <div class="md-form">
          <i class="fas fa-map-marker-alt prefix grey-text"></i>
          <input type="text" id="form2" class="form-control">
          <label data-error="wrong" data-success="right" for="form2">Tiempo de estadia</label>
        </div> -->
        <div class="md-form">
          <i class="fas fa-clock prefix grey-text"></i>
          <input type="text" id="form1" value="<?php echo date('H:i:s')?>" class="form-control">
          <label data-error="wrong" data-success="right" for="form1">Horario de inicio</label>
        </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-blue waves-effect">Activar <i class="fas fa-paper-plane-o ml-1"></i></button>
        </form>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>


<!-- ////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////// -->
</section>
<style>

li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
</style>

</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
<script src="moduloCarrito/js/listener.js"></script>
<script src="js/js.js"></script>
<?php unset($_SESSION['message'])?>

</html>