<?php
session_start();
require "../conection.php";


/* ///////NOTIFICACION DE PEDIDOS DE LAS HABITACIONES//////// */
/* ////////////////////////////////////////////////////////// */
/* ////////////////////////////////////////////////////////// */
/* ////////////////////////////////////////////////////////// */
$estadito="cocina";
$sqlPedidos="SELECT c.idCarrito ,a.`nombre` as nombreArticulo,c.`cantidad`,c.`precio`,h.nombre, a.categoria 
            FROM carritos = c 
            INNER JOIN articulos = a on a.`articulo` = c.`articulo` 
            JOIN habitaciones = h on h.ip_tablet=c.habitacion 
            WHERE c.estadoProducto=:estadito OR c.estadoProducto='sex'";
$pedidos=$conexion->prepare($sqlPedidos);
$pedidos->bindParam(":estadito",$estadito);
$pedidos->execute();
$pedidos=$pedidos->fetchAll(PDO::FETCH_ASSOC);


$sqlPedidosPendientes="SELECT c.idCarrito ,a.`nombre` as nombreArticulo,c.`cantidad`,c.`precio`,h.nombre, a.categoria 
FROM carritos = c 
INNER JOIN articulos = a on a.`articulo` = c.`articulo` 
JOIN habitaciones = h on h.ip_tablet=c.habitacion 
WHERE c.estadoProducto='pendiente'";
$pedidosPendientes=$conexion->prepare($sqlPedidosPendientes);
$pedidosPendientes->execute();
$pedidosPendientes=$pedidosPendientes->fetchAll(PDO::FETCH_ASSOC);
/* ////////////////////////////////////////////////////////// */
/* ////////////////////////////////////////////////////////// */
/* ////////////////////////////////////////////////////////// */
/* ////////////////////////////////////////////////////////// */









