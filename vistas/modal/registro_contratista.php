<?php
if (isset($conexion)) {
    ?>
	<div id="nuevoContra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Contratista</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_contratista" name="guardar_contratista">
						<div id="resultados_ajax"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="nombre" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="nombre" name="nombre" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="tel1" class="control-label">Tel1:</label>
									<input type="text" class="form-control" id="tel1" name="tel1" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tel2" class="control-label">Tel2:</label>
									<input type="text" class="form-control" id="tel2" name="tel2" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="empresa" class="control-label">Empresa:</label>
									<input type="text" class="form-control UpperCase" id="empresa" name="empresa" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="comprobante" class="control-label">Comprobante:</label>
									<select class="form-control" id="comprobante" name="comprobante" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>SI</option>
										<option value="0">NO</option>
									</select>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="banco" class="control-label">Banco:</label>
									<input type="text" class="form-control UpperCase" id="banco" name="banco" autocomplete="off">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="cuenta" class="control-label">No Cuenta:</label>
									<input type="text" class="form-control UpperCase" id="cuenta" name="cuenta" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="estado" class="control-label">Estado:</label>
									<select class="form-control" id="estado" name="estado" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>Activo</option>
										<option value="0">Inactivo</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="esp" class="control-label">Especialidad:</label>
									<input type="text" class="form-control UpperCase" id="esp" name="esp" autocomplete="off">
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