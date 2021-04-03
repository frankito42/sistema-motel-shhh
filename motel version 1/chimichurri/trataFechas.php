<?
// está funcion toma un fecha con formato 01/12/2002 
// y lo transforma a 2002/12/01 antes de guardarlo en 
// una base de datos mysql
function fentrada($cad){
$uno=substr($cad, 0, 2);
$dos=substr($cad, 3, 2);
$tres=substr($cad, 6, 4);
$cad2 = ($tres."/".$dos."/".$uno);
return $cad2;
}
// Está funcion hace lo contrario toma una fecha con 
// formato 2002/12/01 y lo transforma a 01/12/2002
// antes de mostrarlo en una página, despues de leerlo 
// desde una base de datos mysql
function fsalida($cad2){
$tres=substr($cad2, 0, 4);
$dos=substr($cad2, 5, 2);
$uno=substr($cad2, 8, 2);
$cad = ($uno."/".$dos."/".$tres);
return $cad;
}

/* CACULAR LOS DIAS ENTRE 2 FECHAS DADAS*/
function cDias($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}

function cuentaMinutos($horaEntrada){

//hora a convertir a minutos
$v_HorasPartes=0;
 
//realizamos una partición que separe la parte de la hora y la parte de los minutos
$v_HorasPartes = explode(":", $horaEntrada);
 
//la parte de la hora la multiplicamos por 60 para pasarla a minutos y así realizar la suma de los minutos totales
$minutosTotales= ($v_HorasPartes[0] * 60) + $v_HorasPartes[1];
 
return $minutosTotales;

}

function fEntradaFrancisco($cad){
    $uno=substr($cad, 0, 4);
    $dos=substr($cad, 5, 2);
    $tres=substr($cad, 8, 2);
    $cad2 = ($tres."/".$dos."/".$uno);
    return $cad2;
  }

?>