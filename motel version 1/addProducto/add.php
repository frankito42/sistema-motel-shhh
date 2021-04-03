<?php
/*
| -----------------------------------------------------
| PROYECTO: 		PHP CRUD usando PDO y Bootstrap
| -----------------------------------------------------
| AUTOR:			ANTHONCODE
| -----------------------------------------------------
| FACEBOOK:			FACEBOOK.COM/ANTHONCODE
| -----------------------------------------------------
| COPYRIGHT:		AnthonCode
| -----------------------------------------------------
| WEBSITE:			http://4avisos.com
| -----------------------------------------------------
*/
	session_start();
	include_once('connection.php');

	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		try{
			$archivo = $_FILES['archivo']['name'];
			$temp = $_FILES['archivo']['tmp_name'];
			$ruta='../Toys/Toys/'.$archivo;

			if(empty($_FILES['archivo']['name'])){
				$ruta="";
			}
			
			move_uploaded_file($temp,$ruta);
			// hacer uso de una declaración preparada para evitar la inyección de sql
			$stmt = $db->prepare("INSERT INTO `articulos`(`nombre`, `tipoart`, `stockmin`, `descripcion`, `categoria`, `codBarra`, `imagen`) VALUES (:nombre,:tipoart,:stockmin,:descripcion,:categoria,:codBarra,:imagen)");
			// declaración if-else en la ejecución de nuestra declaración preparada
			$_SESSION['message'] = ( $stmt->execute(array(':nombre' => $_POST['nombre'] , ':tipoart' => $_POST['tipoart'], ':stockmin' => $_POST['stockmin'], ':descripcion' => $_POST['descripcion'], ':categoria' => $_POST['categoria'], ':codBarra' => $_POST['codBarra'], ':imagen' => $ruta)) ) ? 'se agregado correctamente el producto'." ".$_POST['nombre'] : 'Something went wrong. Cannot add';	
	    
		}
		catch(PDOException $e){
			$_SESSION['message'] = $e->getMessage();
		}

		//cerrar conexión
		$database->close();
	}

	else{
		$_SESSION['message'] = 'Fill up add form first';
	}

	header('location: addproduct.php');
	
?>
