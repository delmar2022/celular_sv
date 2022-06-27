<?php
if (isset($conexion)) {
    ?>
	<div id="cerrarCaja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Cerrar Caja</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="cerrar_caja" name="cerrar_caja">
						<div id="resultados_ajaxx"></div>

						<div id="resultados7"></div><!-- Carga los datos ajax del incremento de la fatura -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="btn_datos">Cerrar Caja</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>