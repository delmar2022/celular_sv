<?php
/*-------------------------
Autor: Delmar Lopez
Web: www.softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id = session_id();
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Archivo de funciones PHP
require_once "../funciones.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['cantidad'])) {
    $cantidad = $_POST['cantidad'];
}
if (isset($_POST['precio_venta'])) {
    $precio_venta = $_POST['precio_venta'];
}

if (!empty($id) and !empty($cantidad) and !empty($precio_venta)) {
    // consulta para comparar el stock con la cantidad resibida
    $query = mysqli_query($conexion, "select stock_producto from productos where id_producto = '$id'");
    $rw    = mysqli_fetch_array($query);
    $stock = $rw['stock_producto'];

    //Comprobamos si agregamos un producto a la tabla tmp_compra
    $comprobar = mysqli_query($conexion, "select * from tmp_ventas, productos where productos.id_producto = tmp_ventas.id_producto and tmp_ventas.id_producto='" . $id . "' and tmp_ventas.session_id='" . $session_id . "'");
    if ($row = mysqli_fetch_array($comprobar)) {
        $cant = $row['cantidad_tmp'] + $cantidad;
        // condicion si el stock e menor que la cantidad requerida
        if ($cant > $row['stock_producto']) {
            echo "<script>swal('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
            $('#resultados').load('../ajax/agregar_tmp.php');
            </script>";
            exit;
        } else {
            $sql          = "UPDATE tmp_ventas SET cantidad_tmp='" . $cant . "', precio_tmp='" . $precio_venta . "' WHERE id_producto='" . $id . "' and session_id='" . $session_id . "'";
            $query_update = mysqli_query($conexion, $sql);
            echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')</script>";
        }
        // fin codicion cantaidad

    } else {
        // condicion si el stock e menor que la cantidad requerida
        if ($cantidad > $stock) {
            echo "<script>swal('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTEx', 'error')
            $('#resultados').load('../ajax/agregar_tmp.php');
            </script>";
            exit;
        } else {
            $insert_tmp = mysqli_query($conexion, "INSERT INTO tmp_ventas (id_producto,cantidad_tmp,precio_tmp,desc_tmp,session_id) VALUES ('$id','$cantidad','$precio_venta','0','$session_id')");
            echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')</script>";
        }
        // fin codicion cantaidad
    }
}
if (isset($_GET['id'])) //codigo elimina un elemento del array
{
    $id_tmp = intval($_GET['id']);
    $delete = mysqli_query($conexion, "DELETE FROM tmp_ventas WHERE id_tmp='" . $id_tmp . "'");
}
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
$pv             = get_row('perfil', 'precio_venta', 'id_perfil', 1);
if ($pv == 0) {
    $ok = 'disabled';
} else {
    $ok = '';
}
?>
<div class="table-responsive">
    <table class="table table-sm">
        <thead class="thead-default">
            <tr>
                <th class='text-center'>COD</th>
                <th class='text-center'>CANT.</th>
                <th class='text-center'>DESCRIP.</th>
                <th class='text-center'>P.UNITARIO <?php echo $simbolo_moneda; ?></th>
                <th class='text-center'>DESC $</th>
                <th class='text-right'>TOTAL</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
            $nom_impuesto   = get_row('perfil', 'nom_impuesto', 'id_perfil', 1);
            $sumador_total  = 0;
            $total_iva      = 0;
            $total_impuesto = 0;
            $subtotal       = 0;
            $t              = 0;
            $sql            = mysqli_query($conexion, "select * from productos, tmp_ventas where productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
            while ($row = mysqli_fetch_array($sql)) {
                $id_tmp          = $row["id_tmp"];
                $codigo_producto = $row['codigo_producto'];
                $id_producto     = $row['id_producto'];
                $cantidad        = $row['cantidad_tmp'];
                $desc_tmp        = $row['desc_tmp'];
                $nombre_producto = $row['nombre_producto'];

                $precio_venta   = $row['precio_tmp'];
                $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
                $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
                $precio_total   = $precio_venta_r * $cantidad;
                $final_items = $precio_total - $desc_tmp; //Aplicando el descuento
                /*--------------------------------------------------------------------------------*/
                $precio_total_f = number_format($final_items, 2); //Precio total formateado
                $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
                $sumador_total += $precio_total_r; //Sumador
                //$final_items = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
                $subtotal    = number_format($sumador_total, 2, '.', '');

                $total_impuesto += rebajas($total_iva, $desc_tmp) * $cantidad;
                //$total_iva_full = rebajas($total_impuesto, $desc_tmp);
                $t = $subtotal * 0.01;
            ?>
                <tr>
                    <td class='text-center'><?php echo $codigo_producto; ?></td>
                    <td class='text-center' width="15%">
                        <input style=" background-color:#A9DFBF; border-radius: 5px; border: 1px solid #39c; text-align: center" type="text" class="form-control txt_cant" style="text-align:center" value="<?php echo $cantidad; ?>" id="<?php echo $id_tmp; ?>">
                    </td>
                    <td><?php echo $nombre_producto; ?></td>
                    <td class='text-center'>
                        <div class="input-group">
                            <select id="<?php echo $id_tmp; ?>" class="form-control employee_id" <?php echo $ok; ?>>
                                <?php
                                $sql1 = mysqli_query($conexion, "select * from productos where id_producto='" . $id_producto . "'");
                                while ($rw1 = mysqli_fetch_array($sql1)) {
                                ?>
                                    <option selected disabled value="<?php echo $precio_venta ?>"><?php echo number_format($precio_venta, 2); ?></option>
                                    <option value="<?php echo $rw1['valor1_producto'] ?>">PV <?php echo number_format($rw1['valor1_producto'], 2); ?></option>
                                    <option value="<?php echo $rw1['valor2_producto'] ?>">PM <?php echo number_format($rw1['valor2_producto'], 2); ?></option>
                                    <option value="<?php echo $rw1['valor3_producto'] ?>">PE <?php echo number_format($rw1['valor3_producto'], 2); ?></option>
                                    <option value="<?php echo $rw1['valor4_producto'] ?>">PP <?php echo number_format($rw1['valor4_producto'], 2); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                    <td align="right" width="15%">
                        <input style=" background-color:#F7DC6F; border-radius: 5px; border: 1px solid #39c; text-align: center;" type="text" class="form-control txt_desc" style="text-align:center" value="<?php echo $desc_tmp; ?>" id="<?php echo $id_tmp; ?>">
                    </td>
                    <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($final_items, 2); ?></td>
                    <td class='text-center'>
                        <a href="#" class='btn btn-danger btn-sm waves-effect waves-light' onclick="eliminar('<?php echo $id_tmp ?>')"><i class="fa fa-remove"></i>
                        </a>
                    </td>
                </tr>
            <?php
            }
            $total_factura = $subtotal + $total_impuesto;
            ?>
            <tr>
                <td class='text-right' colspan=5>SUBTOTAL</td>
                <td class='text-right'><b><?php echo $simbolo_moneda . ' ' . number_format($subtotal, 2); ?></b></td>
                <td></td>
            </tr>
            <tr>
                <td class='text-right' colspan=5><?php echo $impuesto; ?>% <?php echo $nom_impuesto; ?> </td>
                <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($total_iva, 2); ?></td>
                <td></td>
            </tr>
            <tr>
                <td style="font-size: 20pt;" class='text-right' colspan=5><b>TOTAL <?php echo $simbolo_moneda; ?></b></td>
                <td style="font-size: 20pt; background: #F5B7B1;" class='text-right'><b><?php echo number_format($total_factura, 2); ?></b></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.txt_desc').off('blur');
        $('.txt_desc').on('blur', function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            // if(keycode == '13'){
            id_tmp = $(this).attr("id");
            desc = $(this).val();
            //Inicia validacion
            if (isNaN(desc)) {
                $.Notification.notify('error', 'bottom center', 'ERROR', 'DIGITAR UN DESCUENTO VALIDO')
                $(this).focus();
                return false;
            }
            //Fin validacion
            $.ajax({
                type: "POST",
                url: "../ajax/editar_desc_venta.php",
                data: "id_tmp=" + id_tmp + "&desc=" + desc,
                success: function(datos) {
                    $("#resultados").load("../ajax/agregar_tmp.php");
                    $(".total").load("../ajax/carga_total.php");
                    $.Notification.notify('success', 'bottom center', 'EXITO!', 'DESCUENTO ACTUALIZADO CORRECTAMENTE')
                }
            });
            // }
        });
        $(".employee_id").on("change", function(event) {
            id_tmp = $(this).attr("id");
            precio = $(this).val();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_precio_venta.php",
                data: "id_tmp=" + id_tmp + "&precio=" + precio,
                success: function(datos) {
                    $("#resultados").load("../ajax/agregar_tmp.php");
                    $(".total").load("../ajax/carga_total.php");
                    $.Notification.notify('success', 'bottom center', 'EXITO!', 'PRECIO ACTUALIZADO CORRECTAMENTE')
                }
            });
        });
        $(".txt_cant").on("blur", function(event) {
            id_tmp = $(this).attr("id");
            cant = $(this).val();
            //Inicia validacion
            if (isNaN(cant)) {
                $.Notification.notify('error', 'bottom center', 'ERROR', 'DIGITAR LA CANTIDAD')
                $(this).focus();
                return false;
            }
            $.ajax({
                type: "POST",
                url: "../ajax/editar_cant_venta.php",
                data: "id_tmp=" + id_tmp + "&cant=" + cant,
                success: function(datos) {
                    $("#resultados").load("../ajax/agregar_tmp.php");
                    $(".total").load("../ajax/carga_total.php");
                    $.Notification.notify('success', 'bottom center', 'EXITO!', 'CANTIDAD ACTUALIZADA CORRECTAMENTE')
                }
            });
        });

    });
</script>