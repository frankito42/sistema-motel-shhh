<?php
header("refresh:15");
session_start();
require "conection.php";

$arrayDeHabitacionesPedidos=[];
$sqlHabitaciones="SELECT * FROM habitaciones";

/* SELECT c.`idCarrito`,h.`nombre` as nombreHabitacion,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos  = c 
INNER JOIN articulos = a on a.`articulo` = c.`articulo`
INNER JOIN habitaciones = h on h.`ip_tablet` = c.habitacion ORDER BY c.habitacion */


/* SELECT h.`nombre`,a.nombre as producto,c.cantidad,c.precio FROM `habitaciones`= h
INNER JOIN carritos =c ON c.habitacion=h.ip_tablet
INNER JOIN articulos=a on a.articulo=c.articulo
 */
$habitaciones=$conexion->prepare($sqlHabitaciones);
$habitaciones->execute();
$habitaciones=$habitaciones->fetchAll(PDO::FETCH_ASSOC);

/* echo "<pre>";
print_r($habitaciones);
echo "</pre>"; */



$sqlEstado="SELECT DISTINCT h.`ip_tablet`,c.`estadoProducto` FROM `habitaciones`= h INNER JOIN carritos =c ON c.habitacion=h.ip_tablet and c.estadoProducto='sex'";
$estado=$conexion->prepare($sqlEstado);
$estado->execute();
$estado=$estado->fetchAll(PDO::FETCH_ASSOC);
/* print_r($estado); */
/* echo "<pre>";
print_r($estado);
echo "</pre>"; */
/* $pedidos=[array=>"habitacion"()];

foreach ($cocina as $key) {
  

    array_push($pedidos['habitacion'],$key['nombreHabitacion']);
 
}
print_r($pedidos); */
/* print_r($estado);
echo "<pre>";
print_r($habitaciones);
echo "</pre>"; */

$nombre="Pedidos SEX HOT TOYS!";
$pedidos="";
if (isset($_GET['ip'])) {

  $movSql="SELECT * FROM `habitaciones` = h 
  INNER JOIN movtemp = m on h.`habitacion`=m.`habitacion` AND m.id2=0 AND h.`ip_tablet`=:ip_tablet";
  $mov=$conexion->prepare($movSql);
  $mov->bindParam(":ip_tablet",$_GET['ip']);
  $mov->execute();
  $mov=$mov->fetch(PDO::FETCH_ASSOC);


  $nombre=$_GET['nombre'];

  $estadito="sex";
  $sqlPedidos="SELECT c.idCarrito ,a.`nombre`,c.`cantidad`,c.`precio`,c.habitacion, a.categoria FROM carritos  = c 
  INNER JOIN articulos = a on a.`articulo` = c.`articulo`WHERE c.`idMovtemp`=:idMovtemp and c.estadoProducto=:estadito";
  $pedidos=$conexion->prepare($sqlPedidos);
  $pedidos->bindParam(":idMovtemp",$mov['id']);
  $pedidos->bindParam(":estadito",$estadito);
  $pedidos->execute();
  $pedidos=$pedidos->fetchAll(PDO::FETCH_ASSOC);
  $_SESSION['arrayDeArticulosDeCocina']=$pedidos;
}







?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motel</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
  <link rel="stylesheet" href="moduloCarrito/css/style.css">
  <style>

li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
</style>
</head>
<body style="background: #3C3B3BFE;">
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">SEX HOT</a>
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
         <!--  <li class="nav-item">
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
    <section> 
    <div style="width: 50%; float:left">
  <div style="width: 95%;margin-left: 2%;background: #0c63d06b;" class="card">
      <div class="card-body text-white">
      <h2 style="color: #43d9ff;font-size:350%;"><?php echo $nombre?></h2>
        <?php 
        if ($pedidos==null) {
          
        }else{

        
        
        foreach ($pedidos as $pedido ):?>
        <?php 
        
        ?>
        <h3><?php echo $pedido['nombre']." X".$pedido['cantidad'];?></h3>
       
        <?php endforeach;?>
          <a href="sexHot/listoHot.php?ip=<?php echo $_GET['ip']."&habitacion=".$nombre?>" class="btn btn-success">listo</a>
          <a href="moduloTicket/index.php?ip=<?php echo $_GET['ip']."&habitacion=".$nombre?>&comando=sex" class="btn btn-success">Imprimir ticket</a>
        <?php }?>
  
      </div>
  </div>
</div>

<div style="width: 50%; float:right;">
   <div style="width: 90%;background: darkslategrey;" class="card">
   <div id="divClick" class="card-body">


<?php 
$boton="";
$vandera=1;
foreach ($habitaciones as $key):



        foreach ($estado as $esta) {
          if ($esta['ip_tablet']==$key['ip_tablet']) {
            

              if ($esta['estadoProducto']=="sex") {
                if($key['sex']==""){
                  $si="si";
                  $sexSql="UPDATE `habitaciones` SET `sex`=:si WHERE `habitacion`=:habitacion";
                  $executesSex=$conexion->prepare($sexSql);
                  $executesSex->bindParam(":si",$si);
                  $executesSex->bindParam(":habitacion",$key['habitacion']);
                  $executesSex->execute();
                  array_push($arrayDeHabitacionesPedidos,"nuevo pedido para la ".$key['nombre']);
  
                  }

                
                $boton.="<a href='sexHotPanel.php?ip=".$key['ip_tablet']."&nombre=".$key['nombre']."' id=".$key['ip_tablet']." class='btn colorAmarillo' style='background-color:#00c851;color:white;'>".$key['nombre']."</a>";
                
                $vandera=2;
              } 
          
          
          }

          
        }
        if ($vandera==1) {
          
          $boton.="<a href='sexHotPanel.php?ip=".$key['ip_tablet']."&nombre=".$key['nombre']."' id=".$key['ip_tablet']." class='btn disabled' style='background-color:#343535;color:white;'>".$key['nombre']."</a>";
        }
        $vandera=1;




endforeach;




echo $boton;
?>


<?php

if(isset($_SESSION["mensaje"])){

	echo "<div class='modal fade' id='add' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
            	<center><h4 class='modal-title' id='myModalLabel'>Motel</h4></center>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            </div>
            <div class='modal-body'>	
            	<h5 class='text-center'>Un pedido listo! para la habitacion <b style='font-size:30px;'>".$_SESSION["mensaje"]."</b></h5>
			
			</div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-blue' data-dismiss='modal'><span class='fa fa-close'></span> Cerrar</button>
            </div>

        </div>
    </div>
</div>";

}

?>
  
   </div>
   </div>
</div>
    
    
    
    
    </section>

</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>

<script src="js/js.js"></script>
<script src="js/cocina.js"></script>
<script src="js/all.min.js"></script>


<?php 
echo"<script>$('#add').modal('show')</script>";
unset($_SESSION['mensaje']);
$arrayCocina=json_encode($arrayDeHabitacionesPedidos);
?>

<script>

localStorage.setItem("sex", <?php echo json_encode($arrayCocina)?>)

console.log(JSON.parse(localStorage.getItem("sex")))


JSON.parse(localStorage.getItem("sex")).forEach(async (element)=> {
  console.log(element)
    let mensaje = new SpeechSynthesisUtterance();
    mensaje.volume = 1;
    mensaje.rate = 1;
    mensaje.text = element;
    mensaje.pitch = 1;
    speechSynthesis.speak(mensaje);
});

</script>

</html>