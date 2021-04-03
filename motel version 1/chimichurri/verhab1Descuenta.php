<?
include_once('conn.php');
require "conection.php";
//$id= $res['habitacion'];

if(isset($_GET['id'])){
	$id= @ $_GET['id'];
}else{
	$id=$movtemp['habitacion'];
}
$ACTIVADORFINDAY=0;
$cero='00:00:00';
// sacar fecha y hora de inicio
$sel="select * from movtemp where habitacion='".$id."' and id2=''";
/* echo $sel."<BR>"; */
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
$selCosto="select c.nombre as nombre, c.turno as turno, c.monto1 as monto1, c.adicional as adicional, c.monto2 as monto2, c.estadia as estadia, c.monto3 as monto3, c.monto4 as monto4, m.habitacion as habitacion, c.horaSalidaEstadia as hSE";
$selCosto=$selCosto." from costos c, movtemp as m, habitaciones as h";
$selCosto=$selCosto." where";
$selCosto=$selCosto." m.habitacion=h.habitacion and h.costo=c.costo and m.id='".$rowSel['id']."'";
/* echo $selCosto."<br>"; */
$exeCosto=mysqli_query($conn,$selCosto);
$rowCos=mysqli_fetch_array($exeCosto,MYSQLI_BOTH);
/* echo $rowCos['turno']."<br>"; */
$turno=(strtotime($rowCos['turno'])-strtotime($cero))/60;
$adic=(strtotime($rowCos['adicional'])-strtotime($cero))/60;
// COSTOS DE LAS HABITACIONES
$cosTur=$rowCos['monto1']; 
$cosAdi=$rowCos['monto2']; 
$cosEst=$rowCos['monto3'];
$cosDor=$rowCos['monto4'];

//Variables Temporales para simplificar
$a=strtotime('23:59:59'); // para el final del dia
$b=strtotime($rowSel['horaActS1']); // hora activacion sensor 1
$c=strtotime('00:00:01'); // para el inicio del dia
$d=strtotime($horaDesActS1); // // hora desactivacion sensor 1
$ajuste=(strtotime('00:00:02')-strtotime($cero))/60; //esto sumar al final del tiempo calculado para recuperar los 2 segundos
$minTotalesTurno=0;
$minResDia=0;
$minIniDia=0;
$tiempoGracia=10;
// variables temporales de calculo de suma de dinero a pagar
$temp=0;
$tmpCHP=0;
$tmpCHPP=0;
$Dias=0;
$x=0;
$chp=0;
$cht=0;
//sacar los minutos totales 
// primero ver el cambio de dia
if ($rowSel['fechaActS1']<$fechaDesActS1){
	/* echo "entro fecha mayor a fecha entrada <br>"; */
	$Dias= cDias($rowSel['fechaActS1'],$fechaDesActS1); // calculo los dias que pasaron
	/* echo $Dias."<br>"; */
	//descontar horas
	$minResDia=(($a-$b)/60); //minutos restantes del dia
	$minIniDia=(($d-$c)/60); //minutos del dia siguiente
	if ($Dias>1){
		$minTotalesTurno=$minIniDia+$minResDia+(($Dias-1)*1440);
	} else {
		$minTotalesTurno=$minIniDia+$minResDia; // sumatoria de ambos
	}
	
	
} else { // el mismo dia
	$minTotalesTurno=($d-$b)/60;
}
$minTotalesTurno=$minTotalesTurno+$ajuste;
/*calular de mayor tiempo a menor tiempo*/
$temp=0;
if($estadia='T'){ // ELEGIR ENTRE V O T (VERDADERO O TRUE)
			$cht=$cosEst;
	
} 
if($dormida='T'){ // ELEGIR ENTRE V O T (VERDADERO O TRUE)
	$cht=$cosDor;

}
	$tiempRestante=0;
	$cantAdic=0;
	if ($minTotalesTurno>$turno){
		/*agregado para el tema de los 5 adicionales*/ 
		$temp=$minTotalesTurno-$turno; 
		$cantAdic=round(($temp/$adic),0);
		/*hasta aca*/
		 //echo $temp." trolo <br>"; 
		 //echo (round($temp,0))."el round <br>";
		 $ACTIVADORFINDAY=descuentaFinDeSemana($rowSel['fechaActS1']);
		  
		 	if ($cantAdic>=5 && $ACTIVADORFINDAY==1&& $minTotalesTurno>240){ // 5 es el la cantidad que dispusieron chris y bruno

					$ac="SI";
					$agregarDormida="UPDATE `movtemp` SET `activarDormida`=:dor WHERE `habitacion`=:hab";
					$dormidaActivada=$conexion->prepare($agregarDormida);
					$dormidaActivada->bindParam(":dor",$ac);
					$dormidaActivada->bindParam(":hab",$_GET['id']);
					$dormidaActivada->execute();
				
			}else{	
				if(($temp)>($adic)){
				//if(($temp)>($adic*(round($temp,0)))){
					$xx=round($temp,0)/$adic;
					//echo $xx."<br>"; 
					while($x<=round($xx, 0, PHP_ROUND_HALF_DOWN)){
						/* echo $x."<br>"; */
						$chp=$x*$cosAdi;
						$x=$x+1;
						/* echo "parc ".$chp."<br>"; */
					}
					$cht=$chp+($cosTur);
				} else {
					//aca esta el temaputo
					$cht=$cosTur+$cosAdi;
				}
			}			
	} else{
		$cht=$cosTur;
	}

	
if($rowSel['activarDormida']=='SI'){
	
	$cht=$cosDor;
	echo "<h2 style='color:#024a02;'>DORMIDA ACTIVADA<br></h2><hr>";
}
if($rowSel['activarEstadia']=='SI'){
	$cht=$cosEst;
	echo "<h2 style='color:#024a02;'>ESTADIA ACTIVADA<br></h2><hr>";
}


if(isset($_GET['id'])){

	function algunNombre($m){
        $d = (int)($m/1440);
        $m -= $d*1440;
         
        $h = (int)($m/60);
        $m -= $h*60; 
         
        return array("dias" => $d, "horas" => $h, "minutos" => $m);
        }
         
 
		echo "<h3>Fecha: ".$rowSel['fechaActS1']."</h3>";
		echo "<h3>Hora inicio: ".$rowSel['horaActS1']."</h3>";
		 echo $minTotalesTurno;
		$someVar = algunNombre($minTotalesTurno);

		$totalHorasMin=$someVar["horas"].":".round($someVar["minutos"]);

		echo "<h3>horas: ".$totalHorasMin."</h3>";
		
			$habitacionjj=$cht*((100-$rowSel['descuento'])/100);
		echo "<h3>Habitacion: $".$habitacionjj."</h3>";
}else{
		$habitacionjj=$cht*((100-$rowSel['descuento'])/100);
}
?>