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
 
	if(isset($_POST['edit'])){
		$database = new Connection();
		$db = $database->open();
		try{
			$id = $_GET['id'];
			$nombre = $_POST['nombre'];
			$tipoart = $_POST['tipoart'];
			$costo = $_POST['costo'];
			$stockmin = $_POST['stockmin'];
			$cantidad = $_POST['cantidad'];
			$descripcion = $_POST['descripcion'];
			$categoria = $_POST['categoria'];
			$precioV = $_POST['precioV'];

			
			$sql = "UPDATE `articulos` SET `nombre`=:nombre,`tipoart`=:tipoart,`costo`=:costo,`stockmin`=:stockmin,`cantidad`=:cantidad,`descripcion`=:descripcion,`categoria`=:categoria,`precioVenta`=:precioV WHERE articulo=:id";
			// declaración if-else en la ejecución de nuestra consulta




			$insert=$db->prepare($sql);

			$insert->bindParam(":nombre",$nombre);
			$insert->bindParam(":tipoart",$tipoart);
			$insert->bindParam(":costo",$costo);
			$insert->bindParam(":stockmin",$stockmin);
			$insert->bindParam(":cantidad",$cantidad);
			$insert->bindParam(":categoria",$categoria);
			$insert->bindParam(":descripcion",$descripcion);
			$insert->bindParam(":precioV",$precioV);
			$insert->bindParam(":id",$id);

			$_SESSION['message'] = ( $insert->execute() ) ? "Se actualizo $nombre" : "Ocurrio un error. No se pudo actualizar $nombre";




		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}

		//cerrar conexión 
		$database->close();
	}
	else{
		$_SESSION['message'] = 'Primero debe llenar el form';
	}

	header('location: addproduct.php');

?>