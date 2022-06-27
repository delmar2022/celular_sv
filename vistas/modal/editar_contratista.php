<?php
if (isset($conexion)) {
    ?>
	<div id="editarContra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Contratista</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_contratista" name="editar_contratista">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="nombre2" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="nombre2" name="nombre2" autocomplete="off" required>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="tel12" class="control-label">Tel1:</label>
									<input type="text" class="form-control" id="tel12" name="tel12" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tel22" class="control-label">Tel2:</label>
									<input type="text" class="form-control" id="tel22" name="tel22" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="empresa2" class="control-label">Empresa:</label>
									<input type="text" class="form-control UpperCase" id="empresa2" name="empresa2" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="comprobante2" class="control-label">Comprobante:</label>
									<select class="form-control" id="comprobante2" name="comprobante2" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>SI</option>
										<option value="0">NO</option>
									</select>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="banco2" class="control-label">Banco:</label>
									<input type="text" class="form-control UpperCase" id="banco2" name="banco2" autocomplete="off">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="cuenta2" class="control-label">No Cuenta:</label>
									<input type="text" class="form-control UpperCase" id="cuenta2" name="cuenta2" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="estado2" class="control-label">Estado:</label>
									<select class="form-control" id="estado2" name="estado2" required>
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
									<label for="esp2" class="control-label">Especialidad:</label>
									<input type="text" class="form-control UpperCase" id="esp2" name="esp2" autocomplete="off">
								</div>
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