<?php
session_start();
$estado="pendiente";
require "php/conection.php";

$sql="SELECT `articulo`, `nombre`, `tipoart`, `costo`, `stockmin`, `cantidad`, `descripcion`, `imagen`, a.`categoria`, `codBarra`, nombreCategoria,precioVenta FROM `articulos` = a JOIN categoria = c on a.`categoria`=c.idCategoria";

$res=$conexion->prepare($sql);
$res->execute();
$res=$res->fetchAll(PDO::FETCH_ASSOC);

$sqlcontador="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE `habitacion`=:habitacion and estadoProducto=:estado";

$contarCart=$conexion->prepare($sqlcontador);
$contarCart->bindParam(":habitacion",$_GET["ip"]);
$contarCart->bindParam(":estado",$estado);
$contarCart->execute();
$contarCart=$contarCart->fetch(PDO::FETCH_ASSOC);


$sqlMovtemp="SELECT h.`habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado`,m.fechaActS1,m.horaActS1,m.id FROM `habitaciones`= h  JOIN movtemp = m on h.habitacion =m.habitacion and m.id2!=m.id WHERE h.ip_tablet=:ip_tablet";
$movtemp=$conexion->prepare($sqlMovtemp);
$movtemp->bindParam(":ip_tablet",$_GET["ip"]);
$movtemp->execute();
$movtemp=$movtemp->fetch(PDO::FETCH_ASSOC);


$ip=$_GET["ip"];
$products = $conexion->prepare("SELECT c.`idCarrito`,c.`habitacion`,c.`articulo` as idProducto,a.`nombre`,c.`cantidad`,c.`precio`, a.categoria FROM carritos = c
INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:habitacion and estadoProducto='pendiente' and idMovtemp=:mov");
$products->bindParam(":habitacion",$ip);
$products->bindParam(":mov",$movtemp['id']);
$products->execute();
$r = $products->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['productos']=$r;


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
  td{
    text-shadow: 0px 0px 20px black;
  }
  </style>
</head>
<body>
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
              <a class="dropdown-item waves-effect waves-light" href="../costosAVM.php">costos</a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
        <!--   <li class="nav-item">
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
            <!-- <a href="cart.php?ip=<?php /* echo $_GET["ip"]."&nombreHabitacion=".$_GET['nombreHabitacion'] */?>" class="notification nav-link waves-effect waves-light"> -->
            <a data-toggle="modal" data-target="#modalCart" class="notification nav-link waves-effect waves-light">
            Carrito
            <i class="fas fa-shopping-cart"></i>
            <span class="badge"><?php echo $contarCart['productos'];?></span>
            </a>
         <?php }else{?>
            <a data-toggle="modal" data-target="#modalCart" class="nav-link waves-effect waves-light">
              <i class="fas fa-shopping-cart"></i> Carrito
            </a>

         <?php }?>
          </li>
         <!--  <li class="nav-item dropdown">
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



<div style="margin-left:20px;margin-right:20px;margin-top:10px;">

<?php
/* if(isset($_SESSION["addCart"])){

	echo "<div id='alert' class='alert alert-success alert-dismissible fade show' role='alert'>
  Se añadio un producto al carrito correctamente.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";

} */
?>

<div class="row">
<div style="margin-top: 1%;" class="col">
<h1 style="color:#d00078;text-shadow: 0px -2px 13px #f91313">Enviar al carrito de la <?php echo $_GET['nombreHabitacion']?></h1>
</div>
<div class="col">
      <div class="md-form form-group">
          <i class="fa fa-envelope prefix"></i>
          <input type="text" id="form91" class="form-control validate">
          <label for="form91" >Nombre del producto</label>
      </div>
</div>
</div>
      




