		$(document).ready(function() {
		    load(1);
		});

		function load(page) {
		    var q = $("#q").val();
		    $("#loader").fadeIn('slow');
		    $.ajax({
		        url: '../ajax/buscar_marca.php?action=ajax&page=' + page + '&q=' + q,
		        beforeSend: function(objeto) {
		            $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(data) {
		            $(".outer_div").html(data).fadeIn('slow');
		            $('#loader').html('');
		            $('[data-toggle="tooltip"]').tooltip({
		                html: true
		            });
		        }
		    })
		}
		$("#guardar_marca").submit(function(event) {
		    $('#guardar_datos').attr("disabled", true);
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/nueva_marca.php",
		        data: parametros,
		        beforeSend: function(objeto) {
		            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
		        },
		        success: function(datos) {
		            $("#resultados_ajax").html(datos);
		            $('#guardar_datos').attr("disabled", false);
		            load(1);
		            //resetea el formulario
		            $("#guardar_marca")[0].reset();
		            $("#nombre").focus();
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
		$("#editar_marca").submit(function(event) {
		    $('#actualizar_datos').attr("disabled", true);
		    var parametros = $(this).serialize();
		    $.ajax({
		        type: "POST",
		        url: "../ajax/editar_marca.php",
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

		function obtener_datos(id) {
		    var nombre = $("#nombre" + id).val();
		    var estado = $("#estado" + id).val();
		    $("#mod_nombre").val(nombre);
		    $("#mod_estado").val(estado);
		    $("#mod_id").val(id);
		}