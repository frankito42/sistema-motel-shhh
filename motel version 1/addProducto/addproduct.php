<?php
session_start();
require "../conection.php";

 

$selcCategoria="SELECT * FROM `categoria`";
$allCategorias=$conexion->prepare($selcCategoria);
$allCategorias->execute();
$allCategorias=$allCategorias->fetchAll(PDO::FETCH_ASSOC);


$tipoArticulo="SELECT * FROM `tipoarticulos`";
$allTipoArticulo=$conexion->prepare($tipoArticulo);
$allTipoArticulo->execute();
$allTipoArticulo=$allTipoArticulo->fetchAll(PDO::FETCH_ASSOC);


$sqlTodosLosArticulos="SELECT * FROM `articulos`";
$articulos=$conexion->prepare($sqlTodosLosArticulos);
$articulos->execute();
$articulos=$articulos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>Añandir Producto</title>
    <link rel="stylesheet" type="text/css" href="../mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="../mdbootstrap/all.min.css">
	<link rel="stylesheet" href="../moduloCarrito/css/style.css">
</head>
<style>
.ir-arriba{
  display:none;
  background-repeat:no-repeat;
  font-size:20px;
  color:black;
  cursor:pointer;
  position:fixed;
  bottom:10px;
  right:10px;
  z-index:2;
}
.fa-stack-2x {
    font-size: 1em;
}
li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
</style>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Motel SHHH</a>
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
         <!--  <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="../moduloCarrito/categoriasComidas.php">Productos</a>
          </li> -->
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="productos-31" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Productos</a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="productos-31">
              <a class="dropdown-item waves-effect waves-light" href="addproduct.php">Añadir producto</a>
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
              <a class="dropdown-item waves-effect waves-light" href="../login/login_v5/php/cerrar.php">Cerrar Sesion</a>
            </div>
          </li>
        </ul>
        
      </div>
    </nav>
    </header>
    <section>
    <div style="margin-right: 100px;margin-left: 100px;">
 <!-- //////////////////////////////////////////////////////////////// -->
 <!-- //////////////////////////////////////////////////////////////// -->
 <!-- ///////////////boton volver arriba////////////////////////////////////// -->
 <a class="ir-arriba"  javascript:void(0) title="Volver arriba">
  <span class="fa-stack">
    <i class="fa fa-circle fa-stack-2x"></i>
    <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
  </span>
</a>
 <!-- //////////////////////////////////////////////////////////////// -->
 <!-- //////////////////////////////////////////////////////////////// -->
 <!-- //////////////////////////////////////////////////////////////// -->
    <?php

if (isset($_SESSION['message'])) {

  echo "<div id='mensajeEliminar' class='alert alert-dismissible alert-success' style='margin-top:20px;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['message']."
  </div>";
}
?>




  
  





    	<div class="row">
        <div class="row">
          <div class="col">
            <a href="#addnew" class="btn aqua-gradient" data-toggle="modal"><span class="fa fa-plus"></span> Nuevo Producto</a>
            <a href="#entradaProducto" data-toggle="modal" class="btn peach-gradient"><i class="fab fa-product-hunt"></i>  Entrada</a>
            <a href="exportarProductos.php" class="btn purple-gradient"><span class="fa fa-file-alt"></span>  Reporte</a>
          </div>
          <div class="col">
            <div class="md-form form-group">
              <i class="fa fa-search prefix"></i>
              <input type="text" id="form91" class="form-control validate">
              <label for="form91" >Nombre del producto</label>
          </div>
          </div>
		<div class="col-sm-12">
                               
			<table id="mytable" class="table table-hover " style="margin-top:20px;">
				<thead style="background: #19d6f5b0;">
				
					<th>ID</th>
					<th>Nombre</th>
					<th>Costo</th>
					<th style="white-space: nowrap;">Precio venta</th>
					<th>Descripcion</th>
					<th>Stock</th>
					<th>Img</th>
					<th>Acción</th>
				</thead>
				<tbody>
					<?php
						// incluye la conexión
						include_once('connection.php');

						$database = new Connection();
    					$db = $database->open();
						try{	
						    $sql = 'SELECT * FROM `articulos` ORDER BY `categoria`';
						    foreach ($db->query($sql) as $row) {
						    	?>
						    	<tr>
						    
						    		<td><?php echo $row['articulo']; ?></td>
						    		<td><?php echo $row['nombre']; ?></td>
						    		<td><?php echo "$".$row['costo']; ?></td>
						    		<td><?php echo "$".$row['precioVenta']; ?></td>
						    		<td><?php echo $row['descripcion']; ?></td>
						    		<td><?php echo $row['cantidad']; ?></td>
						    		<td>
                      <?php
                      if ($row["imagen"]=="") {
                        echo "no hay img";
                      }else{
                        echo "<img style='width: 200px;height:200px;' src='$row[imagen]' alt=''>";
                      }
                      ?>
                    </td>
						    		<td>
						    			<a href="#edit_<?php echo $row['articulo']; ?>" class="btn btn-sm" style="background-color:#1415178a;color:white;" data-toggle="modal"><span class="fa fa-edit"></span> Editar</a>
						    			<!-- <a href="#delete_<?php echo $row['articulo']; ?>" class="btn btn-danger btn-sm" data-toggle="modal"><span class="fa fa-trash"></span> Eliminar</a> -->
						    		</td>
						    		<?php include('edit_delete_modal.php'); ?>
						    	</tr>
						    	<?php 
						    }
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						//cerrar conexión
						$database->close();

					?>
				</tbody>
			</table>
		</div>
	</div>
</div> 






    </div>
    </section>




</body>
<script src="../mdbootstrap/js/jquery.min.js"></script>
<script src="../mdbootstrap/js/bootstrap.min.js"></script>
<script src="../mdbootstrap/js/mdb.min.js"></script>
<script src="../js/all.min.js"></script>
<script src="../js/js.js"></script>

<?php include('add_modal.php'); ?>
<?php unset($_SESSION['message'])?>
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

   $(document).ready(function(){ //Hacia arriba
  irArriba();
});

function irArriba(){
  $('.ir-arriba').click(function(){ $('body,html').animate({ scrollTop:'0px' },1000); });
  $(window).scroll(function(){
    if($(this).scrollTop() > 0){ $('.ir-arriba').slideDown(600); }else{ $('.ir-arriba').slideUp(600); }
  });
  $('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'1000px' },1000); });
}

   </script>

<!-- ////////ENTRADA DE PRODUCTO/////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////// -->
<div class="modal fade" id="entradaProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Nueva entrada de producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--Body-->
      <div class="modal-body">

        <table class="table table-hover">
          <thead>
            <tr>
              <th>Id</th>
              <th>Product name</th>
              <th>Cantidad</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($articulos as $key):?>
            <tr>
              <th scope="row"><?php echo $key['articulo']?></th>
              <td><?php echo $key['nombre']?></td>
              <td><input class="form-control" type="text"></td>
            </tr>
            <?php endforeach?>
          </tbody>
        </table>

      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary">Checkout</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal: modalCart -->

<!-- ////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////// -->

 
</html>