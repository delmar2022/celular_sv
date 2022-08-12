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
											<label color" class="control-label">Código:</label>
											<input type="text" class="form-control UpperCase" id="codigo2" name="codigo2" autocomplete="off" required>
											<input id="mod_id" name="mod_id" type='hidden'>

										</div>

									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="nombre2" class="control-label">Nombre Producto:</label>
											<input type="text" class="form-control UpperCase" id="nombre2" name="nombre2" autocomplete="off" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="marca2" class="control-label">Marca:</label>
											<select class='form-control' name='marca2' id='marca2' required>
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
											<label for="modelo2" class="control-label">Modelo:</label>
											<select class='form-control' name='modelo2' id='modelo2' required>
												<option value="">-- Selecciona --</option>
												<?php

												$query_categoria2 = mysqli_query($conexion, "select * from lineas order by nombre_linea");
												while ($rw = mysqli_fetch_array($query_categoria2)) {
												?>
													<option value="<?php echo $rw['id_linea']; ?>"><?php echo $rw['nombre_linea']; ?></option>
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
											<label for="color2" class="control-label">Color:</label>
											<input type="text" class="form-control UpperCase" id="color2" name="color2" autocomplete="off" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="emei2" class="control-label">Emei:</label>
											<input type="text" class="form-control UpperCase" id="emei2" name="emei2" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="estado2" class="control-label">Estado:</label>
											<select class="form-control" id="estado2" name="estado2" required>
												<option value="">-- Selecciona --</option>
												<option value="1" selected>Nuevo</option>
												<option value="2">Usado</option>
											</select>
										</div>
									</div>
								</div>

							</div>
							<div class="tab-pane fade" id="mod_precios">


								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="costo2" class="control-label">Costo:</label>
											<input type="text" class="form-control" id="costo2" name="costo2" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="utilidad2" class="control-label">Utilidad %:</label>
											<input type="text" class="form-control" id="utilidad2" name="utilidad2" pattern="\d{1,4}" maxlength="4" onkeyup="precio_venta();">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="precio2" class="control-label">Precio Venta:</label>
											<input type="text" class="form-control" id="precio2" name="precio2" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="status2" class="control-label">Status:</label>
											<select class="form-control" id="status2" name="status2" required>
												<option value="">-- Selecciona --</option>
												<option value="1" selected>Activo</option>
												<option value="0">Inactivo</option>
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