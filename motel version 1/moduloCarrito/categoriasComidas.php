<?php
session_start(); 
require "php/conection.php";

if(isset($_GET['categoria'])){
$sql="SELECT * FROM `articulos` WHERE `categoria`=".$_GET['categoria']."";

}else {
    $sql="SELECT * FROM `articulos`";
}

$res=$conexion->prepare($sql);
$res->execute();
$res=$res->fetchAll(PDO::FETCH_ASSOC);

$sqlcontador="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE `habitacion`=:habitacion";

$contarCart=$conexion->prepare($sqlcontador);
$contarCart->bindParam(":habitacion",$_SERVER["REMOTE_ADDR"]);
$contarCart->execute();
$contarCart=$contarCart->fetch(PDO::FETCH_ASSOC);
$_SESSION["contadorCart"]=$contarCart['productos'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="euc-jp">
    <meta charset="UTF-8">
  
    <title>comidas</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="css/style.css">
    <style>
    .myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}
.modal-sm {
    max-width: 400px;
}
    </style>
</head>
<body style="background:#3C3B3BFE;">



<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
  </ol>
  <div class="carousel-inner">
  <div class="carousel-item active">
  <img class="d-block w-100" style="height: 520px;" src="SEX SHOP TABLET/PLUG ANAL 2.jpg" alt="...">
 <!--  <div class="carousel-caption d-none d-md-block">
    <h5><span style="background: #0000006b;border-radius: 15px;padding:5px;font-size: 170%;">Promo papas fritas y cerveza.</span></h5>
    <p><span style="background: #0000006b;border-radius: 15px;padding:5px;font-size: 150%;">Hace tu pedido!</span></p>
  </div> -->
</div>
  <div class="carousel-item">
  <img class="d-block w-100" style="height: 520px;" src="SEX SHOP TABLET/PLUG ANAL 2.jpg" alt="...">
  <!-- <div class="carousel-caption d-none d-md-block">
    <h5><span style="background: #0000006b;border-radius: 15px;padding:5px;font-size: 170%;">Promo papas fritas y cerveza.</span></h5>
    <p><span style="background: #0000006b;border-radius: 15px;padding:5px;font-size: 150%;">Hace tu pedido!</span></p>
  </div> -->
<!-- </div>
  <div class="carousel-item">
  <img class="d-block w-100" src="3.jpeg" alt="...">
  <div class="carousel-caption d-none d-md-block">
    <h5><span style="background: #0000006b;border-radius: 15px;padding:5px;">Milanesas napolitanas</span></h5>
    <p><span style="background: #0000006b;border-radius: 15px;padding:5px;">Deliciosas!</span></p>
  </div>
</div> -->
    
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


</section>
<div style="margin-left:20px;margin-right:20px;margin-top:10px;">
<!-- <div style="text-align: center;width: 100%;" class="btn-group" role="group" aria-label="Basic example">
  <a href="?categoria=2" class="btn btn-blue btn-rounded">Hamburguesas</a>
  <a href="?categoria=3" class="btn btn-blue btn-rounded">Empanadas</a>
  <a href="?categoria=1" class="btn btn-blue btn-rounded">Pizzas</a>
  <a href="?categoria=4" class="btn btn-blue btn-rounded">Sandwich</a>
  <a href="?categoria=12" class="btn btn-blue btn-rounded">Picaditas</a>
  <a href="?categoria=11" class="btn btn-blue btn-rounded">Dulces</a>
  <a href="?categoria=5" class="btn btn-blue btn-rounded">otros</a>
</div> -->

<?php
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

?>


<table style="color: white;" class="table table-bordered">
<thead>
<tr>
<td style="font-size:25px;">Producto</td>
<td style="font-size:25px;">Precio</td>
<td style="font-size:25px;">Cantidad</td>
<td style="font-size:25px;">Img</td>
<td style="font-size:25px;">action</td>
</tr>
</thead> 
<tbody>
<?php foreach ($res as $key):?>
	<form action="php/addtocart.php" method="get">
    <tr>
    <input name="articulo" type="number" value="<?php echo $key['articulo']?>" style="display:none;">
	<td style="font-size:25px;"><?php echo $key['nombre'];?></td>
	<td style="font-size:25px;    white-space: nowrap;">$ <?php echo $key['precioVenta']; ?></td>
	<td style="    white-space: nowrap;"><a  onclick="menos(<?php echo $key['articulo']?>)" class="btn btn-danger btn-sm"><i style="font-size:15px;" class="fas fa-minus"></i></a>
    <input class="valorInput" id="<?php echo $key['articulo']?>" style="width:22px;border:0px;font-size:20px;background:#3C3B3BFE;color: white;" name="cantidad" value="1" type="number">
    <a onclick="mas(<?php echo $key['articulo']?>)" class="btn btn-sm btn-success"><i style="font-size:15px;" class="fas fa-plus"></i></a></td>
	<td style="font-size:25px;width: 15% ;white-space: nowrap;"><img class="myImg" style="width: 100%;height: 120px;" src="<?php echo $key['imagen']; ?>" alt=""></td>
    <td >
<?php if ($key['cantidad']<=0) {?>
<button style="font-size:20px;" disabled type="submit" class="btn blue-gradient"><i style="color:black;" class="fas fa-shopping-cart"></i> Agregar</button>
<?php }else {?>
    <button style="font-size:20px;" type="submit" class="btn blue-gradient"><i style="color:black;" class="fas fa-shopping-cart"></i> Agregar</button>
<?php }?>
	</td>
</tr>
</form>
<?php endforeach ?>
</tbody> 
</table>
</div>

<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->
<div class="modal fade" id="mostarImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

  <!-- Change class .modal-sm to change the size of the modal -->
  <div class="modal-dialog modal-sm" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h4 id="tituloProducto" class="modal-title w-100" id="myModalLabel">Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img style="width: 100%;" src="" id="cargarImg" alt="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary btn-sm">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- Central Modal Small -->
<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// -->

    
</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<!-- <script src="mdbootstrap/css/all.min.js"></script> -->
<script src="js/js.js"></script>
<script src="js/carritoTablet.js"></script>
<script src="../js/all.min.js"></script>


<?php
echo"<script>$('#add').modal('show')</script>";
 
unset($_SESSION["addCart"]);

?>

</html>