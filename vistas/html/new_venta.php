<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);
$comp_id        = get_row('perfil', 'comp_id', 'id_perfil', 1);
$doc_cliente    = get_row('perfil', 'doc_cliente', 'id_perfil', 1);
//consulta para elegir el comprobante
$query = $conexion->query("select * from comprobantes");
$tipo  = array();
while ($r = $query->fetch_object()) {$tipo[] = $r;}
$query_empresa = mysqli_query($conexion, "select * from perfil, clientes where perfil.cliente_id= clientes.id_cliente  and perfil.id_perfil=1");
$row           = mysqli_fetch_array($query_empresa);
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged"> <!-- DESACTIVA EL MENU -->

	<?php require 'includes/menu.php';?>

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
									Nueva Venta
								</h3>
								<div class="portlet-widgets">
									<div class="btn-group dropdown">
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-dollar'></i> Caja<i class="caret"></i> </button>
										<div class="dropdown-menu dropdown-menu-right">
											<?php if ($permisos_editar == 1) {?>
												<a class="dropdown-item text-muted" href="#" data-toggle="modal" data-target="#caja" onclick="obtener_caja('<?php echo $user_id; ?>');"><i class='fa fa-search'></i>  Ver Caja</a>
												<a class="dropdown-item text-muted" href="#" data-toggle="modal" data-target="#cerrarCaja" onclick="obtenerx_caja('<?php echo $user_id; ?>');"><i class='ti-harddrives'></i>  Cerrar Caja</a>
											<?php }
    if ($permisos_eliminar == 1) {?>
												<a class="dropdown-item text-muted" href="#" data-toggle="modal" data-target="#myModal2" onclick="imprimir_factura('<?php echo $user_id; ?>');"><i class='fa fa-inbox'></i> Corte de Caja</a>
											<?php }
    ?>


										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">
									<?php
include "../modal/buscar_productos_ventas.php";
    include "../modal/registro_cliente.php";
    include "../modal/registro_producto.php";
    include "../modal/caja.php";
    include "../modal/anular_factura.php";
    include "../modal/cerrar_caja.php";
    ?>
									<div class="row">
										<div class="col-lg-8">
											<div class="card-box">

												<div class="widget-chart">
													<div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
													<form class="form-horizontal" role="form" id="barcode_form">
														<div class="form-group row">
															<label for="barcode_qty" class="col-md-1 control-label">CANT:</label>
															<div class="col-md-2">
																<input style=" background-color:#A9DFBF; border-radius: 5px; border: 1px solid #39c; text-align: center;" type="text" class="form-control" id="barcode_qty" value="1" autocomplete="off">
															</div>

															<label for="condiciones" class="control-label">CODIGO:</label>
															<div class="col-md-5" align="left">
																<div class="input-group">
																	<input style=" background-color:#FADBD8; border-radius: 5px; border: 1px solid #39c;" type="text" class="form-control" id="barcode" autocomplete="off"  tabindex="1" autofocus="true"  >
																	<span class="input-group-btn">
																		<button type="submit" class="btn btn-default"><span class="fa fa-barcode"></span></button>
																	</span>
																</div>
															</div>

															<div class="col-md-2">
																<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar">
																	<span class="fa fa-search"></span> Buscar
																</button>
															</div>
														</div>
													</form>

													<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

												</div>
											</div>

										</div>

										<div class="col-lg-4">
											<div class="card-box">
												<div class="widget-chart">
													<form role="form" id="datos_factura">
														<div class="form-group row">
															<label class="col-2 col-form-label"></label>
															<div class="col-12">
																<label for="fiscal">CLIENTE</label>
																<div class="input-group">
																	<input style=" background-color:#D4E6F1; border-radius: 5px; border: 1px solid #39c;" type="text" id="nombre_cliente" class="form-control" placeholder="Buscar Cliente" required  tabindex="2" value="<?php echo $row["nombre_cliente"]; ?>" onClick="this.select()">
																	<span class="input-group-btn">
																		<button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
																	</span>
																	<input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $row["id_cliente"]; ?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal"><?php echo $doc_cliente; ?></label>
																	<input type="text" class="form-control" autocomplete="off" id="rnc" name="rnc" disabled="true" value="<?php echo $row["fiscal_cliente"]; ?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="id_comp" class="control-label">FACTURA:</label>
																	<div id="resultados6"></div><!-- Carga los datos ajax -->
																</div>
															</div>

														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">NO.FACTURA</label>
																	<div id="outer_comprobante"></div><!-- Carga los datos ajax -->
																</div>
															</div>
															<!--<div class="col-md-6">
																<div class="form-group">
																	<div id="resultados4"></div>
																</div>
																<div id="resultados5"></div>
															</div>-->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="condiciones">PAGO</label>
																	<select class="form-control input-sm condiciones" id="condiciones" name="condiciones" onchange="showDiv(this)">
																		<option value="1">Efectivo</option>
																		<option value="2">Cheque</option>
																		<option value="3">Transferencia bancaria</option>
																		<option value="4">Crédito</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<div id="resultados3"></div><!-- Carga los datos ajax del incremento de la fatura -->
																	<div class="total"></div><!-- Carga los datos ajax -->
																</div>
															</div>
														</div>
														<div class="col-md-12" align="center">
															<button type="submit" id="guardar_factura" class="btn btn-danger btn-block btn-lg waves-effect waves-light" aria-haspopup="true" aria-expanded="false"><span class="fa fa-save"></span> Guardar</button>
															<!--<br><br>
															<button type="button" id="imprimir" class="btn btn-default waves-effect waves-light" onclick="printOrder('1');" accesskey="t" ><span class="fa fa-print"></span> Ticket</button>
															<button type="button" id="imprimir2" class="btn btn-default waves-effect waves-light" onclick="printFactura('1');" accesskey="p"><span class="fa fa-print"></span> Factura</button>-->
														</div>
													</form>

												</div>
											</div>

										</div>

									</div>
									<!-- end row -->


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

		<?php require 'includes/pie.php';?>

	</div>
	<!-- ============================================================== -->
	<!-- End Right content here -->
	<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/venta.js"></script>
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de Clientes -->
<script>
	$(function() {
		$("#nombre_cliente").autocomplete({
			source: "../ajax/autocomplete/clientes.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_cliente').val(ui.item.id_cliente);
				$('#nombre_cliente').val(ui.item.nombre_cliente);
				$('#rnc').val(ui.item.fiscal_cliente);
				$.Notification.notify('custom','bottom right','EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
			}
		});
	});

	$("#nombre_cliente" ).on( "keydown", function( event ) {
		if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
		{
			$("#id_cliente" ).val("");
			$("#rnc" ).val("");
			$("#resultados4").load("../ajax/tipo_doc.php");
		}
		if (event.keyCode==$.ui.keyCode.DELETE){
			$("#nombre_cliente" ).val("");
			$("#id_cliente" ).val("");
			$("#rnc" ).val("");
		}
	});