$habitSql="SELECT h.`habitacion`, `dirip`, `letra`, `nombre`, `descripcion`, `costo`, `ip_tablet`, `estado`,m.fechaActS1,m.horaActS1,sonido1,sonido2,cocina,cobrando FROM `habitaciones`= h LEFT OUTER JOIN movtemp = m on h.habitacion =m.habitacion and m.id2!=m.id ORDER BY h.habitacion";
$todasLasHabitaciones=$conexion->prepare($habitSql);
$todasLasHabitaciones->execute();
$todasLasHabitaciones=$todasLasHabitaciones->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['todasLasHabitaciones']=$todasLasHabitaciones;
$arrayDeSonidosOcupados=[];
$arrayCocheras=[];
$arrayCobrando=[];
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">
    
    <title>motel</title>
    <link rel="stylesheet" href="moduloHabitaciones/css/estilos.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
    
     
    <div class="container">
       <?php $contador=0; foreach ($_SESSION['todasLasHabitaciones'] as $key):$contador=$contador+1;?>
        <a href="detalleHabitacion.php?id=<?php echo $key['habitacion']?>">
        <div style="border: 3px solid;background:#000000a3;" class="card cuadradito  contenedor">
        <?php if ($key['estado']=="disponible"){?>
            <!-- <img src="moduloHabitaciones/IMAGENES/FONDO_LIBRE1.png"  > -->
            <i style="height: 180px;width:215px;color:#116b35c9;" class="fas fa-home"></i>
            <!-- <i style="height: 180px;width:215px;" class="fas fa-house-user"></i> -->
        <?php } ?>
        <?php if ($key['estado']=="ocupada"){
                /*AQUI ENTRA SOLO SI LA DB ESTA VACIA EN SONIDO2  */
                if($key['sonido2']==""){ 
                    /* PONGO UN SI EN LA DB PARA QUE ENTRE UNA SOLA VEZ EN ESTE IF */    
                    $si="si";
                    $sensorGarajeSql="UPDATE `habitaciones` SET `sonido2`=:si WHERE `habitacion`=:habitacion";
                    $executeSensor1=$conexion->prepare($sensorGarajeSql);
                    $executeSensor1->bindParam(":si",$si);
                    $executeSensor1->bindParam(":habitacion",$key['habitacion']);
                    $executeSensor1->execute();

                    /* TEXTO DE HABITACION OCUPADA */
                    $_SESSION['ocupada']=$key['nombre']." ocupada";
                    /* ARRAY DONDE VOY METIENDO LOS TEXTOS QUE EL DISPOSITIVO LEE */
                    array_push($arrayDeSonidosOcupados,$_SESSION['ocupada']);
                }
            
            ?>
            <!-- <img src="moduloHabitaciones/IMAGENES/FONDO_OCUPADO1.png" style="height: 180px;width:215px;" > -->
            <i class="fas fa-house-user" id="<?php echo $key['habitacion']?>" style="color:#820808;height: 180px;width:143px;"></i>
        <?php } ?>
        <?php if ($key['estado']=="cobrando"){?>
            <?php
                /*AQUI ENTRA SOLO SI LA DB ESTA VACIA EN SONIDO2  */
                if($key['cobrando']==""){ 
                    /* PONGO UN SI EN LA DB PARA QUE ENTRE UNA SOLA VEZ EN ESTE IF */    
                    $si="si";
                    $cobrandoSql="UPDATE `habitaciones` SET `cobrando`=:si WHERE `habitacion`=:habitacion";
                    $cobrando=$conexion->prepare($cobrandoSql);
                    $cobrando->bindParam(":si",$si);
                    $cobrando->bindParam(":habitacion",$key['habitacion']);
                    $cobrando->execute();

                    /* TEXTO DE HABITACION OCUPADA */
                    $_SESSION['cobrando']=$key['nombre']." solicita su  cuenta.";
                    /* ARRAY DONDE VOY METIENDO LOS TEXTOS QUE EL DISPOSITIVO LEE */
                    array_push($arrayCobrando,$_SESSION['cobrando']);
                }    
                
            ?>
            <!-- <img src="moduloHabitaciones/IMAGENES/paytarget.gif" style="opacity: 0.5;height: 145px;width: 218px;" > -->
            <i class="far fa-money-bill-alt" id="<?php echo $key['habitacion']?>" style="color: #717800;height: 176px;width: 145px;"></i>

        <?php } ?>
        <?php if ($key['estado']=="MP"){?>
            <!-- <img src="moduloHabitaciones/IMAGENES/FONDO_CUENTA.png" style="height: 180px;width:215px;" > -->
            <i class="far fa-money-bill-alt" style="color: #717800;height: 176px;width: 145px;"></i>
        <?php } ?>
        <?php if ($key['estado']=="limpieza"){?>
            <img src="moduloHabitaciones/IMAGENES/mucamahot.png" style="opacity: 0.9;height: 172px;" >
        <?php } ?>
        <?php if ($key['estado']=="verificacion2"){?>
            <!-- <img src="moduloHabitaciones/IMAGENES/ver2.gif" style="opacity: 0.5;height: 175px;width: 100%;" > -->
            <i class="far fa-check-circle" style="color:#480b57;height: 175px;width: 43%;"></i>
        <?php } ?>
        <?php if ($key['estado']=="necesita limpieza"){?>
            <img src="moduloHabitaciones/IMAGENES/valde2.png" style="opacity: 0.5;height: 200px;width: 181px;" >
        <?php } ?>
        <?php if ($key['estado']=="enviar cuenta"){?>
            <!-- <img src="moduloHabitaciones/IMAGENES/FONDO_OCUPADO1.png" style="height: 180px;width:215px;" > -->
            <i class="fas fa-house-user" style="color:#820808;height: 180px;width:143px;"></i>
        <?php } ?>
        <?php if ($key['estado']=="coche"){
            /*AQUI ENTRA SOLO SI LA DB ESTA VACIA EN SONIDO1  */
                    if($key['sonido1']==""){
                        /* PONGO UN SI EN LA DB PARA QUE ENTRE UNA SOLA VEZ EN ESTE IF */ 
                        $si="si";
                        $sensorGarajeSql="UPDATE `habitaciones` SET `sonido1`=:si WHERE `habitacion`=:habitacion";
                        $executeSensor1=$conexion->prepare($sensorGarajeSql);
                        $executeSensor1->bindParam(":si",$si);
                        $executeSensor1->bindParam(":habitacion",$key['habitacion']);
                        $executeSensor1->execute();
                        /* TEXTO DE HABITACION COCHERA */
                        $_SESSION['cochera']=$key['nombre']." cochera";
                        /* ARRAY DONDE VOY METIENDO LOS TEXTOS QUE EL DISPOSITIVO LEE */
                        array_push($arrayCocheras,$_SESSION['cochera']);
            }
                    echo '<img src="moduloHabitaciones/IMAGENES/FONDO_COCHE.png" style="height: 180px;width:215px;">';

        }?>
        <div class="texto-encima"><h4 style="font-size: 30px;">
        
        <?php if($contador==12){
            echo "<span style='background:#050505c4;border-radius: 10px;padding: 3px;'>Kiosco shhh<span>";
        }else{
            echo $contador;
        }?>
        
        </h4></div>
        <div class="centrado"><h5 style="margin: 0px;font-size: 160%;text-shadow: 0 0 20px black;" class="h5"><?php if($key['estado']=="enviar cuenta") {
            echo "ocupada";
        }else{
            echo $key['estado'];
        }?></h5></div>
        <?php if($contador==12){?>
            
        <?php }else{?>
            <div class="centrado2"><h5 class="" style="font-size: 200%;background: #0000009e;border-radius: 4px;"><?php echo $key['horaActS1']?></h5></div>
        <?php } ?>
        
        </div></a>
        <?php endforeach;
         $arrayDeSonidosOcupados=json_encode($arrayDeSonidosOcupados);
         $arrayCocheras=json_encode($arrayCocheras);
         $arrayCobrando=json_encode($arrayCobrando);
        /* echo $arrayDeSonidosOcupados; */
        
        ?>
        <button href="#addnew" data-toggle="modal" class="btn btn-blue anadir">añadir habitacion</button>
    </div>
    
