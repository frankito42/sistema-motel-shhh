<?php
session_start();
require "conection.php";


$sqlCocina="SELECT DISTINCT c.`habitacion`,h.nombre FROM carritos = c
INNER JOIN habitaciones = h ON h.ip_tablet = c.habitacion";

/* SELECT c.`idCarrito`,h.`nombre` as nombreHabitacion,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos  = c 
INNER JOIN articulos = a on a.`articulo` = c.`articulo`
INNER JOIN habitaciones = h on h.`ip_tablet` = c.habitacion ORDER BY c.habitacion */


/* SELECT h.`nombre`,a.nombre as producto,c.cantidad,c.precio FROM `habitaciones`= h
INNER JOIN carritos =c ON c.habitacion=h.ip_tablet
INNER JOIN articulos=a on a.articulo=c.articulo
 */
$cocina=$conexion->prepare($sqlCocina);
$cocina->execute();
$cocina=$cocina->fetchAll(PDO::FETCH_ASSOC);
/* echo "<pre>";
print_r($cocina);
echo "</pre>"; */
/* $pedidos=[array=>"habitacion"()];

foreach ($cocina as $key) {
  

    array_push($pedidos['habitacion'],$key['nombreHabitacion']);
 
}
print_r($pedidos); */
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motel</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Cocina</a>
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
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="moduloCarrito/categoriasComidas.php">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="addProducto/addproduct.php">Añadir producto</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-3">
              <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
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
        
        </ul>
      </div>
    </nav>
    </header>
    <section>
    <div class="container">
   
    <?php

if (isset($_SESSION['message'])) {

  echo "<div id='mensajeEliminar' class='alert alert-dismissible alert-success' style='margin-top:20px;margin-left:7%;margin-right:7%;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['message']."
  </div>";
}
?>





<div class="row row-cols-1 row-cols-md-2">
<?php 

foreach ($cocina as $key):
$sqlCarritos="SELECT a.`nombre`,c.`cantidad`,c.`precio` FROM carritos  = c 
INNER JOIN articulos = a on a.`articulo` = c.`articulo` WHERE c.`habitacion`=:habitacion";
$productos=$conexion->prepare($sqlCarritos);
$productos->bindParam(":habitacion",$key['habitacion']);
$productos->execute();
$productos=$productos->fetchAll(PDO::FETCH_ASSOC);

?>
  <div class="col mb-4">
    <!-- Card -->
    <div class="card">

      <!--Card image-->
      <div class="view overlay">
        <!-- <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Others/images/16.jpg"
          alt="Card image cap"> -->
        <a href="#!">
          <div class="mask rgba-white-slight"></div>
        </a>
      </div>

      <!--Card content-->
      <div class="card-body">

        <!--Title-->
        <h4 class="card-title"><?php echo $key['nombre']?></h4>

        <?php foreach ($productos as $products):?>
        <!--Text-->
        <h5><?php echo $products['nombre']." x".$products['cantidad']?></h5>
        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

        <?php endforeach?>
        <button type="button" class="btn btn-light-blue btn-md">Listo</button>

      </div>

    </div>
    <!-- Card -->
  </div>
  <?php 


  
endforeach


?>
  <!-- //////////////////////////////////////////////////////////////////////// -->
  <!-- FOREACHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH -->
  <!-- FOREACHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH -->
  <!-- //////////////////////////////////////////////////////////////////////// -->
</div>
   













    </div>
    </section>

</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>

<script src="js/js.js"></script>
<script src="js/all.min.js"></script>


</style>

<?php unset($_SESSION['message'])?>
</html>