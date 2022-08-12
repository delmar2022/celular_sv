<?php
if (isset($conexion)) {
?>
	<div id="editarEgreso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> EDITAR MOVIMIENTO</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_egreso" name="editar_egreso">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fecha2" class="control-label">FECHA:</label>
									<input type="date" class="form-control UpperCase" id="fecha2" name="fecha2" autocomplete="off" required>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="hora2" class="control-label">HORA INICIO:</label>
									<input type="time" class="form-control UpperCase" id="hora2" name="hora2" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="importe2" class="control-label">CANTIDAD EGRESADA:</label>
									<input type="text" class="form-control UpperCase" id="importe2" name="importe2" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tipo2" class="control-label">TIPO:</label>
									<select class="form-control" id="tipo2" name="tipo2" required>
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
									<label for="concepto2" class="control-label">CONCEPTO EGRESO:</label>
									<input type="text" class="form-control UpperCase" id="concepto2" name="concepto2" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="obs2" class="control-label">OBSERVACIONES:</label>
									<input type="text" class="form-control UpperCase" id="obs2" name="obs2" autocomplete="off">
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