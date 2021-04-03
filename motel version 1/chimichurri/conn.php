<?
include('zona.php');
include('trataFechas.php');
include('RestaHoras.php');
include('activaDescuento.php');
require_once("libreria/login.php");
$conn= mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
//Si no podemos conectar a la base de datos, mostramos el error por pantalla.
if (!$conn) { echo mysqli_connect_error(); }
?>