<!-- <script src="moduloHabitaciones/js/js.js"></script> -->
<!-- ////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////// -->
<!-- Modal -->
<div class="modal fade right" id="modalPedidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" data-backdrop='false'>
  <div class="modal-dialog modal-side modal-bottom-right" role="document">
    <div style="background: #dee2e6fa;" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">Tienen pedidos en cocina</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php foreach ($pedidos as $key):?>
        <h5 id="entregra<?php echo $key['idCarrito']?>"><?php echo $key['nombre']." <span style='background:#7878d9;border-radius:7px;color:white;text-shadow: 0 0 15px black;'>".$key['nombreArticulo']."</span>"." x".$key['cantidad']?> <button  onclick="entregado(<?php echo $key['idCarrito']?>)" class="btn btn-success btn-sm">Entregado</button></h5>
        <?php endforeach?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<!-- ////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////// -->
 
<div class="modal fade left" id="pedidoPendiente" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" data-backdrop='false'>
  <div class="modal-dialog modal-side modal-bottom-left" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">Pedidos pendientes ATECION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php foreach ($pedidosPendientes as $key):?>
        <h5><?php echo $key['nombre']." <span style='background:#7878d9;border-radius:7px;color:white;text-shadow: 0 0 15px black;'>".$key['nombreArticulo']."</span>"." x".$key['cantidad']?></h5>
        <?php endforeach?>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




<!-- ////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////// -->
</body>
<style>
.contenedor{
    position:relative;
    display:inline-block;
    text-align:center;
}
.texto-encima{
    position:absolute;
    top:7px;
    left:8px;
    color: #ada8a8;

}
.centrado{
    position: absolute;
    top: 86%;
    left: 50%;
    transform: translate(-50%,-50%);
    color: white;
    background: #0000009e;
    padding: 2%;
    border-radius: 15px;
}
.centrado2{
    position:absolute;
    top: 15%;
    left: 20%;;
   
    color: #ada8a8;
}

</style>



