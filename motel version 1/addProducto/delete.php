<?php
/*
| -----------------------------------------------------
| PROYECTO: 		PHP CRUD usando PDO y Bootstrap
| -----------------------------------------------------
| AUTOR:			AnthonCode
| -----------------------------------------------------
| FACEBOOK:			FACEBOOK.COM/ANTHONCODE
| -----------------------------------------------------
| COPYRIGHT:		AnthonCode
| -----------------------------------------------------
| WEBSITE:			http://4avisos.com - anthoncode.blogspot.com
| -----------------------------------------------------
*/
	session_start();
	include_once('connection.php');

	if(isset($_GET['id'])){
		$database = new Connection();
		$db = $database->open();
		try{
			$sql = "DELETE FROM articulos WHERE articulo = '".$_GET['id']."'";
			// declaración if-else en la ejecución de nuestra consulta
			$_SESSION['message'] = ( $db->exec($sql) ) ? 'Se elimino correctamente el producto'." ".$_GET['nombre'] : 'Ocurrió un error. No se pudo eliminar';
		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}

		//cerrar conexión
		$database->close();

	}
	else{
		$_SESSION['message'] = 'Seleccione producto para eliminar';
	}

	header('location: addProduct.php');

?>