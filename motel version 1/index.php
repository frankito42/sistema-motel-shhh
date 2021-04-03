<?php
session_start();
require "conection.php";


if(!isset($_SESSION['user'])){
header("location:login/login_v5/index.php");
}



$costos="SELECT * FROM `costos`";
$habitacionCostos=$conexion->prepare($costos);
$habitacionCostos->execute();
$habitacionCostos=$habitacionCostos->fetchAll(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>SHHH</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body style="background:#000000d9;">
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Motel SHHH</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3" aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
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
              <a class="dropdown-item waves-effect waves-light" href="compras.php">Compras</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="servicios-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="servicios-3">
              <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
              <a class="dropdown-item waves-effect waves-light" href="sexHotPanel.php">Sex Hot Panel</a>
              <a class="dropdown-item waves-effect waves-light" onclick="descargar()">Descargar App</a>
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
    <div>
    <?php

if (isset($_SESSION['message'])) {

  echo "<div id='mensajeEliminar' class='alert alert-dismissible alert-success' style='margin-top:20px;margin-left:7%;margin-right:7%;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['message']."
  </div>";
}
?>  
    <div id="recargaHabit">
    <?php /* require "moduloHabitaciones/habitaciones.php"; */?>
    </div>
    </div>
    
    </section>

    <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<center><h4 class="modal-title" id="myModalLabel">Agregar nueva habitacion</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
                
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="moduloHabitaciones/addHabit.php">
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Nombre:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nombre">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Descrip:</label>
					</div>
					<div class="col-sm-10">
            <textarea name="descripcion" class="form-control" id="" cols="30" rows="4"></textarea>
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
						<input type="text" class="form-control" name="letra">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Dirip:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="dirip">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Iptablet:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="iptablet">
					</div>
				</div>
        <div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">costo:</label>
					</div>
					<div class="col-sm-10">
         
         <select name="costo" class="browser-default custom-select">
           <?php foreach ($habitacionCostos as $costo):?>
         <option value="<?php echo $costo['costo']?>"><?php echo $costo["nombre"]." $".$costo['monto1']?></option>
           <?php endforeach?>
         </select>
       
					</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
                <button type="submit" name="add" class="btn btn-primary"><span class="fa fa-save"></span> Guardar</a>
			</form>
            </div>

        </div>
    </div>
</div>


</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
<script src="js/js.js"></script>

<script>
let a=0
        $("#recargaHabit").load("moduloHabitaciones/habitaciones.php")
setInterval(function() {
        $("#recargaHabit").load("moduloHabitaciones/habitaciones.php")
        
        console.log(a+=1)


}, 10000)

   /*  setInterval(()=> {
      console.log("entro")
      fetch('ping2.php')
      .then(response => response.json())
      .then((data)=>{
        console.log(data)
        if (data.b=="desconectada") {
          alert(data.a)
          console.log("LPM")
        }
      }
      
      );
    }, 5000) */
 
    function descargar(){
        window.location = "app.apk";
    }

</script>

<style>
li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
/* LARGO DEL MODAL */
.modal .modal-side {
    position: absolute;
    right: 10px;
    bottom: 10px;
    width: 660px !important;
    margin: 0;
}
.modal-dialog {
    max-width: 700px;
    margin: 1.75rem auto;
}

</style>


<?php unset($_SESSION['message'])?>
<script type='text/javascript'>
	document.oncontextmenu = function(){return false}
</script>
</html>