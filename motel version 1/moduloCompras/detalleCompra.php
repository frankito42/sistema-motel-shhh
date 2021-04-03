<?php
session_start();
require "../conection.php";
require "../chimichurri/trataFechas.php";


if(!isset($_SESSION['user'])){
header("location:login/login_v5/index.php");
}

$sqlEntradas="SELECT fE.`id`, fE.`idEntrada`,fE.idArticulo , a.`nombre`, fE.`cantidad`, fE.`fecha`, fE.`costo` FROM `facturaentrada` = fE
JOIN articulos = a on a.articulo=fE.idArticulo WHERE fE.`idEntrada`=:id";
$entradas=$conexion->prepare($sqlEntradas);
$entradas->bindParam(":id",$_GET['idEntrada']);
$entradas->execute();
$entradas=$entradas->fetchAll(PDO::FETCH_ASSOC);

$sqlTodosLosArticulos="SELECT * FROM `articulos`";
$articulos=$conexion->prepare($sqlTodosLosArticulos);
$articulos->execute();
$articulos=$articulos->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>Detalle compra</title>
    <link rel="stylesheet" type="text/css" href="../mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="../mdbootstrap/all.min.css">
	<link rel="stylesheet" href="../moduloCarrito/css/style.css">
</head>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Detalle compra</a>
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
              <a class="dropdown-item waves-effect waves-light" href="../compras.php">Compras</a>
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
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="admin-36" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="admin-36">
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
              <a class="dropdown-item waves-effect waves-light" href="../login/login_v5/php/cerrar.php">Cerrar Sesion</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    </header>
    <section>
    <div class="container">
    <div>
    <button class="btn aqua-gradient" data-toggle="modal" data-target="#centralModalSuccess">Añadir producto</button>


    </div>



    <table class="table table-hover">
    <thead style="background: #da70b9d1;">
    <tr>
    <th>Fecha</th>
    <th>Nombre</th>
    <th>Cantidad</th>
    <th>Costo</th>
    <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($entradas as $key):?>
    <tr id="entradaDetalle<?php echo $key['id']?>">
    <td style="white-space: nowrap;" ><?php echo fEntradaFrancisco($key['fecha'])?></td>
    <td><?php echo $key['nombre']?></td>
    <td><?php echo $key['cantidad']?></td>
    <td><?php echo $key['costo']?></td>
    <td><button data-toggle="modal" data-target="#editar<?php echo $key['id']?>" class="btn btn-blue btn-sm">Editar</button><a onclick="abrirModalBorrarDetalle(<?php echo $key['id']?>,<?php echo $key['cantidad']?>,<?php echo $key['idArticulo']?>,'<?php echo $key['nombre']?>')" class="btn btn-danger btn-sm">Eliminar</a></td>
    </tr>
    <?php require "modalEdit.php";?>
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
<script src="../moduloCompras/compras.js"></script>
<style>
li:hover{
    background:#33b5e5ab;
    color:white;
    border-radius: 8px;
}
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
    max-height: 300px !important;
    overflow-y: scroll;/*le pones scroll*/
}
.initialized{
  display:none;
}
.caret{
  display:none;
}
</style>
<!-- ////////////////////////////////////MODAL MODAL MODAL MODAL//////////////////////////////// -->
<!-- ////////////////////////////////////MODAL MODAL MODAL MODAL//////////////////////////////// -->
<!-- ////////////////////////////////////MODAL MODAL MODAL MODAL//////////////////////////////// -->
 <!-- Central Modal Medium Success -->
 <div class="modal fade" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div style="margin: 5.75rem auto !important;" class="modal-dialog modal-notify modal-success" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div style="margin-left: 5%;margin-right: 5%;margin-top: -5%;box-shadow: 0px 0px 20px 0px #00000073;" class="modal-header">
         <p style="padding: 3%;" class="heading lead">Añadir un producto</p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>
      <form action="addProductEntrada.php" method="post">
       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
         <input type="number" name="idEntradaNew" value="<?php echo $_GET['idEntrada']?>" style="display:none;">
         <input type="number" id="idDelArticuloSelect" name="idDelArticuloSelect" value="" style="display:none;">
         <select required onchange="tomarId2(this.value)" class="mdb-select md-form" searchable="Buscar">
            <option selected disabled>Selecciona un producto</option>
            <?php foreach ($articulos as $articulo):?>
            <option value="<?php echo $articulo['articulo']?>"><?php echo $articulo['nombre']?> (<?php echo "en stock: ".$articulo['cantidad']?>)</option>
           
            <?php endforeach?>
          </select>

          <div class="md-form">
            <input required type="number" name="cantidadNew" id="cantidadNew" value="" class="form-control">
            <label for="cantidadNew">Cantidad</label>
          </div>
          <div class="md-form">
            <input required type="number" name="costoNew" id="costoNew" value="" class="form-control">
            <label for="costoNew">Costo</label>
          </div>
          <div class="md-form">
            <input required type="number" name="precioNew" id="precioNew" value="" class="form-control">
            <label for="precioNew">Precio</label>
          </div>

         </div>
       </div>
       

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a type="button" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
         <button type="submit" class="btn btn-success">Guardar</button>
       </div>
       </form>
     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Success-->
<!-- ////////////////////////////////////MODAL MODAL MODAL MODAL//////////////////////////////// -->
<!-- ////////////////////////////////////MODAL MODAL MODAL MODAL//////////////////////////////// -->
<!-- ////////////////////////////////////MODAL MODAL MODAL MODAL//////////////////////////////// -->

</html>