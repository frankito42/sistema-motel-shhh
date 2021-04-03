<?php 
session_start();
/* $_SESSION['contador']=0; */
if(isset($_SESSION['contador'])){
    $_SESSION['contador'];
}else{
    $_SESSION['contador']=0;
}
$arrayDeArduinos=["192.168.100.111",
                "192.168.100.112",
                "192.168.100.113",
                "192.168.100.114",
                "192.168.100.115",
                "192.168.100.116",
                "192.168.100.117",
                "192.168.100.118",
                "192.168.100.119",
                "192.168.100.120",
                "192.168.100.121"];
/* $ip="192.168.100.112"; */
$comando = $arrayDeArduinos[$_SESSION['contador']];
$output = shell_exec("ping $comando");

/* echo $output; */


/* $porciones = explode(",", $output); */

/* echo "<br>"; */


if (strpos($output,"recibidos = 0")) {
    $a=$_SESSION['contador']+1;
    $total="Habitacion ".$a." desconectada ".$arrayDeArduinos[$_SESSION['contador']];
    $arr = array('a' => $total,'b'=>"desconectada");
    echo json_encode($arr);
}else{
    $a=$_SESSION['contador']+1;
    $total="Habitacion ".$a." conectada ".$arrayDeArduinos[$_SESSION['contador']];
    $arr = array('a' => $total,'b'=>"conectada");
    echo json_encode($arr);
}
$_SESSION['contador']+=1;

if ($_SESSION['contador']==11) {
    $_SESSION['contador']=0;
}

/* print_r($porciones[2]); */
/* if (strpos($output, "recibidos=0")) {
    echo $output;
}else{
    echo "error"
} */
?>