<script>

    /* GUARDO EN LOCALSTORAGE //cobrando// UN ARRAY EN FORMATO JSON */
    localStorage.setItem("cobrando", <?php echo json_encode($arrayCobrando)?>)
    /* MUESTRO EN COSOLA LO QUE GUARDE DESIFRANDO EL JSON */
    console.log(JSON.parse(localStorage.getItem("cobrando")))
    /* GUARDO EN LOCALSTORAGE //OCUPADAS// UN ARRAY EN FORMATO JSON */
    localStorage.setItem("ocupadas", <?php echo json_encode($arrayDeSonidosOcupados)?>)
    /* MUESTRO EN COSOLA LO QUE GUARDE DESIFRANDO EL JSON */
    console.log(JSON.parse(localStorage.getItem("ocupadas")))

    /* GUARDO EN LOCALSTORAGE //COCHERA// UN ARRAY EN FORMATO JSON */
    localStorage.setItem("cochera", <?php echo json_encode($arrayCocheras)?>)
    /* MUESTRO EN COSOLA LO QUE GUARDE DESIFRANDO EL JSON */
    console.log(JSON.parse(localStorage.getItem("cochera")))

    /* PARSEO EL JSON PARA CONVERTIRNO NUEVAMENTE EN UN ARRAY Y LO RECCORRO CON UN FOREACH */
    JSON.parse(localStorage.getItem("cobrando")).forEach(async (element)=> {
        /* AQUI HAGO QUE EL DISPOSITIVO HABLE */
        let mensaje = new SpeechSynthesisUtterance();
        mensaje.volume = 1;
        mensaje.rate = 1;
        mensaje.text = element; //TEXTO QUE DICE EL DISPOSITIVO 
        mensaje.pitch = 1;
        await speechSynthesis.speak(mensaje); //AQUI LE HAGO HABLAR A LA PC
        /* REPITE UNA SOLA VEZ */
    });
    /* PARSEO EL JSON PARA CONVERTIRNO NUEVAMENTE EN UN ARRAY Y LO RECCORRO CON UN FOREACH */
    JSON.parse(localStorage.getItem("ocupadas")).forEach(async (element)=> {
        /* AQUI HAGO QUE EL DISPOSITIVO HABLE */
        let mensaje = new SpeechSynthesisUtterance();
        mensaje.volume = 1;
        mensaje.rate = 1;
        mensaje.text = element; //TEXTO QUE DICE EL DISPOSITIVO 
        mensaje.pitch = 1;
        await speechSynthesis.speak(mensaje); //AQUI LE HAGO HABLAR A LA PC
        /* REPITE UNA SOLA VEZ */
    });

    /* PARSEO EL JSON PARA CONVERTIRNO NUEVAMENTE EN UN ARRAY Y LO RECCORRO CON UN FOREACH */
    JSON.parse(localStorage.getItem("cochera")).forEach(async (element)=> {
        /* AQUI HAGO QUE EL DISPOSITIVO HABLE */
        let mensaje = new SpeechSynthesisUtterance();
        mensaje.volume = 1;
        mensaje.rate = 1;
        mensaje.text = element; //TEXTO QUE DICE EL DISPOSITIVO 
        mensaje.pitch = 1;
        await speechSynthesis.speak(mensaje);
        /* REPITE UNA SOLA VEZ */
    });
    
</script>

<!-- CARGO EL SONIDO DEL PEDIDO -->
<audio src="moduloHabitaciones/1.mp3" id="sonido"></audio>

<!-- ESTA PARTE SOLO CARGA SI HAY UN PEDIDO -->
<?php if($pedidos!=null){?>
    <script>
    /* SI HAY UN PEDIDO MUESTRO UN MODAL */
    $("#modalPedidos").modal("show") 
    /* LE DOY PLAY AL SONIDO */
    document.getElementById("sonido").play()
    </script>
<?php }?>

<!-- ESTA PARTE SOLO CARGA SI HAY UN PEDIDO -->
<?php if($pedidosPendientes!=null){?>
    <script>
    /* SI HAY UN PEDIDO MUESTRO UN MODAL */
    $("#pedidoPendiente").modal("show") 
    /* LE DOY PLAY AL SONIDO */
    document.getElementById("sonido").play()
    </script>
<?php }?>






<!-- VACIO LAS VARIABLES DE SESSION DE COCHERA Y OCUPADA -->
<?php unset($_SESSION['ocupada'])?>
<?php unset($_SESSION['cochera'])?>
<?php unset($_SESSION['cobrando'])?>

<script src="moduloHabitaciones/js/pedidoEntregado.js"></script>
<script src="moduloHabitaciones/js/js.js"></script>
</html>