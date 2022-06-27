<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_cliente'])) {
    $errors[] = "ID VACIO";
} else if (!empty($_POST['id_cliente'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    //Archivo de funciones PHP
    require_once "../funciones.php";
    $session_id     = session_id();
    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_cliente        = intval($_POST['id_cliente']);
    $id_vendedor       = intval($_SESSION['id_users']);
    $users             = intval($_SESSION['id_users']);
    $condiciones       = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
    $numero_cotizacion = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["cotizacion"], ENT_QUOTES)));
    $numero_factura    = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["factura"], ENT_QUOTES)));
    $id_comp           = intval($_POST['id_comp']);
    //$tip_doc           = intval($_POST['tip_doc']);
    //$trans             = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["trans"], ENT_QUOTES)));
    $resibido   = floatval($_POST['resibido']);
    $total_ft   = floatval($_POST['total_ft']);
    $date_added = date("Y-m-d H:i:s");
    //Operacion de Creditos
    if ($condiciones == 4) {
        $estado = 2;
    } else {
        $estado = 1;
    }
    //Comprobamos que el dinero Resibido no sea menor al Totalde la factura
    if ($resibido < $total_ft and $condiciones != 4) {
        echo "<script>
            swal({
              title: 'DINERO RESIBIDO ES MENOR AL MONTO TOTAL',
              text: 'Intentar Nuevamente',
              type: 'error',
              confirmButtonText: 'ok'
          })</script>";
        exit;
    }
//Seleccionamos el ultimo compo numero_fatura y aumentamos una
    $sql        = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from facturas_ventas order by id_factura desc limit 0,1 ");
    $rw         = mysqli_fetch_array($sql);
    $id_factura = isset($rw['last']) + 1;
// finde la ultima fatura
    //Control de la  numero_fatura y aumentamos una
    $query_id = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_ventas ORDER BY factura DESC LIMIT 1")
    or die('error ' . mysqli_error($conexion));
    $count = mysqli_num_rows($query_id);

    if ($count != 0) {

        $data_id = mysqli_fetch_assoc($query_id);
        $fact = $data_id['factura'] + 1;
    } else {
        $fact = 1;
    }

    $buat_id = str_pad($fact, 6, "0", STR_PAD_LEFT);
    $factura = "CFF-$buat_id";
