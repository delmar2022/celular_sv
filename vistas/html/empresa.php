<?php
/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
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
$modulo = "Configuracion";
permisos($modulo, $cadena_permisos);
//consulta para elegir el comprobante

$query_empresa = mysqli_query($conexion, "select * from perfil, clientes where perfil.cliente_id= clientes.id_cliente  and perfil.id_perfil=1");
$row           = mysqli_fetch_array($query_empresa);
?>
<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper">

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
									Datos de Empresa
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

									<form class="form-horizontal" role="form" id="perfil">
										<div class="row">
											<div class="col-md-3">
												<div align="center"  id="load_img">
													<img src="<?php echo $row['logo_url']; ?>" class="img-thumbnai" width="250px" height="225px">
												</div>
												<div class="form-group">
													<input class="form-control" data-buttonText="Logo" type="file" name="imagefile" id="imagefile" onchange="upload_image();">
												</div>
												<div class="text-center">
												</div>

											</div>
											<!-- end col -->

											<div class="col-md-9">
												<div class="card-box">

													<div class="accordion mb-3" id="accordionExample">
														<div class="card mb-1">
															<div class="card-header" id="headingOne">
																<h5 class="my-0">
																	<a class="text-primary" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																		Configuración Empresa
																	</a>
																</h2>
															</div>

															<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
																<div class="card-body">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Razón Social:</label>
																				<input type="text" class="form-control UpperCase" name="nombre_empresa" value="<?php echo $row['nombre_empresa'] ?>" required autocomplete="off">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Giro:</label>
																				<input type="text" class="form-control UpperCase" name="giro" value="<?php echo $row['giro_empresa'] ?>" required autocomplete="off">
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="nombre" class="control-label">No. documento Fiscal:</label>
																				<input type="text" class="form-control" required name="fiscal" value="<?php echo $row['fiscal_empresa'] ?>" autocomplete="off" >
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Teléfono:</label>
																				<input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono'] ?>" required autocomplete="off">
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Email:</label>
																				<input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" >
																			</div>
																		</div>
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Impuesto %:</label>
																				<input type="text" class="form-control" required name="impuesto" value="<?php echo $row['impuesto'] ?>" autocomplete="off" >
																			</div>
																		</div>
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Nombre Impuesto:</label>
																				<input type="text" class="form-control UpperCase" required name="nom_impuesto" value="<?php echo $row['nom_impuesto'] ?>" autocomplete="off" >
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Moneda:</label>
																				<select class='form-control input-sm' name="moneda" required>
																					<?php
$sql   = "select name, symbol from  currencies group by symbol order by name ";
    $query = mysqli_query($conexion, $sql);
    while ($rw = mysqli_fetch_array($query)) {
        $simbolo = $rw['symbol'];
        $moneda  = $rw['name'];
        if ($row['moneda'] == $simbolo) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        ?>
																						<option value="<?php echo $simbolo; ?>" <?php echo $selected; ?>><?php echo ($simbolo); ?></option>
																						<?php
}
    ?>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-9">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Dirección:</label>
																				<input type="text" class="form-control UpperCase" name="direccion" value="<?php echo $row["direccion"]; ?>" required autocomplete="off" >
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Ciudad:</label>
																				<input type="text" class="form-control UpperCase" name="ciudad" value="<?php echo $row["ciudad"]; ?>">
																			</div>
																		</div>
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Región/Provincia:</label>
																				<div class="col-sm-9">
																					<input type="text" class="form-control UpperCase" name="estado" value="<?php echo $row["estado"]; ?>">
																				</div>
																			</div>
																		</div>
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Código postal:</label>
																				<input type="text" class="form-control UpperCase" name="codigo_postal" value="<?php echo $row["codigo_postal"]; ?>" autocomplete="off">

																			</div>
																		</div>
																	</div>


																</div>
															</div>
														</div>
														<div class="card mb-1">
															<div class="card-header" id="headingTwo">
																<h5 class="my-0">
																	<a class="text-primary collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
																		Configuración Ventas
																	</a>
																</h5>
															</div>
															<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
																<div class="card-body">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Cliente Default Ventas:</label>
																				<input style=" background-color:#D4E6F1; border-radius: 5px; border: 1px solid #39c;" type="text" id="nombre_cliente" class="form-control" placeholder="Buscar Cliente" required  tabindex="2" value="<?php echo $row["nombre_cliente"]; ?>">
																				<input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $row["id_cliente"]; ?>">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="nombre" class="control-label">Comprobante default:</label>
																				<select id = "id_comp" class = "form-control" name = "id_comp" required autocomplete="off" onchange="getval(this);">
																					<?php
