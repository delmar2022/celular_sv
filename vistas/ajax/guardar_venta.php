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
    //Comprobamos si hay archivos en la tabla temporal
    $sql_count = mysqli_query($conexion, "select * from tmp_ventas where session_id='" . $session_id . "'");
    $count     = mysqli_num_rows($sql_count);
    if ($count == 0) {
        echo "<script>
        swal({
          title: 'No hay Productos agregados en la factura',
          text: 'Intentar nuevamente',
          type: 'error',
          confirmButtonText: 'ok'
      })</script>";
        exit;
    }
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_cliente     = intval($_POST['id_cliente']);
    $id_comp        = intval($_POST['id_comp']);
    $id_vendedor    = intval($_SESSION['id_users']);
    $users          = intval($_SESSION['id_users']);
    $condiciones    = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
    $numero_factura = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["factura"], ENT_QUOTES)));
    $resibido       = floatval($_POST['resibido']);
    $total_ft       = floatval($_POST['total_ft']);
    $date_added     = date("Y-m-d H:i:s");
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
    $sql         = mysqli_query($conexion, "select * from comprobantes where  id_comp ='$id_comp'");
    $rw          = mysqli_fetch_array($sql);
    $serie_comp  = $rw['serie_comp'];
    $desde_comp  = $rw['desde_comp'];
    $hasta_comp  = $rw['hasta_comp'];
    $actual_comp = $rw['actual_comp'];
    $long_comp   = $rw['long_comp'];
    $query = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_ventas WHERE id_comp_factura='$id_comp' ORDER BY factura DESC LIMIT 1") or die('error ' . mysqli_error($conexion));
    $count = mysqli_num_rows($query);
    if ($count != 0) {
        $row     = mysqli_fetch_assoc($query);
        $factura = $row['factura'] + 1;
    } else {
        $factura = $actual_comp;
    }
    $formato = str_pad($factura, $long_comp, "0", STR_PAD_LEFT);
    $factura = $serie_comp . '' . $formato;
    //Seleccionamos el ultimo compo numero_fatura y aumentamos una
    $sql        = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from facturas_ventas order by id_factura desc limit 0,1 ");
    $rw         = mysqli_fetch_array($sql);
    $id_factura = isset($rw['last']) + 1;
    // consulta principal
    $nums           = 1;
    $impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $sumador_total  = 0;
    $sum_total      = 0;
    $total_impuesto = 0;
    $t_iva          = 0;
    $sql            = mysqli_query($conexion, "select * from productos, tmp_ventas where productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
    while ($row = mysqli_fetch_array($sql)) {
        $id_tmp          = $row["id_tmp"];
        $id_producto     = $row['id_producto'];
        $codigo_producto = $row['codigo_producto'];
        $cantidad        = $row['cantidad_tmp'];
        $desc_tmp        = $row['desc_tmp'];
        $nombre_producto = $row['nombre_producto'];

        $precio_venta   = $row['precio_tmp'];
        $costo_producto = $row['costo_producto'];
        $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
        $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
        $precio_total   = $precio_venta_r * $cantidad;
        $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
        /*--------------------------------------------------------------------------------*/
        $precio_total_f = number_format($final_items, 2); //Precio total formateado
        $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
        $sumador_total += $precio_total_r; //Sumador
        /* CONTROL DEL IVA */
        $subtotal = number_format($sumador_total, 2, '.', '');

        $total_impuesto = 0;
        /* FIN DEL IVA*/
        //Insert en la tabla detalle_factura
        $insert_detail = mysqli_query($conexion, "INSERT INTO detalle_fact_ventas VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$precio_total')");
        //GURDAMOS LAS EN EL KARDEX
        $saldo_total = $cantidad * $costo_producto;
        $sql_kardex  = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
        $rww         = mysqli_fetch_array($sql_kardex);
        $id_prod     = $rww['producto_kardex'];
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
        $update  = mysqli_query($conexion, "UPDATE productos SET stock_producto='" . $new_qty . "' WHERE id_producto='" . $id_producto . "'"); //Actualizo la nueva cantidad en el inventario

        $nums++;
    }
    // Fin de la consulta Principal
    $total_factura    = $subtotal + $total_impuesto;
    $cambio           = $resibido - $total_ft;
    $saldo_credito    = $total_ft - $resibido;
    $camb             = number_format($cambio, 2);
    $resibido_formato = number_format($resibido, 2);
    /* OPCIONES DE CREDITOS*/
    if ($condiciones == 4) {
        $insert_prima = mysqli_query($conexion, "INSERT INTO creditos VALUES (NULL,'$factura','$date_added','$id_cliente','$id_vendedor','$total_ft','$saldo_credito','1','$users','1')");
        $insert_abono = mysqli_query($conexion, "INSERT INTO creditos_abonos VALUES (NULL,'$factura','$date_added','$id_cliente','$total_ft','$resibido','$saldo_credito','$users','1','CREDITO INICAL')");
    }
    /* FIN DE CREDITOS */
    $insert     = "INSERT INTO facturas_ventas VALUES (NULL,'$factura','$date_added','$id_cliente','$id_vendedor','$condiciones','$total_ft','$estado','$users','$resibido','1','$id_comp','0')";
    $factura_id = '';
    if ($conexion->query($insert) === true) {
        $factura_id          = $conexion->insert_id;
        $valid['id_factura'] = $factura_id;
    }

    $delete = mysqli_query($conexion, "DELETE FROM tmp_ventas WHERE session_id='" . $session_id . "'");
    // SI TODO ESTA CORRECTO
    if ($condiciones == 4) {
        echo "<script>
        swal({
          title: 'VENTA AL CREDITO GUARDADA CON EXITO CON ATICIPO DE: $simbolo_moneda $resibido_formato',
          text: 'Factura: $numero_factura',
          type: 'success',
          confirmButtonText: 'ok'
      })
  </script>";
        exit;
    }
    if ($insert_detail) {
        echo "<script>
        $('#outer_comprobante').load('../ajax/carga_correlativos.php');
        $('#resultados5').load('../ajax/carga_num_trans.php')
    $('#modal_vuelto').modal('show');
    $('#id_cliente' ).val(1);
    $('#resultados6').load('../ajax/carga_comprobantes.php');
    $('#outer_comprobante').load('../ajax/carga_correlativoDefault.php');
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
                <strong>
                    <h3>CAMBIO</h3>
                </strong>
                <div class="alert alert-info" align="center">
                    <strong>
                        <h1>
                            <?php echo $simbolo_moneda . ' ' . $camb; ?>

                        </h1>
                    </strong>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="imprimir" class="btn btn-primary btn-block btn-lg waves-effect waves-light" onclick="printOrder('<?php echo $factura_id; ?>');" accesskey="t"><span class="fa fa-print"></span> Ticket</button><br>
                <button type="button" id="imprimir2" class="btn btn-success btn-block btn-lg waves-effect waves-light" onclick="printFactura('<?php echo $factura_id; ?>');" accesskey="p"><span class="fa fa-print"></span> Factura</button>
            </div>
        </div>
    </div>
</div>