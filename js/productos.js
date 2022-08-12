$(document).ready(function () {
  $("#cod_resultado").load("../ajax/incrementa_cod_prod.php");
  load(1);
});

function load(page) {
  var q = $("#q").val();
  var categoria = $("#categoria").val();
  var estadoo = $("#estadoo").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_productos.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&categoria=" +
      categoria +
      "&estadoo=" +
      estadoo,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}
$("#guardar_producto").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/nuevo_producto.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#guardar_datos").attr("disabled", false);
      $("#cod_resultado").load("../ajax/incrementa_cod_prod.php");
      load(1);
      //resetea el formulario
      $("#guardar_producto")[0].reset();
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(500, 0)
          .slideUp(500, function () {
            $(this).remove();
          });
      }, 5000);
    },
  });
  event.preventDefault();
});
$("#editar_producto").submit(function (event) {
  $("#actualizar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/editar_producto.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax2").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax2").html(datos);
      $("#actualizar_datos").attr("disabled", false);
      load(1);
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(500, 0)
          .slideUp(500, function () {
            $(this).remove();
          });
      }, 5000);
    },
  });
  event.preventDefault();
});
$("#dataDelete").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Botón que activó el modal
  var id = button.data("id"); // Extraer la información de atributos de datos
  var modal = $(this);
  modal.find("#id_producto").val(id);
});
$("#eliminarDatos").submit(function (event) {
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/eliminar_producto.php",
    data: parametros,
    beforeSend: function (objeto) {
      $(".datos_ajax_delete").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $(".datos_ajax_delete").html(datos);
      $("#dataDelete").modal("hide");
      load(1);
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(200, 0)
          .slideUp(200, function () {
            $(this).remove();
          });
      }, 2000);
    },
  });
  event.preventDefault();
});

function obtener_datos(id) {
  var codigo_producto = $("#codigo_producto" + id).val();
  var nombre_producto = $("#nombre_producto" + id).val();
  var marca_producto = $("#marca_producto" + id).val();
  var modelo_producto = $("#modelo_producto" + id).val();
  var color_producto = $("#color_producto" + id).val();
  var emei_producto = $("#emei_producto" + id).val();
  var estado_producto = $("#estado_producto" + id).val();
  var costo_producto = $("#costo_producto" + id).val();
  var utilidad_producto = $("#utilidad_producto" + id).val();
  var precio_producto = $("#precio_producto" + id).val();
  var status = $("#status" + id).val();
  $("#mod_id").val(id);
  $("#codigo2").val(codigo_producto);
  $("#nombre2").val(nombre_producto);
  $("#marca2").val(marca_producto);
  $("#modelo2").val(modelo_producto);
  $("#color2").val(color_producto);
  $("#emei2").val(emei_producto);
  $("#estado2").val(estado_producto);
  $("#costo2").val(costo_producto);
  $("#utilidad2").val(utilidad_producto);
  $("#precio2").val(precio_producto);
  $("#status2").val(status);
}
