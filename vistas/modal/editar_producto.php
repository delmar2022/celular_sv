<?php
if (isset($conexion)) {
    ?>
	<div id="editarProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Producto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
						<div id="resultados_ajax2"></div>

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a href="#mod_info" data-toggle="tab" aria-expanded="false" class="nav-link active">
									DATOS BASICOS
								</a>
							</li>
							<li class="nav-item">
								<a href="#mod_precios" data-toggle="tab" aria-expanded="true" class="nav-link">
									PRECIO Y STOCK
								</a>
							</li>
							<li class="nav-item">
								<a href="#img2" data-toggle="tab" aria-expanded="true" class="nav-link">
									IMAGEN
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="mod_info">

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="mod_codigo" class="control-label">Código:</label>
											<input type="text" class="form-control" id="mod_codigo" name="mod_codigo"  autocomplete="off" required>
											<input id="mod_id" name="mod_id" type='hidden'>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="mod_nombre" class="control-label">Nombre Producto:</label>
											<input type="text" class="form-control UpperCase" id="mod_nombre" name="mod_nombre" autocomplete="off" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="mod_linea" class="control-label">Categoria:</label>
											<select class='form-control' name='mod_linea' id='mod_linea' required>
												<option value="">-- Selecciona --</option>
												<?php

    $query_categoria = mysqli_query($conexion, "select * from lineas order by nombre_linea");
    while ($rw = mysqli_fetch_array($query_categoria)) {
        ?>
													<option value="<?php echo $rw['id_linea']; ?>"><?php echo $rw['nombre_linea']; ?></option>
													<?php
}
    ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="mod_linea2" class="control-label">Subcategoria:</label>
											<select class='form-control' name='mod_linea2' id='mod_linea2' required>
												<option value="">-- Selecciona --</option>
												<?php

    $query_categoria2 = mysqli_query($conexion, "select * from sub_lineas order by nombre_linea2");
    while ($rw = mysqli_fetch_array($query_categoria2)) {
        ?>
													<option value="<?php echo $rw['id_linea2']; ?>"><?php echo $rw['nombre_linea2']; ?></option>
													<?php
}
    ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="mod_marca" class="control-label">Marca:</label>
											<select class='form-control' name='mod_marca' id='mod_marca' required>
												<option value="">-- Selecciona --</option>
												<?php

    $query_marca = mysqli_query($conexion, "select * from marcas order by nombre_marca");
    while ($rw = mysqli_fetch_array($query_marca)) {
        ?>
													<option value="<?php echo $rw['id_marca']; ?>"><?php echo $rw['nombre_marca']; ?></option>
													<?php
}
    ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="mod_estado" class="control-label">Estado:</label>
											<select class="form-control" id="mod_estado" name="mod_estado" required>
												<option value="">-- Selecciona --</option>
												<option value="1" selected>Activo</option>
												<option value="0">Inactivo</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="mod_descripcion" class="control-label">Observacion</label>
										<textarea class="form-control UpperCase"  id="mod_descripcion" name="mod_descripcion" maxlength="255"  autocomplete="off"></textarea>
									</div>
								</div>

							</div>
							<div class="tab-pane fade" id="mod_precios">

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="mod_costo" class="control-label">Costo Promedio:</label>
											<input type="text" class="form-control" id="mod_costo" name="mod_costo" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="mod_costo2" class="control-label">Ultimo Costo:</label>
											<input type="text" class="form-control" id="mod_costo2" name="mod_costo2" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="mod_utilidad" class="control-label">Utilidad %:</label>
											<input type="text" class="form-control" id="mod_utilidad" name="mod_utilidad" pattern="\d{1,4}"  maxlength="4" onkeyup="precio_venta();" >
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
									<div class="form-group">
										<label for="mod_precio" class="control-label">Precio 1:</label>
										<input type="text" class="form-control" id="mod_precio" name="mod_precio" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
									</div>
								</div>
								<div class="col-md-4">
										<div class="form-group">
											<label for="mod_preciom" class="control-label">Precio 2:</label>
											<input type="text" class="form-control" id="mod_preciom" name="mod_preciom" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="mod_precioe" class="control-label">Precio 3:</label>
											<input type="text" class="form-control" id="mod_precioe" name="mod_precioe" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
										</div>
									</div>
								</div>

								<div class="row">
								<div class="col-md-4">
										<div class="form-group">
											<label for="mod_stock" class="control-label">Stock Inicial:</label>
											<input type="text" class="form-control" id="mod_stock" name="mod_stock" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,4})?$" title="Ingresa sólo números con 0 ó 3 decimales" maxlength="8" readonly="true">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="mod_minimo" class="control-label">Stock Minimo:</label>
											<input type="text" class="form-control" id="mod_minimo" name="mod_minimo" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,4})?$" title="Ingresa sólo números con 0 ó 3 decimales" maxlength="8">
										</div>
									</div>
									
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="mod_inv" class="control-label">Maneja Inventario:</label>
											<select class="form-control" id="mod_inv" name="mod_inv" required>
												<option value="">- Selecciona -</option>
												<option value="0">Si</option>
												<option value="1">No</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="mod_impuesto" class="control-label">Incluye IVA:</label>
											<select class="form-control" id="mod_impuesto" name="mod_impuesto" required>
												<option value="">-- Selecciona --</option>
												<option value="0" selected>SI</option>
												<option value="1">NO</option>
											</select>
										</div>
									</div>
								</div>


							</div>
							<div class="tab-pane fade" id="img2">

								<div class="outer_img"></div>


							</div>

						</div>



					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="actualizar_datos">Actualizar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>