<?php
require "../conection.php";
$sql="INSERT INTO `costos`( `nombre`, `turno`, `monto1`, `adicional`, `monto2`, `estadia`, `monto3`, `fecha_alta`, `horaSalidaEstadia`, `dormida`, `monto4`)
VALUES (:nombre,
        :turno,
        :precioTurno,
        :adicional,
        :adicionalMonto,
        :estadia,
        :estadiaPrecio,
        :fecha_alta,
        :horaSalidaEstadia,
        :dormida,
        :dormidaPrecio)";
$fecha=date("Y/m/d");



$monto4=$_POST['monto4'];
echo $monto4;
$insert=$conexion->prepare($sql);
$insert->bindParam(":nombre",$_POST['nombre']);
$insert->bindParam(":turno",$_POST['turno']);
$insert->bindParam(":precioTurno",$_POST['monto1']);
$insert->bindParam(":adicional",$_POST['adicional']);
$insert->bindParam(":adicionalMonto",$_POST['monto2']);
$insert->bindParam(":estadia",$_POST['estadia']);
$insert->bindParam(":estadiaPrecio",$_POST['monto3']);
$insert->bindParam(":horaSalidaEstadia",$_POST['horaSalidaEstadia']);
$insert->bindParam(":dormidaPrecio",$monto4);
$insert->bindParam(":dormida",$_POST['dormida']);
$insert->bindParam(":fecha_alta",$fecha);

if ($insert->execute()) {
    header("location:../costosAVM.php");
}
?>