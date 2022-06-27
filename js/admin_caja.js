		$(document).ready(function() {
			load(1);
		});

		function load(page){
			var range=$("#range").val();
			var employee_id=$("#employee_id").val();
			var parametros = {"action":"ajax","page":page,'range':range,'employee_id':employee_id};
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'../ajax/admin_caja.php',
				data: parametros,
				beforeSend: function(objeto){
					$("#loader").html("<img src='../../img/ajax-loader.gif'>");
				},
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$("#loader").html("");
				}
			})
		}
	
		$("#egreso_caja").submit(function(event) {
		    $('#guardar_datos').attr("disabled", true);
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/nuevo_egreso.php",
		        data: parametros,
		        beforeSend: function(objeto) {
		            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(datos) {
		            $("#resultados_ajax").html(datos);
		            $('#guardar_datos').attr("disabled", false);
		            load(1);
		            //resetea el formulario
		            $("#egreso_caja")[0].reset();
		            $("#fecha").focus();
		            //desaparecer la alerta
		            window.setTimeout(function() {
		                $(".alert").fadeTo(200, 0).slideUp(200, function() {
		                    $(this).remove();
		                });
		            }, 2000);
		        }
		    });
		    event.preventDefault();
		})
			$("#editar_egreso").submit(function(event) {
		    $('#actualizar_datos').attr("disabled", true);
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/editar_egreso.php",
		        data: parametros,
		        beforeSend: function(objeto) {
		            $("#resultados_ajax2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(datos) {
		            $("#resultados_ajax2").html(datos);
		            $('#actualizar_datos').attr("disabled", false);
		            load(1);
		            //desaparecer la alerta
		            window.setTimeout(function() {
		                $(".alert").fadeTo(200, 0).slideUp(200, function() {
		                    $(this).remove();
		                });
		            }, 2000);
		        }
		    });
		    event.preventDefault();
		})
		$('#dataDelete').on('show.bs.modal', function(event) {
		    var button = $(event.relatedTarget) // Botón que activó el modal
		    var id = button.data('id') // Extraer la información de atributos de datos
		    var modal = $(this)
		    modal.find('#id_marca').val(id)
		})
		$("#eliminarDatos").submit(function(event) {
			var parametros = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "../ajax/eliminar_marca.php",
				data: parametros,
				beforeSend: function(objeto) {
					$(".datos_ajax_delete").html('<img src="../../img/ajax-loader.gif"> Cargando...');
				},
				success: function(datos) {
					$(".datos_ajax_delete").html(datos);
					$('#dataDelete').modal('hide');
					load(1);
		            //desaparecer la alerta
		            window.setTimeout(function() {
		            	$(".alert").fadeTo(200, 0).slideUp(200, function() {
		            		$(this).remove();
		            	});
		            }, 2000);
		        }
		    });
			event.preventDefault();
		});

			$('#dataDelete').on('show.bs.modal', function(event) {
		    var button = $(event.relatedTarget) // Botón que activó el modal
		    var id = button.data('id') // Extraer la información de atributos de datos
		    var modal = $(this)
		    modal.find('#id_egreso').val(id)
		})
		$("#eliminarDatos").submit(function(event) {
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/eliminar_egreso.php",
		        data: parametros,
		        beforeSend: function(objeto) {
		            $(".datos_ajax_delete").html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(datos) {
		            $(".datos_ajax_delete").html(datos);
		            $('#dataDelete').modal('hide');
		            load(1);
		            //desaparecer la alerta
		            window.setTimeout(function() {
		                $(".alert").fadeTo(200, 0).slideUp(200, function() {
		                    $(this).remove();
		                });
		            }, 2000);
		        }
		    });
		    event.preventDefault();
		});

		function obtener_datos(id) {
			var referencia_caja = $("#referencia_caja" + id).val();
			var fecha_caja = $("#fecha_caja" + id).val();
			var hora_caja = $("#hora_caja" + id).val();
			var monto_caja = $("#monto_caja" + id).val();
			var descripcion_caja = $("#descripcion_caja" + id).val();
			var tipo_caja = $("#tipo_caja" + id).val();
			$("#fecha2").val(fecha_caja);
			$("#hora2").val(hora_caja);
			$("#importe2").val(monto_caja);
			$("#concepto2").val(referencia_caja);
			$("#tipo2").val(tipo_caja);
			$("#obs2").val(descripcion_caja);
			$("#mod_id").val(id);
		}