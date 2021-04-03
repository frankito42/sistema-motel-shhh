<?php
/*
* Este archio muestra los productos en una tabla.
*/
session_start();
include "php/conection.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>productos</title>
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<section>
<div>
<nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Motel VIP</a>
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
          <li class="nav-item active">
            <a class="nav-link waves-effect waves-light" href="">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="#">Pricing</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-3">
              <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
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
          <li class="nav-item">
            <a href="cart.php" class="nav-link waves-effect waves-light">
              <i class="fas fa-shopping-cart"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
</div>
</section>
</header>
<section>
<div >
<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
  <div class="btn-group mr-2" style="display:contents;" role="group" aria-label="First group">
    <a href="categoriasComidas.php?categoria=6" type="button" class="btn indigo lighten-2"><i style="font-size:40px;" class="fas fa-glass-cheers"></i></a>
    <a href="categoriasComidas.php?categoria=2" type="button" class="btn blue lighten-2"><i style="font-size:40px;" class="fas fa-hamburger"></i></a>
    <a href="categoriasComidas.php?categoria=1" type="button" class="btn light-blue lighten-2"><i style="font-size:40px;" class="fas fa-pizza-slice"></i></a>
    <a href="categoriasComidas.php?categoria=3" type="button" class="btn cyan lighten-2"><i style="font-size:40px;" class="fas fa-cloud"></i></a>
    <button type="button" class="btn cyan lighten-2"><i class="fab fa-twitter" aria-hidden="true"></i></button>
    <button type="button" class="btn cyan lighten-2"><i class="fab fa-twitter" aria-hidden="true"></i></button>
    <button type="button" class="btn cyan lighten-2"><i class="fab fa-twitter" aria-hidden="true"></i></button>
  </div>
</div>
</div>
</section>

<div class="" style="margin-left:20px;margin-right:20px;margin-top:10px;">
	<div class="row">
		<div class="col-md-12">
		
			
<?php
/*
* Esta es la consula para obtener todos los productos de la base de datos.
*/
if(isset($_SESSION["addCart"])){

	echo "<div class='modal fade' id='add' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
            	<center><h4 class='modal-title' id='myModalLabel'>Motel</h4></center>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            </div>
            <div class='modal-body'>	
            	<p class='text-center'>Se a agreagado un producto al carrito</p>
			
			</div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-blue' data-dismiss='modal'><span class='fa fa-close'></span> Cerrar</button>
            </div>

        </div>
    </div>
</div>";

}

if(isset($_GET['bebidas'])){
	$products = $conexion->query("select * from articulos where tipoart=".$_GET['bebidas']."");
}else if (isset($_GET['comidas'])) {
	$products = $conexion->query("select * from articulos where tipoart=".$_GET['comidas']."");
}else if (isset($_GET['cafeteria'])) {
	$products = $conexion->query("select * from articulos where tipoart=".$_GET['cafeteria']."");
}else if (isset($_GET['juguetes'])) {
	$products = $conexion->query("select * from articulos where tipoart=".$_GET['juguetes']."");

}else {
	$products = $conexion->query("select * from articulos");
}

?>




<table class="table table-bordered">
<thead>
	<th>Producto</th>
	<th>Precio</th>
	<th>cantidad</th>
	<th>action</th>
</thead>
<?php 
/*
* Apartir de aqui hacemos el recorrido de los productos obtenidos y los reflejamos en una tabla.
*/
while($r=$products->fetch(PDO::FETCH_OBJ)):
	
	?>
	<form action="php/addtocart.php" method="get">

<tr>
    <input name="articulo" type="number" value="<?php echo $r->articulo?>" style="display:none;">
	<td><?php echo $r->nombre;?></td>
	<td>$ <?php echo $r->costo; ?></td>
	<td><a onclick="menos(<?php echo $r->articulo?>)" class="btn btn-danger btn-sm"><i style="font-size:15px;" class="fas fa-minus"></i></a> <input class="valorInput" id="<?php echo $r->articulo?>" style="width:22px;border:0px;font-size:20px;" name="cantidad" value="1" type="number"><a onclick="mas(<?php echo $r->articulo?>)" class="btn btn-sm btn-success"><i style="font-size:15px;" class="fas fa-plus"></i></a></td>
	<td style="width:260px;">

<button type="submit" class="btn blue-gradient"><i class="fas fa-shopping-cart"></i> Agregar al carrito</button>

	</td>
</tr>
</form>
<?php endwhile ?>
</table>

		</div>
	</div>
</div>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="mdbootstrap/css/all.min.js"></script>
<script src="js/js.js"></script>
</body>
<?php
echo"<script>$('#add').modal('show')</script>";
 
unset($_SESSION["addCart"]);

?>
</html>