<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires'); 
require "conection.php";



$fecha=date("Y-m-d");
$fecha=$fecha."%";


if(isset($_POST['filtro'])){

  $fechaInicial=$_POST['fechaI'];
  $fechaFin=$_POST['fechaF'];
  $fechaInicial=explode("T",$fechaInicial);
  $fechaFin=explode("T",$fechaFin);
  $fechaInicial=$fechaInicial[0]." ".$fechaInicial[1];
  $fechaFin=$fechaFin[0]." ".$fechaFin[1];
 /*  echo $fechaInicial."<br>";
  echo $fechaFin."<br>"; */
  $sqlCaja="SELECT c.`idCaja`, c.`total`, c.`cajaFuerte`, c.`idMovtemp`,m.fechaActS1,m.horaActS1,h.nombre, u.user, c.horaCaja FROM `cajas` = c JOIN movtemp = m on c.`idMovtemp`=m.`id` JOIN habitaciones = h on m.habitacion=h.habitacion join usuarios = u on c.idUser=u.idUser WHERE u.user=:user AND c.horaCaja BETWEEN :fechaI AND :fechaF";
  $caja=$conexion->prepare($sqlCaja);
  $caja->bindParam(":user",$_SESSION['user']['user']);
  $caja->bindParam(":fechaI",$fechaInicial);
  $caja->bindParam(":fechaF",$fechaFin);
  $caja->execute();
  $caja=$caja->fetchAll(PDO::FETCH_ASSOC);

}else{
  $sqlCaja="SELECT c.`idCaja`, c.`total`, c.`cajaFuerte`, c.`idMovtemp`,m.fechaActS1,m.horaActS1,h.nombre, u.user, c.horaCaja FROM `cajas` = c JOIN movtemp = m on c.`idMovtemp`=m.`id` JOIN habitaciones = h on m.habitacion=h.habitacion join usuarios = u on c.idUser=u.idUser WHERE u.user=:user /* AND c.horaCaja like :fecha */";
  $caja=$conexion->prepare($sqlCaja);
  $caja->bindParam(":user",$_SESSION['user']['user']);
  /* $caja->bindParam(":fecha",$fecha); */
  $caja->execute();
  $caja=$caja->fetchAll(PDO::FETCH_ASSOC);
}






/* print_r($movtem); */
/* $sqlcontador="SELECT SUM(`cantidad`*`precio`) as total, COUNT(cantidad) as productos FROM carritos WHERE idMovtemp=:idMovtemp";

$contarCart=$conexion->prepare($sqlcontador);

$contarCart->bindParam(":idMovtemp",$movtem['id']);
$contarCart->execute();
$contarCart=$contarCart->fetch(PDO::FETCH_ASSOC);


$sqlCarrito="SELECT c.`idCarrito`,c.`habitacion`,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos = c
INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.idMovtemp=:idMovtemp";

$carrito=$conexion->prepare($sqlCarrito);

$carrito->bindParam(":idMovtemp",$movtem['id']);
$carrito->execute();
$carrito=$carrito->fetchAll(PDO::FETCH_ASSOC); */

/* print_r($carrito); */



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">CAJA </a>
      <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3" aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="index.php">Habitaciones
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="productos-31" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Productos</a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="productos-31">
              <a class="dropdown-item waves-effect waves-light" href="addProducto/addproduct.php">Añadir producto</a>
              <a class="dropdown-item waves-effect waves-light" href="combos.php">Combos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-3">
            <a class="dropdown-item waves-effect waves-light" href="cocina.php">Cocina</a>
            <a class="dropdown-item waves-effect waves-light" href="sexHotPanel.php">Sex Hot Panel</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin
            </a>
            <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-3">
            <a class="dropdown-item waves-effect waves-light" href="costosAVM.php">costos</a>
            <a class="dropdown-item waves-effect waves-light" href="caja.php">Caja</a>
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
<form action="" method="post">
<div class="row">
<div class="col">
<div class="md-form">
  <input type="datetime-local" value="<?php echo $_POST['fechaI']?>" required placeholder="Fecha Inicio" name="fechaI" id="form1" class="form-control">
</div>
</div>
<div class="col">
<div class="md-form">
  <input type="datetime-local" value="<?php echo $_POST['fechaF']?>" required placeholder="Fecha fin" name="fechaF" id="fechaFin" class="form-control">
</div>
</div>
<div class="col">
<button type="submit" name="filtro" class="btn btn-success btn-lg">Buscar</button>
</div>
</div>
</form>
<table class="table table-hover">
<thead style="background: #19d6f5b0;">
<tr>
<th>Contador</th>
<th>Nro ticket</th>
<th>Usuario</th>
<th>Habitacion</th>
<th>Fecha de inicio</th>
<th>Hora de inicio</th>
<th>Fecha y Hora de pago</th>
<th>Detalles</th>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php $total=0;$id=0; foreach ($caja as $key): $total+=$key['total']; $id++?>
<tr>
<td><?php echo $id;?></td>
<td><?php echo $key['idMovtemp'];?></td>
<td><?php echo $key['user'];?></td>
<td><?php echo $key['nombre'];?></td>
<td><?php echo $key['fechaActS1'];?></td>
<td><?php echo $key['horaActS1'];?></td>
<td><?php echo $key['horaCaja'];?></td>
<td><a href="detallesCaja.php?idMov=<?php echo $key['idMovtemp']?>" class="btn aqua-gradient">Ver</a></td>
<td><?php echo "$".$key['total'];?></td>
</tr>
<?php endforeach?>
<tr>
<td style="background:#1dff1dcc;" colspan="8">TOTAL</td>
<td style="background:#1dff1dcc;"><?php echo "$".$total;?></td>
</tr>
</tbody>
</table>


</div>
</section>

<style>

li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
</style>
</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>

</html>