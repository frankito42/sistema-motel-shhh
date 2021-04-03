<? 
include_once('conn.php');
/** para que no guarde en el cache del APACHE */
/* header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); */ // Fecha en el pasado
/* hasta aca */
//$id= $res['habitacion'];
$id= $_GET['id']; // es la habitacion
$cero='00:00:00';
// sacar fecha y hora de inicio
$sel="select * from movtemp where habitacion='".$id."' and id2=''";
/* echo $sel."<BR>" */;
$execSel=mysqli_query($conn,$sel);
$rowSel=mysqli_fetch_array($execSel,MYSQLI_BOTH);
// cargar horario de fin de turno
$fechaDesActS1=date('Y-m-d');
$horaDesActS1=date('H:i:s');
/*esto iria en otro php*/
//$upd="update movtemp set id2='".$id."', fechaDesActS1='".$fechaDesActS1."', horaDesActS1='".$horaDesActS1."' where id='".$id."' and id2=''";
//echo $upd."<br>";
/*hasta aca*/
/*sacar los valores de ls costos*/
$selCosto="select c.nombre as nombre, c.turno as turno, c.monto1 as monto1, c.adicional as adicional, c.monto2 as monto2, c.estadia as estadia, c.monto3 as monto3, m.habitacion as habitacion, c.horaSalidaEstadia as hSE";
$selCosto=$selCosto." from costos c, movtemp as m, habitaciones as h";
$selCosto=$selCosto." where";
$selCosto=$selCosto." m.habitacion=h.habitacion and h.costo=c.costo and m.id='".$rowSel['id']."'";
/* echo $selCosto."<br>"; */
$exeCosto=mysqli_query($conn,$selCosto);
$rowCos=mysqli_fetch_array($exeCosto,MYSQLI_BOTH);
/* echo $rowCos['turno']."<br>" */;
/* */
$turno=cuentaMinutos($rowCos['turno']);
$adic=cuentaMinutos($rowCos['adicional']);
$estadia=cuentaMinutos($rowCos['estadia']);
$cosTur=$rowCos['monto1'];
$cosAdi=$rowCos['monto2'];
$cosEst=$rowCos['monto3'];
//Variables Temporales para simplificar
$a=cuentaMinutos('23:59:59'); // para el final del dia
$b=cuentaMinutos($rowSel['horaActS1']); // hora activacion sensor 1
$c=cuentaMinutos('00:00:01'); // para el inicio del dia
$d=cuentaMinutos($horaDesActS1); // // hora desactivacion sensor 1

echo $turno."  turno  <br>";
echo $adic."  adicional  <br>";
echo $estadia."  estadia  <br>";

/* echo $a."  a  <br>";
echo $b."  b  <br>";
echo $c."  c  <br>";
echo $d."  d  <br>"; */
$mindia=0;
$minFal=0;
$minIni=0;
$minTot=0;
$ajuste=0;
$aPagar=0;
$estadias=0;
$turnos=0;
$adicionales=0;
$sobrante=0;

//Sacar los minutos totales consumidos
if ($fechaDesActS1>$rowSel['fechaActS1']){
	$mindia=((cuentaDias($rowSel['fechaActS1'],$fechaDesActS1))-1)*1440; //minutos del dia/s
	//echo ((cuentaDias($rowSel['fechaActS1'],$fechaDesActS1))-1)."<br>"; 
	$minFal= ($a-$b);
	$minIni=($d-$c);
	$minTot=$minFal+$minIni+$mindia;
} else {
	$minTot=($d-$b);
}
/*CALCULUM VERSION XVIII EQUISVÉPALITOPALITOPALITO*/
if ($minTot>$estadia){
    $estadias=intdiv($minTot,$estadia); 
    if ($estadias>1){
        $aPagar=$estadias*$cosEst;
    } else {
        $aPagar=$cosEst;
    }
} else {
    if($minTot>$turno){
      /*   echo "turno<br>"; */
        $turnos=intdiv($minTot,$turno); 
        $aPagar=$turnos*$cosTur;
        $minRest=$minTot-($turno*$turnos);
        echo $minRest." minutos restantes del turno<br>";
        if($minRest>$adic){
            /* echo "adicional<br>"; */
            $adicionales=intdiv($minRest,$adic);
            $sobrante=$minRest-($adic*$adicionales);
            echo $sobrante." minutos sobrantes del adicional<br>";
            if($sobrante>10){
                $adicionales=$adicionales+1;
            }
            $aPagar=$aPagar+($adicionales*$cosAdi);
        } else {
            if($minRest>10){
                echo $minRest."<br>";
                $aPagar=$aPagar+$cosAdi;
            }
        }

    } else{
        $aPagar=$cosTur;
    }
}

/*HABEMUS CALCULUM*/

echo "<h4>Fecha Inicio: ".$rowSel['fechaActS1']."</h4>";
echo "<h4>Hora Inicio: ".$rowSel['horaActS1']."</h4>";
/* echo "Fecha Fin: ".$fechaDesActS1."<br>"; */
/* echo "Hora Fin: ".$horaDesActS1."<br>"; */
echo "<h4>Minutos Transcurridos: ".$minTot."</h4>";
/* echo "A consumido un total de: ".$estadias." estadias a un valor de ".$cosEst."<br>";
echo "A consumido un total de: ".$turnos." turnos a un valor de ".$cosTur."<br>";
echo "A consumido un total de: ".$adicionales." adicionales a un valor de ".$cosAdi."<br>"; */
echo "<h4>A pagar $".$aPagar." te guste o nó </h4>";
?>