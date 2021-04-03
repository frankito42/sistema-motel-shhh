<?php
require "conection.php";
if(isset($_GET['AC1'])){

    

    $movSql="SELECT * FROM `habitaciones` = h 
    INNER JOIN movtemp = m on h.`habitacion`=m.`habitacion` AND m.id2=0 AND h.`ip_tablet`=:ip_tablet";
    $mov=$conexion->prepare($movSql);
    $mov->bindParam(":ip_tablet",$_SERVER['REMOTE_ADDR']);
    $mov->execute();
    $movtemp=$mov->fetch(PDO::FETCH_ASSOC);
    
    require "chimichurri/verhab1.php";


    function algunNombre($m){
        $d = (int)($m/1440);
        $m -= $d*1440;
         
        $h = (int)($m/60);
        $m -= $h*60; 
         
        return array("dias" => $d, "horas" => $h, "minutos" => $m);
        }
         
        $someVar = algunNombre($minTotalesTurno);
         

        $minutosRoundMas0=round($someVar["minutos"]);
        $minutosRoundMas0=($minutosRoundMas0<10) ? "0".$minutosRoundMas0 : $minutosRoundMas0;
        $horasCon0=($someVar["horas"]<10) ? "0".$someVar["horas"] : $someVar["horas"];
        /* echo "días: ".$someVar["dias"]."<br/>";
        echo "horas: ".$someVar["horas"]."<br/>";
        echo "Minutos: ".round($someVar["minutos"])."<br/>"; */

        $totalHorasMin=$horasCon0.":".$minutosRoundMas0;
    
      
/* algunNombre($minTotalesTurno);
 */


    $miCarrito="SELECT c.`idCarrito`,c.`habitacion`,a.`nombre`,c.`cantidad`,c.`precio` FROM carritos = c
    INNER JOIN articulos = a on a.`articulo` = c.`articulo` where c.habitacion =:habitacion AND c.idMovtemp=:id";
    
    $carrito=$conexion->prepare($miCarrito);
    $carrito->bindParam(":habitacion",$_SERVER["REMOTE_ADDR"]);
    $carrito->bindParam(":id",$movtemp["id"]);
    $carrito->execute();
    $carrito=$carrito->fetchAll(PDO::FETCH_ASSOC);
    $contarArray=count($carrito);

    $total=0;
    $contador=0;
    foreach ($carrito as $key) {
        $contador=$contador+1;
        $total=$key['cantidad']*$key['precio'];
        if ($contador==$contarArray) {
            echo "cuenta".$key['cantidad']."#".$key['nombre']."#".$total.","."cuenta$totalHorasMin#hospedaje#$habitacionjj";
        }else{
            echo "cuenta".$key['cantidad']."#".$key['nombre']."#".$total.",";
        }


        $total=0;
    }
    if($carrito==null){
        echo "cuenta$totalHorasMin#hospedaje#$habitacionjj";
    }

}




?>



