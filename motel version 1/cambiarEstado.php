<?php 
date_default_timezone_set('America/Argentina/Buenos_Aires');
session_start();
require "conection.php";



if (isset($_GET['id'])){

    $id=$_GET['id'];
    $estado="enviar cuenta";
    $sqlEstado="UPDATE `habitaciones` SET `estado`=:estado WHERE habitacion=:id";
    
    $estadoHabitacion=$conexion->prepare($sqlEstado);
    $estadoHabitacion->bindParam(":estado",$estado);
    $estadoHabitacion->bindParam(":id",$id);
    $estadoHabitacion->execute();
    $_SESSION['message2']="Cuenta enviada a la habitacion"; 
    $_SESSION['mostrar']="mostrar"; 
    
    header("location: habitOcupada.php?id=$id");
}


if(isset($_GET['AC0'])){
    $estado="cobrando";
    $sqlEstado="UPDATE `habitaciones` SET `estado`=:estado WHERE ip_tablet=:ip_tablet";
    
    $estadoHabitacion=$conexion->prepare($sqlEstado);
    $estadoHabitacion->bindParam(":ip_tablet",$_SERVER["REMOTE_ADDR"]);
    $estadoHabitacion->bindParam(":estado",$estado);
    $estadoHabitacion->execute();


    $sqlSelect="SELECT `dirip` FROM `habitaciones` WHERE `ip_tablet`=:ip_tablet";
    
    $ipArduino=$conexion->prepare($sqlSelect);
    $ipArduino->bindParam(":ip_tablet",$_SERVER["REMOTE_ADDR"]);
    $ipArduino->execute();
    $ipArduino=$ipArduino->fetch(PDO::FETCH_ASSOC);
    $ipAr=$ipArduino['dirip'];
    /* echo "location:http://$ipAr/?AC1"; */
    /* header("location:http://$ipAr/?AC1"); */

   
    


}
/* if(isset($_GET['AC2'])){
    $estado="disponible";
    $sqlEstado="UPDATE `habitaciones` SET `estado`=:estado WHERE ip_tablet=:ip_tablet";
    
    $estadoHabitacion=$conexion->prepare($sqlEstado);
    $estadoHabitacion->bindParam(":ip_tablet",$_SERVER["REMOTE_ADDR"]);
    $estadoHabitacion->bindParam(":estado",$estado);
    $estadoHabitacion->execute();

   
    


} */

if (isset($_GET['estado'])) {
    //continuar///////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////
    $estado=$_GET['estado'];
    $ip=$_GET['habitacion'];
    $sqlEstado="UPDATE `habitaciones` SET `estado`=:estado, cobrando=:cobrando WHERE ip_tablet=:ip_tablet";
    $vacio="";
    $estadoHabitacion=$conexion->prepare($sqlEstado);
    $estadoHabitacion->bindParam(":ip_tablet",$ip);
    $estadoHabitacion->bindParam(":cobrando",$vacio);
    $estadoHabitacion->bindParam(":estado",$estado);
    $estadoHabitacion->execute();


    $fechaVacia=null;
    $timeVacio=null;
    $sqlUpdateVacioFecha="UPDATE `movtemp` SET `horaDesActS1`=:horaDes, `fechaDesActS1`=:fechaDes WHERE `id`=:id";
    $updateVacio=$conexion->prepare($sqlUpdateVacioFecha);
    $updateVacio->bindParam(":fechaDes",$fechaVacia);
    $updateVacio->bindParam(":horaDes",$timeVacio);
    $updateVacio->bindParam(":id",$_GET['idMovtemp']);
    $updateVacio->execute();
    $_SESSION[$ip]="";


    header("location: index.php");

}
if (isset($_GET['cobrando'])) {
    
    $id=$_GET["id_habitacion"];
    $estado=$_GET['cobrando'];
    $ip=$_GET['habitacion'];
    $ipArduino=$_GET['ipArduino'];

    $id2="";
    $sqlDesc="SELECT * FROM `movtemp` WHERE `habitacion`=:ha AND id2=:id2";
    $des=$conexion->prepare($sqlDesc);
    $des->bindParam(":ha",$id);
    $des->bindParam(":id2",$id2);
    $des->execute();
    $des=$des->fetch(PDO::FETCH_ASSOC);

    $fecha=date('Y-m-d');
    $time=date('H:i:s');
    $sqlUpdate="UPDATE `movtemp` SET `horaDesActS1`=:horaDes, `fechaDesActS1`=:fechaDes WHERE `id`=:id";
    $update=$conexion->prepare($sqlUpdate);
    $update->bindParam(":fechaDes",$fecha);
    $update->bindParam(":horaDes",$time);
    $update->bindParam(":id",$des['id']);
    $update->execute();




    $sqlEstado="UPDATE `habitaciones` SET `estado`=:estado WHERE ip_tablet=:ip_tablet";
    
    $estadoHabitacion=$conexion->prepare($sqlEstado);
    $estadoHabitacion->bindParam(":ip_tablet",$ip);
    $estadoHabitacion->bindParam(":estado",$estado);
    $estadoHabitacion->execute();
    
    $_SESSION[$ip]=$ip;
    $vandera="true";
    /* header("location: habitOcupada.php?id=$id"); */
}

//de habitocupada iparduino ajax 

?>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script>
let vandera="<?php echo $vandera?>"
    if (vandera=="true") {
        let ipArduino="<?php echo $ipArduino?>"
        let idHabitacion=<?php echo $id?>

        $.get("http://"+ipArduino+"/?AC1")
        setTimeout(() => {
            
        location.href="habitOcupada.php?id="+idHabitacion
        }, 800);
    }
 


</script>
