<?php
session_start();
require "conection.php";
require "chimichurri/trataFechas.php";


if(!isset($_SESSION['user'])){
header("location:login/login_v5/index.php");
}

$sqlTodosLosArticulos="SELECT * FROM `articulos`";
$articulos=$conexion->prepare($sqlTodosLosArticulos);
$articulos->execute();
$articulos=$articulos->fetchAll(PDO::FETCH_ASSOC);



$sqlEntradas="SELECT * FROM `entrada`";
$entradas=$conexion->prepare($sqlEntradas);
$entradas->execute();
$entradas=$entradas->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>Compras</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Compras</a>
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
              <a class="dropdown-item waves-effect waves-light" href="compras.php">Compras</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="servicios-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="servicios-3">
              <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
              <a class="dropdown-item waves-effect waves-light" href="sexHotPanel.php">Sex Hot Panel</a>
              <a class="dropdown-item waves-effect waves-light" onclick="descargar()">Descargar App</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="admin-36" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="admin-36">
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
    <div class="row">
    <div class="col">
    <a class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#addEntradaProducto">Nueva entrada</a>
    </div>
    </div>



    <table class="table table-hover">
    <thead style="background: #da70b9d1;">
    <tr>
    <th>Fecha</th>
    <th>N° factura</th>
    <th>Observacion</th>
    <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($entradas as $key):?>
    <tr id="entrada<?php echo $key['idEntrada']?>">
    <td style="white-space: nowrap;" ><?php echo fEntradaFrancisco($key['fecha'])?></td>
    <td><?php echo $key['nFactura']?></td>
    <td><?php echo $key['observacion']?></td>
    <td><a href="moduloCompras/detalleCompra.php?idEntrada=<?php echo $key['idEntrada']?>" class="btn btn-blue">VER</a> <a onclick="abrirModalBorrar(<?php echo $key['idEntrada']?>,'<?php echo fEntradaFrancisco($key['fecha']);?>','<?php echo $key['nFactura'];?>','<?php echo $key['observacion'];?>')" class="btn btn-danger" hrefs="moduloCompras/borrarEntradaCompleta.php?idEntrada=">x</a></td>
    </tr>
    <?php endforeach?>
    </tbody>
    </table>
















    </div>
    <!-- ////////////////////////////////////////////////////////////////////// -->
    <!-- ////////////////////////////////////////////////////////////////////// -->
    <!-- ////////////////////////////////////////////////////////////////////// -->
    <!-- Modal -->
<div class="modal fade right" id="addEntradaProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form action="moduloCompras/AddNewEntrada.php" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">Entrada de productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div style="padding:0px;" class="modal-body">
     <div style="padding:2%;padding-bottom: 0px;" class="row">
      <div class="col">
        <div class="md-form">
          <input required type="text" id="form1" name="factura" class="form-control">
          <label for="form1">Numero de factura</label>
        </div>
      </div>
      <div class="col">
        <div class="md-form">
          <select required name="provedor" class="browser-default custom-select">
            <option selected disabled>Provedores</option>
            <option value="1">Quimes</option>
            <option value="1">MIller</option>
            <option value="1">Patagonia</option>
            <option value="1">SRL</option>
            <option value="1">Diarco</option>
          </select>
        </div>
      </div>
      <div class="col">
      <button class="btn btn-blue btn-sm">Nuevo Provedor</button>
      </div>
      </div>
      <div class="col">
        <div class="md-form">
        <textarea id="form7" name="observacion" class="md-textarea form-control" rows="1"></textarea>
        <label for="form7">Observaciones</label>
      </div>
      </div>
   
      <div class="col">
      <div class="md-form text-center">



          <select required onchange="addNewProductFrom(this.value)" class="mdb-select md-form" searchable="Buscar">
          <option value="" disabled selected>Productos</option>
          <?php foreach ($articulos as $key):?>
          <option value="<?php echo $key['articulo']?>"><?php echo $key['nombre']?> (<?php echo "en stock: ".$key['cantidad']?>)</option>
          <?php endforeach?>
          </select>



      </div>
        <!-- Shopping Cart table -->
        
        <table id="tablaEscondida" style="display:none;" class="table table-hover">
        <thead style="background:#00b8ffa3;">
        <th>imagen</th>
        <th>nombre</th>
        <th>cantidad</th>
        <th>costo</th>
        <th>Precio venta</th>
        <th></th>
        </thead>
        <tbody id="addProducto">
        </tbody>
        </table>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
    <!-- ////////////////////////////////////////////////////////////////////// -->
    <!-- ////////////////////////////////////////////////////////////////////// -->
    <!-- ////////////////////////////////////////////////////////////////////// -->
    </section>


</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
<script src="moduloCompras/compras.js"></script>
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

</html>