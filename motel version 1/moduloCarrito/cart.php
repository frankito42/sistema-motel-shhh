<?php
/*
* Este archio muestra los productos en una tabla.
*/
session_start();
$pendiente="pendiente";
include "php/conection.php";

$sql="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet` FROM `habitaciones` WHERE ip_tablet=:ip_tablet";
$res=$conexion->prepare($sql);
$res->bindParam(":ip_tablet",$_SERVER['REMOTE_ADDR']);
$res->execute();
$res=$res->fetch(PDO::FETCH_ASSOC);


	$movSql="SELECT * FROM `habitaciones` = h 
  INNER JOIN movtemp = m on h.`habitacion`=m.`habitacion` AND m.id2=0 AND h.`ip_tablet`=:ip_tablet";
  $mov=$conexion->prepare($movSql);
  $mov->bindParam(":ip_tablet",$_SERVER['REMOTE_ADDR']);
  $mov->execute();
  $mov=$mov->fetch(PDO::FETCH_ASSOC);



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
<div class="" style="margin-left:20px;margin-right:20px;">
	<div class="row">
		<div class="col-md-12">
		
			<!-- <a href="./products.php" class="btn btn-default">Productos</a>
			<br><br> -->
<?php
/*
* Esta es la consula para obtener todos los productos de la base de datos.
*/
$server=$_SERVER['REMOTE_ADDR'];
$products = $conexion->prepare("SELECT c.`idCarrito`,c.`habitacion`,c.`articulo` as idProducto,a.`nombre`,c.`cantidad`,c.`precio`,a.categoria FROM carritos = c
INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:habitacion and estadoProducto=:pendiente and idMovtemp=:mov");
$products->bindParam(":habitacion",$server);
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
<th style="    white-space: nowrap;" ><a href="php/updateCart.php?cantidad=<?php echo $c['cantidad']?>&id=<?php echo $c['idCarrito']?>&comando=menos" class="btn btn-danger btn-sm"><i style="font-size:15px;" class="fas fa-minus"></i></a> <input class="valorInput" id="<?php echo $c['idCarrito']?>" style="width:22px;border:0px;font-size:20px;background:#3C3B3BFE;color:white;" name="cantidad" value="<?php echo $c['cantidad']?>" type="number"><a href="php/updateCart.php?cantidad=<?php echo $c['cantidad']?>&id=<?php echo $c['idCarrito']?>&comando=mas" class="btn btn-sm btn-success"><i style="font-size:15px;" class="fas fa-plus"></i></a></th>
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
<?php
if ($r==null) {
?>
<a href="pedirProductos.php" class="btn btn-lg btn-success disabled">Pedir</a>
<?php }else {?>
<a href="pedirProductos.php" class="btn btn-lg btn-success">Pedir</a>
<?php }?>

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

