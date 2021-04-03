<?php
session_start();
require "conection.php";



if (isset($_GET['fin'])) {
    //VARIABLES DE LA HABITACION
    $id=$_GET['id'];
    $ip=$_GET['ip_tablet'];
    /* ////////////////////////////////////////////////// */
    /* comento el necesita limpieza para dejarlo solo en limpieza */
    /* ////////////////////////////////////////////////// */
    /* $estado="necesita limpieza"; */
    /* ////////////////////////////////////////////////// */
    $estado="necesita limpieza";
    $id_movtem=$_GET['id_movtem'];
    $ipArduino=$_GET['ipArduino'];
    
    /* REINICIO LOS SONIDOS DEL SENSOR 1 Y 2 */
    //PONGO LA HABITACION EN DISPONIBLE 
    $vacio="";
    $sensorGarajeSql="UPDATE `habitaciones` SET `estado`=:estado ,`sonido1`=:sensorGaraje,`sonido2`=:sensorPuerta,cobrando=:cobrando,sex=:sex,cocina=:cocina WHERE `habitacion`=:habitacion";
    $executeSensor1=$conexion->prepare($sensorGarajeSql);
    $executeSensor1->bindParam(":sensorGaraje",$vacio);
    $executeSensor1->bindParam(":sensorPuerta",$vacio);
    $executeSensor1->bindParam(":estado",$estado);
    $executeSensor1->bindParam(":cobrando",$vacio);
    $executeSensor1->bindParam(":cocina",$vacio);
    $executeSensor1->bindParam(":sex",$vacio);
    $executeSensor1->bindParam(":habitacion",$id);
    $executeSensor1->execute();


     
    //CIERRO MOVTEMP 
    $muvtemSql="UPDATE `movtemp` SET `id2`=:id2, `totalSesion`=:sesion WHERE `id`=:id_movtem";
    $finMuvtem=$conexion->prepare($muvtemSql);
    $finMuvtem->bindParam(":sesion",$_GET['totalCuenta']);
    $finMuvtem->bindParam(":id_movtem",$id_movtem);
    $finMuvtem->bindParam(":id2",$id_movtem);
    $finMuvtem->execute();


    //INSERTO EN CAJA LOS TOTALES
    $sqlCaja="INSERT INTO `cajas`(`total`,`idMovtemp`,idUser) 
              VALUES
             (:total,
              :id_movtem,
              :idUser)";
    $caja=$conexion->prepare($sqlCaja);
    $caja->bindParam(":total",$_GET['totalCuenta']);
    $caja->bindParam(":id_movtem",$id_movtem);
    $caja->bindParam(":idUser",$_SESSION['user']['idUser']);
    $caja->execute();


    //TRAIGO LOS PRODUCTOS PARA LUEGO VERIFICAR EN QUE ESTADO ESTA 
    $selectProductosDeSesion="SELECT * FROM `carritos` WHERE `idMovtemp`=:idMovtemp";
    $productos=$conexion->prepare($selectProductosDeSesion);
    $productos->bindParam(":idMovtemp",$id_movtem);
    $productos->execute();
    $productos=$productos->fetchAll(PDO::FETCH_ASSOC);


    foreach ($productos as $key) {
        if ($key['estadoProducto']=="cocina") {
            //SI EN COCINA SE OLVIDAN DE DARLE A LISTO AL PEDIDO ENTREGADO
            $estadoCocina="listo";
            $sqlEstadoCocina="UPDATE `carritos` SET `estadoProducto`=:estado WHERE `idCarrito`= :idCarrito";
            $updateProductoCocina=$conexion->prepare($sqlEstadoCocina);
            $updateProductoCocina->bindParam(":idCarrito",$key['idCarrito']);
            $updateProductoCocina->bindParam(":estado",$estadoCocina);
            $updateProductoCocina->execute();
        }else if($key['estadoProducto']=="pendiente"){
            //BORRA DEL CARRITO SI EL ESTADO ES IGUAL A PENDIENTE POQUE CERRO SESION SIN CONSUMIR
            //NI DESCONTAR DE STOCK EL PRODUCTO
            $sqlEstadoCocina="DELETE FROM `carritos` WHERE `idCarrito`=:idCarrito";
            $updateProductoCocina=$conexion->prepare($sqlEstadoCocina);
            $updateProductoCocina->bindParam(":idCarrito",$key['idCarrito']);
            $updateProductoCocina->execute();
        }else if($key['estadoProducto']=="sex"){
            //AQUI SOLO LE PONGO LISTO AL PEDIDO DE SEX HOT
            $sexListo="listo";
            $sqlSexListo="UPDATE `carritos` SET `estadoProducto`=:estado WHERE `idCarrito`= :idCarrito";
            $sexListoExecute=$conexion->prepare($sqlSexListo);
            $sexListoExecute->bindParam(":idCarrito",$key['idCarrito']);
            $sexListoExecute->bindParam(":estado",$sexListo);
            $sexListoExecute->execute();
        }

    }



    unset($_SESSION[$ip]);
    /* BANDERA TRUE PARA QUE AVISE CON AJAX $.GET AL ARDUINO QUE PONGA AZUL INTERMITENTE */
    $vandera="true";
    /* header("location: index.php"); */

}else{
    $id=$_GET['id'];
    $estado="MP";
        $sqlEstado="UPDATE `habitaciones` SET `estado`=:estado WHERE habitacion=:id";
        
        $estadoHabitacion=$conexion->prepare($sqlEstado);
        $estadoHabitacion->bindParam(":id",$id);
        $estadoHabitacion->bindParam(":estado",$estado);
        $estadoHabitacion->execute(); 
        $_SESSION['message2']="Codigo QR mercado pago enviando a la habitacion";
        header("location: habitOcupada.php?id=$id");
}
?>
<script src="mdbootstrap/js/jquery.min.js"></script>
<script src="mdbootstrap/js/bootstrap.min.js"></script>
<script src="mdbootstrap/js/mdb.min.js"></script>
<script>
    let vandera="<?php echo $vandera?>"
    if (vandera=="true") {
        let ipArduino="<?php echo $ipArduino?>"
        
        $.get("http://"+ipArduino+"/?PC1")
        /* //////////////////////////////////////////////// */
        /* //////////////////////////////////////////////// */
        /* $.get("http://"+ipArduino+"/?LP0") */
        setTimeout(() => {
        location.href="index.php"
        }, 1500);
    }
 
</script>