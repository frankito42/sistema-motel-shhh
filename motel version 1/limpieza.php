<script>
setInterval(() => {
fetch('preguntaEstado.php?id='+<?php echo $_GET['id'];?>)
  .then(response => response.json())
  .then((data)=>{
    console.log(data.estado)
    if(data.estado!="limpieza"){
      location.href="index.php"
    }  
  });
}, 3000);
</script>
<?php
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires'); 
require "conection.php";





$selec="SELECT `habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado` FROM `habitaciones` WHERE habitacion=:id";
$habitacion=$conexion->prepare($selec);
$habitacion->bindParam(":id",$_GET['id']);
$habitacion->execute();
$habitacion=$habitacion->fetch(PDO::FETCH_ASSOC);





$movtemSelect="SELECT `id`, `id2`, `codigo`, `habitacion`, `fechaActS1`, `horaActS1`, `horaActS2`, `horaDesActS2`, `horaActS3`, `horaDesActS3`, `fechaDesActS1`, `horaDesActS1`, `S1`, `S2`, `S3` FROM `movtemp` WHERE habitacion=:id";
$movtem=$conexion->prepare($movtemSelect);
$movtem->bindParam(":id",$_GET['id']);
$movtem->execute();
$movtem=$movtem->fetch(PDO::FETCH_ASSOC);







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motel</title>
    <link rel="stylesheet" type="text/css" href="mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="mdbootstrap/all.min.css">
	<link rel="stylesheet" href="moduloCarrito/css/style.css">
</head>
<body style="background:#3C3B3BFE;">
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
      <a class="navbar-brand" href="#">Motel VIP</a>
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
         <!--  -->
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
<section>
<div class="container">
<?php

if (isset($_SESSION['message2'])) {

  echo "<div id='editadoCorrecto' class='alert alert-dismissible alert-success' style='margin-top:20px;'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>"
    .$_SESSION['message2']."
  </div>";
}
?>


<div style="border-radius: 10px;background: #2bbbada8;box-shadow: 0px 5px 30px 10px #0000007a;" class="container my-5 p-5  animated pulse">


  <!--Section: Content-->
  <section class="text-center black-text">

    <!-- Section heading -->
    <h2 style="font-size:50px;" class="font-weight-bold mb-4 pb-2 text-uppercase"><?php echo $habitacion['nombre']." se encuentra en liempieza"?></h2>
    <!-- Section description -->
    <!-- Grid row -->
    <!-- Grid row -->

  </section>
  <!--Section: Content-->
  <div style="width:40%;float:left;">
 
   <a id="finLimpieza" class="btn btn-blue btn-lg">FIN DE LIMPIEZA</a>
   
  

   
  </div>

  <div style="width:40%;float:right;">
      

      
      <!-- <a class="btn btn-success btn-lg">aaaaaa</a> -->
 
  </div>
<br style="clear:both;">
</div>


</section>




</body>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script src="js/all.min.js"></script>
<script src="js/js.js"></script>
<?php unset($_SESSION['message2'])?>

<script>
document.getElementById("finLimpieza").addEventListener("click",()=>{
  document.getElementById('finLimpieza').disabled =true
     let ipArduino="<?php echo $habitacion['dirip']?>"
     
    /* $.ajax({
        url:"http://"+ipArduino+"/?LP1"
    }).fail(()=>{
        
    }) */ //AJAX TAMBIEN FUNCIONA PARA COMUNICARME CON EL ARDUINO 
    /* console.log(ipArduino) */
    let param={"ipArduino":ipArduino}
    $.ajax({
        data:param,
        url:"moduloLimpieza/ajaxEstado.php",
        success:(e)=>{
            if (e=="bien") {
                $.get("http://"+ipArduino+"/?LP1")
                console.log("bien")
                setTimeout(() => {
                location.href="index.php"
                }, 1800);
            }else{
                console.log(e)
            }
        }
    })

})


</script>
<style>

li:hover{
  background:#33b5e5ab;
  color:white;
  border-radius: 8px;
}
</style>
</html>