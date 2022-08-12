<?php
if (isset($conexion)) {
?>
	<div id="nuevoProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Producto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
						<div id="resultados_ajax"></div>

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a href="#info" data-toggle="tab" aria-expanded="false" class="nav-link active">
									DATOS BASICOS
								</a>
							</li>
							<li class="nav-item">
								<a href="#precios" data-toggle="tab" aria-expanded="true" class="nav-link">
									COSTOS Y PRECIOS
								</a>
							</li>
							<li class="nav-item">
								<a href="#img" data-toggle="tab" aria-expanded="true" class="nav-link">
									IMAGEN
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="info">

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label color" class="control-label">Código:</label>
											<div id="cod_resultado"></div><!-- Carga los datos ajax del incremento de la fatura -->
										</div>

									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="nombre" class="control-label">Nombre Producto:</label>
											<input type="text" class="form-control UpperCase" id="nombre" name="nombre" autocomplete="off" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="marca" class="control-label">Marca:</label>
											<select class='form-control' name='marca' id='marca' required>
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
											<label for="modelo" class="control-label">Modelo:</label>
											<select class='form-control' name='modelo' id='modelo' required>
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
											<label for="color" class="control-label">Color:</label>
											<input type="text" class="form-control UpperCase" id="color" name="color" autocomplete="off" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="emei" class="control-label">Emei:</label>
											<input type="text" class="form-control UpperCase" id="emei" name="emei" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="estado" class="control-label">Estado:</label>
											<select class="form-control" id="estado" name="estado" required>
												<option value="">-- Selecciona --</option>
												<option value="1" selected>Nuevo</option>
												<option value="2">Usado</option>
											</select>
										</div>
									</div>
								</div>

							</div>
							<div class="tab-pane fade" id="precios">

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="costo" class="control-label">Costo:</label>
											<input type="text" class="form-control" id="costo" name="costo" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="utilidad" class="control-label">Utilidad %:</label>
											<input type="text" class="form-control" id="utilidad" name="utilidad" pattern="\d{1,4}" maxlength="4" onkeyup="precio_venta();">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="precio" class="control-label">Precio Venta:</label>
											<input type="text" class="form-control" id="precio" name="precio" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="status" class="control-label">Status:</label>
											<select class="form-control" id="status" name="status" required>
												<option value="">-- Selecciona --</option>
												<option value="1" selected>Activo</option>
												<option value="0">Inactivo</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="img">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="image" class="col-sm-2 control-label">Imagen</label>
											<div class="col-sm-10">
												<input type="file" class='form-control' name="imagefile" id="imagefile" onchange="upload_image(<?php echo $product_id; ?>);">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2"></div>
									<div class="col-sm-6 col-lg-8 col-md-4 webdesign illustrator">
										<div class="gal-detail thumb">
											<div id="load_img">
												<img src="../../img/productos/default.jpg" class="thumb-img" width="200" alt="Bussines profile picture">
											</div>
										</div>
									</div>
								</div>

							</div>

						</div>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos">Guardar</button>
				</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
<?php
}
?>