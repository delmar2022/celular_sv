<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: ../../login.php");
	exit;
}

/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Caja";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$Caja = 1;
?>
<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged">
	<!-- DESACTIVA EL MENU -->

	<?php require 'includes/menu.php'; ?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
				<?php if ($permisos_ver == 1) {
				?>
					<div class="col-lg-12">
						<div class="portlet">
							<div class="portlet-heading bg-primary">
								<h3 class="portlet-title">
									Administracion de Caja
								</h3>
								<div class="portlet-widgets">
									<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
									<span class="divider"></span>
									<a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
									<span class="divider"></span>
									<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">
									<?php
									if ($permisos_editar == 1) {
										include "../modal/egresos_caja.php";
										include "../modal/editar_egreso.php";
										include "../modal/eliminar_egreso.php";
									}
									?>

									<form class="form-horizontal" role="form" id="datos_cotizacion">

										<div class="form-group row">

											<div class="col-xs-3">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control daterange pull-right" value="<?php echo "01" . date('/m/Y') . ' - ' . date('d/m/Y'); ?>" id="range" readonly>

												</div><!-- /input-group -->
											</div>

											<div class="col-xs-4">
												<div class="input-group">
													<select id="employee_id" class='form-control' onchange="load(1);">
														<option value="">Todos</option>
														<option value="1">Egreso</option>
														<option value="2">Ingreso</option>
													</select>
													<span class="input-group-btn">
														<button class="btn btn-primary" type="button" onclick='load(1);'><i class='fa fa-search'></i></button>
													</span>
												</div>
											</div>
											<div class="col-md-3">
												<div class="btn-group dropdown">
													<button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> Opciones</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="#" data-toggle="modal" data-target="#egresoCaja">
															<i class='fa fa-plus'></i> Nuevo Movimiento
														</a>
														<a class="dropdown-item" href="#" onclick="reporte();">
															<i class='fa fa-file-pdf-o'></i> Reporte PDF
														</a>
														<a class="dropdown-item" href="#" onclick="reporte_excel();">
															<i class='fa fa-file-excel-o'></i> Reporte Excel
														</a>
													</div>
												</div>
											</div>
											<div class="col-xs-1">
												<div id="loader" class="text-center"></div>
											</div>
										</div>
									</form>
									<div class="datos_ajax_delete"></div><!-- Carga los datos ajax -->
									<div class='outer_div'></div><!-- Carga los datos ajax -->


								</div>
							</div>
						</div>
					</div>

				<?php
				} else {
				?>
					<section class="content">
						<div class="alert alert-danger" align="center">
							<h3>Acceso denegado! </h3>
							<p>No cuentas con los permisos necesario para acceder a este módulo.</p>
						</div>
					</section>
				<?php
				}
				?>


			</div>
			<!-- end container -->
		</div>
		<!-- end content -->

		<?php require 'includes/pie.php'; ?>

	</div>
	<!-- ============================================================== -->
	<!-- End Right content here -->
	<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui -->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/admin_caja.js"></script>
<script>
	$(function() {
		//Initialize Select2 Elements
		$(".select2").select2();
	});
	$(function() {
		load(1);

		//Date range picker
		$('.daterange').daterangepicker({
			buttonClasses: ['btn', 'btn-sm'],
			applyClass: 'btn-success',
			cancelClass: 'btn-default',
			locale: {
				format: "DD/MM/YYYY",
				separator: " - ",
				applyLabel: "Aplicar",
				cancelLabel: "Cancelar",
				fromLabel: "Desde",
				toLabel: "Hasta",
				customRangeLabel: "Custom",
				daysOfWeek: [
					"Do",
					"Lu",
					"Ma",
					"Mi",
					"Ju",
					"Vi",
					"Sa"
				],
				monthNames: [
					"Enero",
					"Febrero",
					"Marzo",
					"Abril",
					"Mayo",
					"Junio",
					"Julio",
					"Agosto",
					"Septiembre",
					"Octubre",
					"Noviembre",
					"Diciembre"
				],
				firstDay: 1
			},
			opens: "right"

		});
	});
</script>
<script>
	function reporte() {
		var categoria = $("#employee_id").val();
		var daterange = $("#range").val();
		VentanaCentrada('../reportes/rep_caja.php?daterange=' + daterange + "&categoria=" + categoria, 'Reporte', '', '800', '600', 'true');

	}

	function reporte_excel() {
		var daterange = $("#range").val();
		var categoria = $("#employee_id").val();
		window.location.replace("../excel/rep_caja.php?daterange=" + daterange + "&categoria=" + categoria);
	}
</script>

<?php require 'includes/footer_end.php'
?>