$sql   = "select * from  comprobantes order by nombre_comp ";
    $query = mysqli_query($conexion, $sql);
    while ($rrw = mysqli_fetch_array($query)) {
        $id_comp = $rrw['id_comp'];
        $nombre  = $rrw['nombre_comp'];
        if ($row['comp_id'] == $id_comp) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        ?>
																						<option value="<?php echo $id_comp; ?>" <?php echo $selected; ?>><?php echo ($nombre); ?></option>
																						<?php
}
    ?>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<div class="form-group">
																				<label for="pv" class="control-label">Cambiar Precios en venta:</label>
																				<select class="form-control" id="pv" name="pv">
																					<option value="1" <?php if ($row["precio_venta"] == '1') {echo 'selected';}?>>Permitir</option>
																					<option value="0" <?php if ($row["precio_venta"] == '0') {echo 'selected';}?>>No permitir</option>
																				</select>
																			</div>
																		</div>

																	</div>
																</div>
															</div>
														</div>
														<div class="card mb-1">
															<div class="card-header" id="headingThree">
																<h5 class="my-0">
																	<a class="text-primary collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
																		Configuración de otros campos
																	</a>
																</h5>
															</div>
															<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
																<div class="card-body">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="doc_cliente" class="control-label">Documento Cliente:</label>
																				<input type="text" class="form-control UpperCase" name="doc_cliente" value="<?php echo $row["doc_cliente"]; ?>" required autocomplete="off">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="doc_proveedor" class="control-label">Documento Proveedor:</label>
																				<input type="text" class="form-control UpperCase" name="doc_proveedor" value="<?php echo $row["doc_proveedor"]; ?>" required autocomplete="off">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>


													<div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->


													<div class="form-group m-b-0 row">
														<div class="offset-3 col-sm-9">
															<button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-refresh"></i> Guardar Cambios</button>
														</div>
													</div>
												</form>

											</div>

										</div>
										<!-- end row -->


									</div>
									<!-- /.box -->


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
					</div>
				</div>
			</div>


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
	$( "#perfil" ).submit(function( event ) {
		$('.guardar_datos').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "../ajax/editar_perfil.php",
			data: parametros,
			beforeSend: function(objeto){
				$("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			},
			success: function(datos){
				$("#resultados_ajax").html(datos);
				$('.guardar_datos').attr("disabled", false);
        //desaparecer la alerta
        $(".alert-success").delay(400).show(10, function() {
        	$(this).delay(2000).hide(10, function() {
        		$(this).remove();
        	});
              }); // /.alert

    }
});
		event.preventDefault();
	})



</script>

<script>
	function upload_image(){

		var inputFileImage = document.getElementById("imagefile");
		var file = inputFileImage.files[0];
		if( (typeof file === "object") && (file !== null) )
		{
			$("#load_img").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			var data = new FormData();
			data.append('imagefile',file);


			$.ajax({
            url: "../ajax/imagen_ajax.php",        // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: data,         // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
            	$("#load_img").html(data);

            }
        });
		}


	}
</script>
<script>
	$(document).ready( function () {
		$(".UpperCase").on("keypress", function () {
			$input=$(this);
			setTimeout(function () {
				$input.val($input.val().toUpperCase());
			},50);
		})
	})
</script>

<?php require 'includes/footer_end.php'
?>