// fin de numero de fatura
    // consulta principal
    $nums           = 1;
    $impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $sumador_total  = 0;
    $sum_total      = 0;
    $t_iva          = 0;
    $total_impuesto = 0;
    $sql            = mysqli_query($conexion, "select * from productos, detalle_fact_cot where productos.id_producto=detalle_fact_cot.id_producto and detalle_fact_cot.numero_factura='" . $numero_cotizacion . "'");
    while ($row = mysqli_fetch_array($sql)) {
        $id_tmp          = $row["id_detalle"];
        $id_producto     = $row['id_producto'];
        $codigo_producto = $row['codigo_producto'];
        $cantidad        = $row['cantidad'];
        $desc_tmp        = $row['desc_venta'];
        $nombre_producto = $row['nombre_producto'];

        $precio_venta   = $row['precio_venta'];
        $costo_producto = $row['costo_producto'];
        $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
        $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
        $precio_total   = $precio_venta_r * $cantidad;
        $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
        /*--------------------------------------------------------------------------------*/
        $precio_total_f = number_format($final_items, 2); //Precio total formateado
        $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
        $sumador_total += $precio_total_r; //Sumador
        $subtotal = number_format($sumador_total, 2, '.', '');
        if ($row['iva_producto'] == 1) {
            $total_iva = iva($precio_venta);
        } else {
            $total_iva = 0;
        }
        $total_impuesto += rebajas($total_iva, $desc_tmp) * $cantidad;
        $total_factura = $subtotal + $total_impuesto;

        //Insert en la tabla detalle_factura
        $insert_detail = mysqli_query($conexion, "INSERT INTO detalle_fact_ventas VALUES (NULL,'$id_factura','$numero_factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$precio_total')");
        //GURDAMOS LAS EN EL KARDEX
        $saldo_total = $cantidad * $costo_producto;
        $sql_kardex  = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
        $rww         = mysqli_fetch_array($sql_kardex);
        $id_producto = $rww['producto_kardex'];
        $costo_saldo = $rww['costo_saldo'];
        $cant_saldo  = $rww['cant_saldo'] - $cantidad;
        //$nueva_cantidad = $cant_saldo - $cantidad;
        $nuevo_saldo = $cant_saldo * $costo_producto;
        $tipo        = 2;

        guardar_salidas($date_added, $id_producto, $cantidad, $costo_producto, $saldo_total, $cant_saldo, $costo_saldo, $nuevo_saldo, $date_added, $users, $tipo);
// FIN
        // ACTUALIZA EN EL STOCK
        $sql2    = mysqli_query($conexion, "select * from productos where id_producto='" . $id_producto . "'");
        $rw      = mysqli_fetch_array($sql2);
        $old_qty = $rw['stock_producto']; //Cantidad encontrada en el inventario
        $new_qty = $old_qty - $cantidad; //Nueva cantidad en el inventario
        $update  = mysqli_query($conexion, "UPDATE productos SET stock_producto='" . $new_qty . "' WHERE id_producto='" . $id_producto . "' and inv_producto=0"); //Actualizo la nueva cantidad en el inventario

        $nums++;
    }
    // Fin de la consulta Principal
    $subtotal  = number_format($sumador_total, 2, '.', '');
    $total_iva = ($subtotal * $impuesto) / 100;
    $total_iva = number_format($total_iva, 2, '.', '') - number_format($t_iva, 2, '.', '');
    //$total_factura    = $subtotal + $total_iva;

    $cambio           = $resibido - $total_factura;
    $saldo_credito    = $total_factura - $resibido;
    $camb             = number_format($cambio, 2);
    $resibido_formato = number_format($resibido, 2);

    if ($condiciones == 4) {
        $insert_prima = mysqli_query($conexion, "INSERT INTO creditos VALUES (NULL,'$factura','$date_added','$id_cliente','$id_vendedor','$total_ft','$saldo_credito','1','$users','1')");
        $insert_abono = mysqli_query($conexion, "INSERT INTO creditos_abonos VALUES (NULL,'$factura','$date_added','$id_cliente','$total_ft','$resibido','$saldo_credito','$users','1','CREDITO INICAL')");
    }

    $insert = mysqli_query($conexion, "INSERT INTO facturas_ventas VALUES (NULL,'$numero_factura','$date_added','$id_cliente','$id_vendedor','$condiciones','$total_ft','$estado','$users','$resibido','1','$id_comp','')");
    // SI TODO ESTA CORRECTO
    if ($condiciones == 4) {
        echo "<script>
        swal({
          title: 'VENTA AL CREDITO GUARDADA CON EXITO CON ATICIPO DE: $simbolo_moneda $resibido_formato',
          text: 'Factura: $factura',
          type: 'success',
          confirmButtonText: 'ok'
      })
  </script>";
        exit;
    }
    if ($insert_detail) {
        echo "<script>
    $('#modal_vuelto').modal('show');
</script>";
        #$messages[] = "Venta  ha sido Guardada satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
    <?php
}
if (isset($messages)) {

    ?>
    <div class="alert alert-success" role="alert">
        <strong>¡Bien hecho!</strong>
        <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
    </div>
    <?php
}

?>
<!-- Modal -->
<div class="modal fade" id="modal_vuelto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> FACTURA: <?php echo $factura; ?></h4>
            </div>
            <div class="modal-body" align="center">
                <strong><h3>CAMBIO</h3></strong>
                <div class="alert alert-info" align="center">
                    <strong><h1>
                        <?php echo $simbolo_moneda . ' ' . $camb; ?>

                    </h1></strong>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="imprimir" class="btn btn-primary btn-block btn-lg waves-effect waves-light" onclick="printOrder('1');" accesskey="t" ><span class="fa fa-print"></span> Ticket</button><br>
                <button type="button" id="imprimir2" class="btn btn-success btn-block btn-lg waves-effect waves-light" onclick="printFactura('1');" accesskey="p"><span class="fa fa-print"></span> Factura</button>
            </div>
        </div>
    </div>
</div>