</script>
<!-- FIN -->
<script>
// print order function
function printOrder(id_factura) {
	//$('#modal_vuelto').modal('hide');//CIERRA LA MODAL
	if (id_factura) {
		$.ajax({
			url: '../pdf/documentos/imprimir_venta.php',
			type: 'post',
			data: {
				id_factura: id_factura
			},
			dataType: 'text',
			success: function(response) {
				var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
				mywindow.document.write('<html><head><title>Facturación</title>');
				mywindow.document.write('</head><body>');
				mywindow.document.write(response);
				mywindow.document.write('</body></html>');
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10
                mywindow.print();
                mywindow.close();
            } // /success function

        }); // /ajax function to fetch the printable order
    } // /if orderId
} // /print order function
</script>
<script>
// print order function
function printFactura(id_factura) {
	//$('#modal_vuelto').modal('hide');
	if (id_factura) {
		$.ajax({
			url: '../pdf/documentos/imprimir_factura_venta.php',
			type: 'post',
			data: {
				id_factura: id_factura
			},
			dataType: 'text',
			success: function(response) {
				//var mywindow = window.open('logo.png', 'Stock Management System', 'height=400,width=600');
				var WinPrint = window.open('', 'FACTURA DE VENTA', 'width=800,height=650');
				WinPrint.document.write(response);
				WinPrint.document.close();
				//WinPrint.print();
				//WinPrint.close();
                //mywindow.document.close(); // necessary for IE >= 10

            } // /success function

        }); // /ajax function to fetch the printable order
    } // /if orderId
} // /print order function
</script>
<script>
	function obtener_caja(user_id) {
		$(".outer_div3").load("../modal/carga_caja.php?user_id=" + user_id);//carga desde el ajax
	}
</script>
<script>
	function cierre_caja(user_id) {
		$(".outer_div4").load("../modal/carga_cierre.php?user_id=" + user_id);//carga desde el ajax
	}
</script>
<script>
	function showDiv(select){
		if(select.value==4){
			$("#resultados3").load("../ajax/carga_prima.php");
		} else{
			$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
	function comprobar(select){
		var rnc = $("#rnc").val();
		if(select.value==1 && rnc==''){
			$.Notification.notify('warning','bottom center','NOTIFICACIÓN', 'AL CLIENTE SELECCIONADO NO SE LE PUEDE IMPRIR LA FACTURA, NO TIENE RNC/DEDULA REGISTRADO')
			$("#resultados4").load("../ajax/tipo_doc.php");
		} else{
			//$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
</script>
<script>
	function getval(sel)
	{
		$.Notification.notify('success', 'bottom center', 'NOTIFICACIÓN', 'CAMBIO DE COMPROBANTE')
		$("#outer_comprobante").load("../ajax/carga_correlativos.php?id_comp="+sel.value);

	}
</script>

<?php require 'includes/footer_end.php'
?>

