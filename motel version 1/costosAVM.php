<?php
require "conection.php";
$sql="SELECT * FROM `costos`";
$res=$conexion->prepare($sql);
$res->execute();
$res=$res->fetchAll(PDO::FETCH_ASSOC)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>costos</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
  <link rel="stylesheet" href="mdbootstrap/all.min.css">
  <style>

li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
</style>
</head>
<header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Costos</a>
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
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="servicios-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="servicios-3">
            <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
            <a class="dropdown-item waves-effect waves-light" href="sexHotPanel.php">Sex Hot Panel</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="admin-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="admin-3">
            <a class="dropdown-item waves-effect waves-light" href="costosAVM.php">costos</a>
            <a class="dropdown-item waves-effect waves-light" href="caja.php">Caja</a>
            </div>
          </li>
        </ul>
        
      </div>
    </nav>
    </header>
<body>
<section>
<div class="container">

<a class="btn btn-blue btn-lg" data-toggle="modal" data-target="#nuevoCosto">nuevo costo de habitacion</a>

<table class="table table-hover">
<thead>
<tr>
<th>Nombre</th>
<th>turno</th>
<th>monto 1</th>
<th>adicional</th>
<th>monto 2</th>
<th>estadia</th>
<th>hora salida estadia</th>
<th>monto 3</th>
<th>dormida</th>
<th>monto 4</th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach ($res as $key):?>
<tr>
<td><?php echo $key['nombre']?></td>
<td><?php echo $key['turno']?></td>
<td><?php echo $key['monto1']?></td>
<td><?php echo $key['adicional']?></td>
<td><?php echo $key['monto2']?></td>
<td><?php echo $key['estadia']?></td>
<td><?php echo $key['horaSalidaEstadia']?></td>
<td><?php echo $key['monto3']?></td>
<td><?php echo $key['dormida']?></td>
<td><?php echo $key['monto4']?></td>
<td><a class="btn btn-danger" href="moduloCostos/deleteCosto.php?id=<?php echo $key['costo']?>">Borrar</a></td>
</tr>
<?php endforeach?>
</tbody>
</table>
</div> 
</section>
<section>
<!-- //////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////MODAL DE AGREGAR COSTOS////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////// -->
<div class="modal fade" id="nuevoCosto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="moduloCostos/addCosto.php" method="post">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">completa el formulario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        
        

        <div class="row">
    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-5">
          <i class="fas fa-home prefix grey-text"></i>
          <input type="text" id="nombre" name="nombre" class="form-control validate">
          <label data-error="wrong" data-success="right" for="nombre">nombre</label>
        </div>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-5">
          <i class="far fa-clock prefix grey-text"></i>
          <input type="text" id="turno" name="turno" class="form-control validate">
          <label data-error="wrong" data-success="right" for="turno">turno</label>
        </div>
    </div>
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-5">
      <i class="fas fa-dollar-sign prefix grey-text"></i>
          <input type="number" name="monto1" id="monto1" class="form-control validate">
          <label data-error="wrong" data-success="right" for="monto1">monto</label>
        </div>
    </div>
    <!-- Grid column -->
  </div>


        
        

        <div class="row">
    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="far fa-clock prefix grey-text"></i>
          <input type="text" id="adicional" name="adicional" class="form-control validate">
          <label data-error="wrong" data-success="right" for="adicional">adicional</label>
        </div>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="fas fa-dollar-sign prefix grey-text"></i>
          <input type="number" id="monto2" name="monto2" class="form-control validate">
          <label data-error="wrong" data-success="right" for="monto2">monto 2</label>
        </div>
    </div>
    <!-- Grid column -->
  </div>




        
        
        


        <div class="row">
    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <input type="text" id="estadia" name="estadia" class="form-control validate">
          <label data-error="wrong" data-success="right" for="estadia">estadia</label>
        </div>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="far fa-clock prefix grey-text"></i>
          <input type="text" id="horaSalidaEstadia" name="horaSalidaEstadia" class="form-control validate">
          <label data-error="wrong" data-success="right" for="horaSalidaEstadia">hora salida</label>
        </div>
    </div>

    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="fas fa-dollar-sign prefix grey-text"></i>
          <input type="number" id="monto3" name="monto3" class="form-control validate">
          <label data-error="wrong" data-success="right" for="monto3">monto 3</label>
        </div>
    </div>
    <!-- Grid column -->
  </div>



        
        



        <div class="row">
    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <input type="text" id="dormida" name="dormida" class="form-control validate">
          <label data-error="wrong" data-success="right" for="dormida">dormida</label>
        </div>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col">
      <!-- Material input -->
      <div class="md-form mb-4">
          <i class="fas fa-dollar-sign prefix grey-text"></i>
          <input type="number" id="monto4" name="monto4" class="form-control validate">
          <label data-error="wrong" data-success="right" for="monto4">monto 4</label>
        </div>
    </div>
    <!-- Grid column -->
  </div>

      </div>
      <div class="modal-footer d-flex justify-content-left">
        <button type="submit" class="btn btn-deep-orange">guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- //////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////// -->
</section>
    
</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
</html>