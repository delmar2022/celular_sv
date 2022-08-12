<?php
if (isset($conexion)) {
?>
	<div id="egresoCaja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> CONTROL DE EFECTIVO</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="egreso_caja" name="egreso_caja">
						<div id="resultados_ajax"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">FECHA:</label>
									<input type="date" class="form-control UpperCase" id="fecha" name="fecha" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="hora" class="control-label">HORA INICIO:</label>
									<input type="time" class="form-control UpperCase" id="hora" name="hora" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="importe" class="control-label">CANTIDAD EGRESADA:</label>
									<input type="text" class="form-control UpperCase" id="importe" name="importe" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tipo" class="control-label">Tipo:</label>
									<select class="form-control" id="tipo" name="tipo" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>Egreso</option>
										<option value="2">Ingreso</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="concepto" class="control-label">CONCEPTO EGRESO:</label>
									<input type="text" class="form-control UpperCase" id="concepto" name="concepto" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="obs" class="control-label">OBSERVACIONES:</label>
									<input type="text" class="form-control UpperCase" id="obs" name="obs" autocomplete="off">
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