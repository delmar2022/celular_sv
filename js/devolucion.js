$(document).ready(function() {
    load(1);
    $("#resultados").load("../ajax/devolucion_tmp.php");
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../ajax/productos_modal_ventas.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}


function eliminar(id) {
    $.ajax({
        type: "GET",
        url: "../ajax/devolucion_tmp.php",
        data: "id=" + id,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $.Notification.notify('warning', 'bottom center', 'NOTIFICACIÓN', 'LA CANTIDAD FUE AGREGADA AL INVENTARIO')
            $("#resultados").html(datos);
        }
    });
}

function imprimir_factura(id_factura) {
    VentanaCentrada('../pdf/documentos/ver_factura.php?id_factura=' + id_factura, 'Factura', '', '724', '568', 'true');
}