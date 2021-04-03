<?php
session_start();
require "conection.php";


if(!isset($_SESSION['user'])){
header("location:login/login_v5/index.php");
}



/* $sqlCombos="SELECT combos.`idCombo`, ar.`nombre` as combo , a.nombre, combos.`cantidad` FROM `combos` = combos
JOIN articulos = a on a.`articulo`=combos.`idArticulo`
JOIN articulos = ar on ar.articulo = combos.`idArticuloCombo`"; */
$sqlCombos="SELECT * FROM articulos WHERE categoria = 15";
$combos=$conexion->prepare($sqlCombos);
$combos->execute();
$combos=$combos->fetchAll(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>Combos</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Combos</a>
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
  
<button data-toggle="modal" data-target="#addNewCombo" class="btn btn-success">Nuevo combo</button>

  
<table class="table table-hover">
<thead style="background: #f5191978;">
<tr> 
<th>Nombre</th>
<th>Cantidad</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($combos as $key):?>
<tr>
<td><?php echo $key['nombre'];?></td>
<td><?php echo $key['cantidad'];?></td>
<th><a style="color:black;font-size:15px;" class="btn btn-success btn-sm" href="moduloCombo/detalleCombo.php?idCombo=<?php echo $key['articulo']?>">Ver</a>
<!-- <a class="btn btn-danger btn-sm" href="moduloCombo/deleteCombo.php?idCombo=<?php echo $key['articulo']?>"><i style="color:black;" class="fas fa-trash-alt fa-2x"></i></a> -->
</th>
</tr>
<?php endforeach?>
</tbody>
</table>
  
  
  
  
  </div>
  
  </section>


  
    
  


</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
<!-- <script src="js/js.js"></script> -->
<!-- ////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////// -->
<div class="modal fade" id="addNewCombo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="moduloCombo/addNewCombo.php" method="get">
    <div class="modal-content">
      <div style="color: white;background: grey;" class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Nuevo Combo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-box-open prefix grey-text"></i>
          <input type="text" name="nombre" id="defaultForm-text" class="form-control validate">
          <label data-error="wrong" data-success="right" for="defaultForm-text">Nombre</label>
        </div>

        <div class="md-form mb-4">
          <i class="fas fa-angle-double-up prefix grey-text"></i>
          <input type="text" id="defaultForm-text" disabled value="1000" class="form-control validate">
          <label data-error="wrong" data-success="right" class="active" for="defaultForm-pass">Cantidad</label>
        </div>

      </div>
      <div class="modal-footer d-flex">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button class="btn btn-default">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////// -->


<style>
li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}

</style>

</html>