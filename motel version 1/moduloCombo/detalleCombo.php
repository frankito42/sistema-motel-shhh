<?php
session_start();
require "../conection.php";


if(!isset($_SESSION['user'])){
header("location:../login/login_v5/index.php");
}


$sqlArticulos="SELECT * FROM `articulos`";
$articulos=$conexion->prepare($sqlArticulos);
$articulos->bindParam(":articulo",$combo);
$articulos->execute();
$articulos=$articulos->fetchAll(PDO::FETCH_ASSOC);




$combo=$_GET['idCombo'];

$selectNombreCombo="SELECT * FROM `articulos` WHERE `articulo`=:articulo";
$nombreCombo=$conexion->prepare($selectNombreCombo);
$nombreCombo->bindParam(":articulo",$combo);
$nombreCombo->execute();
$nombreCombo=$nombreCombo->fetch(PDO::FETCH_ASSOC);


/* $sqlCombos="SELECT combos.`idCombo`, ar.`nombre` as combo , a.nombre, combos.`cantidad` FROM `combos` = combos
JOIN articulos = a on a.`articulo`=combos.`idArticulo`
JOIN articulos = ar on ar.articulo = combos.`idArticuloCombo`"; */
$sqlCombos="SELECT `idCombo`, `idArticuloCombo`, `idArticulo`,a.nombre, c.`cantidad` FROM `combos` = c 
JOIN articulos = a on a.articulo =`idArticulo` WHERE idArticuloCombo=:idArticuloCombo";
$combos=$conexion->prepare($sqlCombos);
$combos->bindParam(":idArticuloCombo",$combo);
$combos->execute();
$combos=$combos->fetchAll(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>Combos</title>
    <link rel="stylesheet" type="text/css" href="../mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="../mdbootstrap/all.min.css">
	<link rel="stylesheet" href="../moduloCarrito/css/style.css">
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
            <a class="nav-link waves-effect waves-light" href="../index.php">Habitaciones
              <span class="sr-only">(current)</span>
            </a>
          </li>
          
          <!-- <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="moduloCarrito/categoriasComidas.php">Productos</a>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="productos-31" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Productos</a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="productos-31">
              <a class="dropdown-item waves-effect waves-light" href="../addProducto/addproduct.php">Añadir producto</a>
              <a class="dropdown-item waves-effect waves-light" href="../combos.php">Combos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="servicios-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="servicios-3">
              <a class="dropdown-item waves-effect waves-light" href="../cocina.php">Cocina</a>
              <a class="dropdown-item waves-effect waves-light" href="../sexHotPanel.php">Sex Hot Panel</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="admin-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="admin-3">
            <a class="dropdown-item waves-effect waves-light" href="../costosAVM.php">costos</a>
            <a class="dropdown-item waves-effect waves-light" href="../caja.php">Caja</a>
            <a class="dropdown-item waves-effect waves-light" href="../ventas.php">Ventas</a>
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
  <div class="row">
  <div class="col"> 
    <button data-toggle="modal" data-target="#modalComboAdd" class="btn btn-success">Añadir producto al combo</button>
  </div>
  <div class="col">
  <h1 style="background: #fa939394;border-radius: 12px;"><?php echo $nombreCombo['nombre']?></h1>
  </div>
  </div>
  
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
<td><a href="delete.php?idCombo=<?php echo $key['idCombo']."&combo=".$nombreCombo['articulo'];?>" class="btn btn-danger btn-sm"><i style="color:black;" class="fas fa-trash-alt fa-2x"></i></a></td>
</tr>
<?php endforeach?>
</tbody>
</table>
  
  
  
  
  </div>
  
  </section>


  
    
  


</body>
<script src="../mdbootstrap/js/jquery.min.js"></script>
<script src="../mdbootstrap/js/bootstrap.min.js"></script>
<script src="../mdbootstrap/js/mdb.min.js"></script>
<script src="../js/all.min.js"></script>
<!-- <script src="../js/js.js"></script> -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////MODALES//////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<div class="modal fade" id="modalComboAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-info" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead"><?php echo $nombreCombo['nombre']?></p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>
       <form action="addProductCombo.php" method="get">

       <!--Body-->
       <div class="modal-body">
       <h5>Añadir un producto</h5>
         <div class="text-center">
            <input type="number" name="combo" style="display:none;" value="<?php echo $nombreCombo['articulo']?>">
          <select required name="articulo" class="mdb-select md-form" searchable="Buscar">
          <option value="" disabled selected>Productos</option>
          <?php foreach ($articulos as $key):?>
          <option value="<?php echo $key['articulo']?>"><?php echo $key['nombre']?> (<?php echo "en stock: ".$key['cantidad']?>)</option>
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