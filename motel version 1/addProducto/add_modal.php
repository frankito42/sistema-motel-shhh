<!-- Agregar Nuevo -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<center><h4 class="modal-title" id="myModalLabel">Agregar producto</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		      </button>
                
            </div>
            <div style="padding-top: 0px;" class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="add.php" enctype="multipart/form-data">
				<div class="row">
					<div class="col">
						<div class="md-form">
  							<input required type="text" id="nombre" name="nombre" class="form-control">
  							<label for="nombre">Nombre del articulo</label>
						</div>
					</div>
					<div style="margin-top: 6%;" class="col">
						
								<select required name="tipoart" class="form-control">
								<option value="">Tipo de articulo</option>
								<?php foreach ($allTipoArticulo as $key):?>
								<option value="<?php echo $key['tipoart']?>"><?php echo $key['nombre']?></option>
								<?php endforeach?>
								</select>	
								
							
						
					</div>
				</div>
				
					<div class="md-form">
  						<input required type="number" id="stockmin" name="stockmin" class="form-control">
  						<label for="stockmin">Stock minino</label>
					</div>

				
					<!-- <div class="md-form">
  						<input type="number" id="cantidad" name="cantidad" class="form-control">
  						<label for="cantidad">Cantidad</label>
					</div> -->


					<div class="md-form">
  						<textarea id="descripcion" name="descripcion" class="md-textarea form-control" rows="1"></textarea>
  						<label for="descripcion">Descripcion</label>
					</div>


				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label" style="position:relative; top:7px;">Imagen:</label>
					</div>
					<div class="col-sm-10">
						<input name="archivo" type="file">
					</div>
				</div>
				
				<div class="row">
				<div style="margin-top: 6%;" class="col">
				
						<select required name="categoria" class="form-control">
						<option value="">Categoria</option>
						<?php foreach ($allCategorias as $key):?>
						<option value="<?php echo $key['idCategoria']?>"><?php echo $key['nombreCategoria']?></option>
						<?php endforeach?>
						</select>
				
				</div>
				<div class="col">
					<div class="md-form">
  						<input type="text" id="codBarra" name="codBarra" class="form-control">
  						<label for="codBarra">Codigo de barra</label>
					</div>
				</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
                <button type="submit" name="add" class="btn btn-primary"><span class="fa fa-save"></span> Guardar</a>
			</form>
            </div>

        </div>
    </div>
</div>
