<?php
require "../conection.php";
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=nombre_archivo.xls');
$sql="SELECT `articulo`, `nombre`, `tipoart`, `costo`, `stockmin`, `cantidad`, `descripcion`, `imagen`, a.`categoria`, `codBarra`, nombreCategoria, precioVenta  FROM `articulos` = a JOIN categoria = c on a.`categoria`=c.idCategoria";
$res=$conexion->prepare($sql);
$res->execute();
$res=$res->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exportar productos</title>
</head>
<body>
<table border="1">
<thead>
<tr>
<td>Producto</td>
<td>Categoria</td>
<td>Cantidad</td>
<td>Costo</td>
<td>Precio de venta</td>
</tr>
</thead>
<tbody>
<?php foreach ($res as $key):?>
    <tr>
	<td><?php echo $key['nombre'];?></td>
	<td><?php echo $key['nombreCategoria']; ?></td>
	<td><?php echo $key['cantidad']; ?></td>
	<td>$ <?php echo $key['costo']; ?></td>
	<td>$ <?php echo $key['precioVenta']; ?></td>
  
</tr>
<?php endforeach ?>
</tbody>
</table>

    
</body>
</html>