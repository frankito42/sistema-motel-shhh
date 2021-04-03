<!-- Editar -->
<div class="modal fade" id="edit_<?php echo $row['articulo']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            	 <center><h4 class="modal-title" id="myModalLabel">Editar miembro</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div style="padding-top: 0%;padding-bottom: 0%;" class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="edit.php?id=<?php echo $row['articulo']; ?>">
		
			<div class="row">
			<div class="col">
					<div class="md-form">
  						<input required type="text" id="nombre" value="<?php echo $row['nombre']?>" name="nombre" class="form-control">
  						<label for="nombre">Nombre del articulo</label>
					</div>
			</div>
			<div style="margin-top:6%;" class="col">
						<select name="tipoart" class="form-control">
							<?php foreach ($allTipoArticulo as $key):?>
							<?php echo "<option value=".$key['tipoart'];
								if($key['tipoart']==$row['tipoart']){echo " selected";}
									echo ">".$key['nombre']."</option>";?>
							<?php endforeach?>
						</select>
			</div>
			</div>
		
				
						
					

				<div class="row">
				<div class="col">
					<div class="md-form">
  						<input required type="number" id="stockmin" value="<?php echo $row['stockmin']?>" name="stockmin" class="form-control">
  						<label for="stockmin">Stock minimo</label>
					</div>
				</div>
				<div class="col">
					<div class="md-form">
						<input type="number" value="<?php echo $row['cantidad']?>" id="cantidad" class="form-control" name="cantidad">
  						<label for="cantidad">Cantidad en stock</label>
					</div>
				</div>
				</div>


				<div class="row">
					<div class="col">
						<div class="md-form">
  							<input required type="number" id="costo" value="<?php echo $row['costo']?>" name="costo" class="form-control">
  							<label for="costo">Costo unitario</label>
						</div>
					</div>
					<div style="margin-top:6%;" class="col">
						<select name="categoria" class="form-control">
							<?php foreach ($allCategorias as $key):?>
							<?php echo "<option value=".$key['idCategoria'];
							if($key['idCategoria']==$row['categoria']){echo " selected";}
							echo ">".$key['nombreCategoria']."</option>";?>
							<?php endforeach?>
						</select>
					</div>
					
				</div>

				
					<div class="md-form">
						<input required type="number" value="<?php echo $row['precioVenta']?>" id="precioV" class="form-control" name="precioV">
  						<label for="precioV">Precio de venta</label>
					</div>

					<div class="md-form">
						<textarea name="descripcion" id="descripcion" class="md-textarea form-control" ><?php echo $row['descripcion']?></textarea>
  						<label for="descripcion">Descripcion</label>
					</div>
			 
				 
						
					 
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
                <button type="submit" name="edit" class="btn btn-success"><span class="fa fa-check"></span> Actualizar</a>
			</form>
            </div>

        </div>
    </div>
</div>

<!-- Eliminar -->
<div class="modal fade" id="delete_<?php echo $row['articulo']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            	<center><h4 class="modal-title" id="myModalLabel">Borrar miembro</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">	
            	<p class="text-center">¿Estas seguro en borrar los datos de?</p>
				<h2 class="text-center"><?php echo $row['nombre'] ?></h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
                <a href="delete.php?id=<?php echo $row['articulo']; ?>&nombre=<?php echo $row['nombre']?>" class="btn btn-danger"><span class="fa fa-trash"></span> Si</a>
            </div>

        </div>
    </div>
</div>