<table id="mytable"class="table table-hover">
<thead style="background:#44cad8bf;">
<tr>
<td style="font-size:25px;">Producto</td>
<td style="font-size:25px;">Categoria</td>
<td style="font-size:25px;">Precio</td>
<td style="font-size:25px;">Cantidad</td>
<td style="font-size:25px;">action</td>
</tr>
</thead>
<tbody>
<?php foreach ($res as $key):?>
	<form action="php/addtocart.php" method="get">
    <tr>
    <input name="articulo" type="number" value="<?php echo $key['articulo']?>" style="display:none;">
    <input name="idMovtemp" type="text" value="<?php echo $movtemp['id']?>" style="display:none;">
    <input name="ip" type="text" value="<?php echo $_GET["ip"];?>" style="display:none;">
	<td style="font-size:25px;"><?php echo $key['nombre'];?></td>
	<td style="font-size:25px;"><?php echo $key['nombreCategoria']; ?></td>
  <?php
  if ($key['nombreCategoria']=='Combo') {
    echo '<input name="combo" type="text" value="" style="display:none;">';
  } 
  ?>
	<td style="font-size:25px; white-space: nowrap;">$ <?php echo $key['precioVenta']; ?></td>
	<td style="white-space: nowrap;" ><a  onclick="menos(<?php echo $key['articulo']?>)" class="btn btn-danger btn-sm"><i style="font-size:15px;" class="fas fa-minus"></i></a> <input class="valorInput" id="<?php echo $key['articulo']?>" style="width:22px;border:0px;font-size:20px;" name="cantidad" value="1" type="number"><a onclick="mas(<?php echo $key['articulo']?>)" class="btn btn-sm btn-success"><i style="font-size:15px;" class="fas fa-plus"></i></a></td>
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



<!-- Central Modal Medium Success -->
<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-success" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead">Recuerde confirmar los pedidos.</p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>

       <!--Body-->
       <div class="modal-body">
         <div class="text-center">           

<div class="row">
<div class="col">cantidad</div>
<div class="col">nombre</div>
<div class="col">precio</div>
<div class="col">action</div>
</div>
<hr>

<div class="row">

<div class="col">
</div>
<div class="col">

</div>
<div class="col">

</div>
<div class="col">

</div>
 
	
</div>



         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a type="button" class="btn btn-blue waves-effect" data-dismiss="modal">Seguir Agregando</a>
         <a type="button" class="btn btn-success">Confirmar pedidos</a>
       </div>
     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Success-->






 <div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Carrito. Recuerde confirmar los pedidos.</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--Body-->
      <div class="modal-body">

        <table class="table table-hover">
          <thead style="background:#00c4ff7a;">
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio U</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php $total=0;foreach($r as $c):$total+=$c['precio']*$c['cantidad'];?>
            <tr>
              <td><?php echo $c['nombre'];?></td>
              <th style="white-space: nowrap;"><a href="php/updateCart.php?cantidad=<?php echo $c['cantidad']?>&id=<?php echo $c['idCarrito']?>&comando=menos" class="btn btn-danger btn-sm"><i style="font-size:15px;" class="fas fa-minus"></i></a> <input class="valorInput" id="<?php echo $c['idCarrito']?>" style="width:22px;border:0px;font-size:20px;" name="cantidad" value="<?php echo $c['cantidad']?>" type="number"><a href="php/updateCart.php?cantidad=<?php echo $c['cantidad']?>&id=<?php echo $c['idCarrito']?>&comando=mas" class="btn btn-sm btn-success"><i style="font-size:15px;" class="fas fa-plus"></i></a></th>
              <td style="white-space: nowrap;">$ <?php echo $c['precio'] ?></td>
              <td style="white-space: nowrap;">$ <?php echo $c['precio']*$c['cantidad']; ?></td>
              <td><a href="php/delfromcart.php?id=<?php echo $c["idCarrito"];?>"><i class="fas fa-times"></i></a></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total">
              <td>TOTAL</td>
              <th></th>
              <td></td>
              <td><?php echo $total;?></td>
              <td></td>
            </tr>
          </tbody>
        </table>

      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-blue" data-dismiss="modal">Seguir agregando</button>
        <a class="btn btn-success" href="pedirProductos.php?ip=<?php echo $ip?>">confirmar</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal: modalCart -->







    
</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<!-- <script src="mdbootstrap/css/all.min.js"></script> -->
<script src="js/js.js"></script>
<script src="../js/all.min.js"></script>


<script>
    // Write on keyup event of keyword input element
    $(document).ready(function(){
    $("#form91").keyup(function(){
    _this = this;
    // Show only matching TR, hide rest of them
    $.each($("#mytable tbody tr"), function() {
    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
    $(this).hide();
    else
    $(this).show();
    });
    });
   });


       
  document.getElementById("form91").focus({preventScroll:false});
/* habre un alert */
 /*  if(document.getElementById("alert")){
    setTimeout(() => {
      $("#alert").alert('close')
    }, 2000);
  } */

   </script>
<?php
if($contarCart['productos']>0){

	echo "<script>$('#modalCart').modal('show')</script>";

}
?>


<?php
 
/*  unset($_SESSION["addCart"]);
 */ 
?>
</html>