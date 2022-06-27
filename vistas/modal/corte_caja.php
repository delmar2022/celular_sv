<?php
if (isset($conexion)) {
    ?>
	<div id="corteCaja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Corte de Caja</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="corte_caja" name="corte_caja">
						<div id="resultados_ajax3"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fecha3" class="control-label">FECHA:</label>
									<input type="date" class="form-control UpperCase" id="fecha3" name="fecha3"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="hora3" class="control-label">HORA INICIO:</label>
									<input type="time" class="form-control UpperCase" id="hora3" name="hora3"  autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="efectivo2" class="control-label">EFECTIVO:</label>
									<input type="text" class="form-control UpperCase" id="efectivo2" name="efectivo2"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="ventas" class="control-label">VENTAS:</label>
									<input type="text" class="form-control UpperCase" id="ventas" name="ventas"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="compras2" class="control-label">COMPRAS:</label>
									<input type="text" class="form-control UpperCase" id="compras2" name="compras2"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="diferencia" class="control-label">DIFERENCIA:</label>
									<input type="text" class="form-control UpperCase" id="diferencia" name="diferencia"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="total2" class="control-label">TOTAL:</label>
									<input type="text" class="form-control UpperCase" id="total2" name="total2"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
								</div>
							</div>

						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="actualizar_datos2">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>