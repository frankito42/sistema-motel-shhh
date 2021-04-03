<?php
/*
* Este archio muestra los productos en una tabla.
*/
session_start();
$pendiente="pendiente";
include "php/conection.php";

$sql="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet` FROM `habitaciones` WHERE ip_tablet=:ip_tablet";
$res=$conexion->prepare($sql);
$res->bindParam(":ip_tablet",$_GET["ip"]);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);



$movSql="SELECT * FROM `habitaciones` = h 
  INNER JOIN movtemp = m on h.`habitacion`=m.`habitacion` AND m.id2=0 AND h.`ip_tablet`=:ip_tablet";
  $mov=$conexion->prepare($movSql);
  $mov->bindParam(":ip_tablet",$_GET['ip']);
  $mov->execute();
  $mov=$mov->fetch(PDO::FETCH_ASSOC);



$sqlcontador="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE `habitacion`=:habitacion and estadoProducto=:estado";

$contarCart=$conexion->prepare($sqlcontador);
$contarCart->bindParam(":habitacion",$_GET["ip"]);
$contarCart->bindParam(":estado",$pendiente);
$contarCart->execute();
$contarCart=$contarCart->fetch(PDO::FETCH_ASSOC);


 /* require "../../verhab.php"; */ 

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body style="background:#3C3B3BFE;">


<section>
<header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Motel VIP</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3" aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link waves-effect waves-light" href="../index.php">Habitaciones
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="../addProducto/addproduct.php">Añadir producto</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-3">
              <a class="dropdown-item waves-effect waves-light" href="../cocina.php">Cocina</a>
              <a class="dropdown-item waves-effect waves-light" href="../sexHotPanel.php">Sex Hot Panel</a>
              <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
            </div>
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
<a href="cart.php?ip=<?php echo $_GET["ip"]."&nombreHabitacion=".$_GET['nombreHabitacion']?>" class="notification nav-link waves-effect waves-light">
<i class="fas fa-shopping-cart"></i>
  <span class="badge"><?php echo $contarCart['productos'];?></span>
</a>
         <?php }else{?>
            <a href="cart.php?ip=<?php echo $_GET["ip"]."&nombreHabitacion=".$_GET['nombreHabitacion']?>" class="nav-link waves-effect waves-light">
              <i class="fas fa-shopping-cart"></i>
            </a>

         <?php }?>
          </li>
          <!-- <li class="nav-item dropdown">
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


</section>









<div class="" style="margin-left:20px;margin-right:20px;">
<h1 style="color:#d00078;text-shadow: 0px -2px 13px #f91313">Carrito de la <?php echo $_GET['nombreHabitacion']?></h1>

	<div class="row">
		<div class="col-md-12">
		
			<!-- <a href="./products.php" class="btn btn-default">Productos</a>
			<br><br> -->
<?php
/*
* Esta es la consula para obtener todos los productos de la base de datos.
*/
$ip=$_GET["ip"];
$products = $conexion->prepare("SELECT c.`idCarrito`,c.`habitacion`,c.`articulo` as idProducto,a.`nombre`,c.`cantidad`,c.`precio`, a.categoria FROM carritos = c
INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:habitacion and estadoProducto=:pendiente and idMovtemp=:mov");
$products->bindParam(":habitacion",$ip);
$products->bindParam(":pendiente",$pendiente);
$products->bindParam(":mov",$mov['id']);
$products->execute();
$r = $products->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['productos']=$r;
?>
<table style="color:white" class="table table-bordered">
<thead>
	<th style="font-size:25px;">Cantidad</th>
	<th style="font-size:25px;">Producto</th>
	<th style="font-size:25px;">Precio Unitario</th>
	<th style="font-size:25px;">Total</th>
	<th></th>
</thead>
<?php 
/*
* Apartir de aqui hacemos el recorrido de los productos obtenidos y los reflejamos en una tabla.
*/
$total=0;
foreach($r as $c):
     $total+=$c['precio']*$c['cantidad'];
	?>
<tr>
<th><a href="php/updateCart.php?cantidad=<?php echo $c['cantidad']?>&id=<?php echo $c['idCarrito']?>&comando=menos" class="btn btn-danger btn-sm"><i style="font-size:15px;" class="fas fa-minus"></i></a> <input class="valorInput" id="<?php echo $c['idCarrito']?>" style="width:22px;border:0px;font-size:20px;background:#3C3B3BFE;color:white;" name="cantidad" value="<?php echo $c['cantidad']?>" type="number"><a href="php/updateCart.php?cantidad=<?php echo $c['cantidad']?>&id=<?php echo $c['idCarrito']?>&comando=mas" class="btn btn-sm btn-success"><i style="font-size:15px;" class="fas fa-plus"></i></a></th>
	<td style="font-size:21px;"><?php echo $c['nombre'];?></td>
	<td style="font-size:25px;">$ <?php echo $c['precio'] ?></td>
	<td style="font-size:25px;">$ <?php echo $c['precio']*$c['cantidad']; ?></td>
	<td >
		<a style="font-size:15px;" href="php/delfromcart.php?id=<?php echo $c["idCarrito"];?>" class="btn btn-danger">Eliminar</a>
	</td>
</tr>
<?php endforeach; ?>
<tr> 
<td colspan="3"><b>TOTAL</b></td>
<td colspan="2"><b><?php echo "$".$total?></b></td>
</tr>
</table>
<div style="text-align:right;">


<a href="pedirProductos.php?ip=<?php echo $ip?>" class="btn btn-lg btn-success">Pedir</a>
</div>
<div class="modal fade" id="pedir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            	<center><h4 class="modal-title" id="myModalLabel">Gracias por su compra</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">	
            	<p class="text-center">su pedido sera llegara en unos minutos</p>
			
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
            </div>

        </div>
    </div>
</div>



		</div>
	</div>
</div>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="mdbootstrap/css/all.min.js"></script>
<!-- <script src="js/js.js"></script> -->
</body>


<?php
if (isset($_SESSION['pedidoCarrito'])) {

	echo"<script>$('#pedir').modal('show')</script>";
}
 
unset($_SESSION['pedidoCarrito']);
?>

</html>

