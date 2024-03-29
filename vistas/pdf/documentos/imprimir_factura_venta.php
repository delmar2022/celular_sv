<?php
include '../../ajax/is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
?>
<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
    background:#2c3e50;
    padding: 4px 4px 4px;
    color:white;
    font-weight:bold;
    font-size:12px;
}
.silver{
    background:white;
    padding: 3px 4px 3px;
}
.clouds{
    background:#ecf0f1;
    padding: 3px 4px 3px;
}
.border-top{
    border-top: solid 1px #bdc3c7;

}
.border-left{
    border-left: solid 1px #bdc3c7;
}
.border-right{
    border-right: solid 1px #bdc3c7;
}
.border-bottom{
    border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<?php
/* Connect To Database*/
require_once "../../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../../funciones.php";
$users          = intval($_SESSION['id_users']);
$factura_id     = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["id_factura"], ENT_QUOTES)));
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
$sql_factura    = mysqli_query($conexion, "select * from facturas_ventas, clientes where facturas_ventas.id_cliente=clientes.id_cliente and id_factura='" . $factura_id . "'");
$count          = mysqli_num_rows($sql_factura);
if ($count == 1) {
    $rw_factura        = mysqli_fetch_array($sql_factura);
    $id_cliente        = $rw_factura['id_cliente'];
    $nombre_cliente    = $rw_factura['nombre_cliente'];
    $direccion_cliente = $rw_factura['direccion_cliente'];
    $telefono_cliente  = $rw_factura['telefono_cliente'];
    $email_cliente     = $rw_factura['email_cliente'];
    $fiscal_cliente    = $rw_factura['fiscal_cliente'];
    $id_vendedor_db    = $rw_factura['id_vendedor'];
    $fecha_factura     = date("d/m/Y", strtotime($rw_factura['fecha_factura']));
    $condiciones       = $rw_factura['condiciones'];
    $estado_factura    = $rw_factura['estado_factura'];
    $numero_factura    = $rw_factura['numero_factura'];
    $logo              = get_row('perfil', 'logo_url', 'id_perfil', 1);
} else {
    header("location: new_venta.php");
    exit;
}
?>

<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 8pt; font-family: arial" footer='page'>
    <?php include "encabezado_factura.php";?>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURA:</td>
        </tr>
        <tr>
           <td style="width:50%;" >
            <?php
$sql_cliente = mysqli_query($conexion, "select * from clientes where id_cliente='$id_cliente'");
$rw_cliente  = mysqli_fetch_array($sql_cliente);
echo $rw_cliente['nombre_cliente'];
echo "<br>";
echo $rw_cliente['direccion_cliente'];
echo "<br> Teléfono: ";
echo $rw_cliente['telefono_cliente'];
echo "<br> Email: ";
echo $rw_cliente['email_cliente'];
?>

           </td>
        </tr>


    </table>
    <br>
        <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>Vendedor</td>
          <td style="width:25%;" class='midnight-blue'>Fecha</td>
           <td style="width:40%;" class='midnight-blue'>Forma de Pago</td>
        </tr>
        <tr>
           <td style="width:35%;">
            <?php
$sql_user = mysqli_query($conexion, "select * from users where id_users='$id_vendedor_db'");
$rw_user  = mysqli_fetch_array($sql_user);
echo $rw_user['nombre_users'] . " " . $rw_user['apellido_users'];
?>
           </td>
          <td style="width:25%;"><?php echo date("d/m/Y", strtotime($fecha_factura)); ?></td>
           <td style="width:40%;" >
                <?php
if ($condiciones == 1) {echo "Efectivo";} elseif ($condiciones == 2) {echo "Cheque";} elseif ($condiciones == 3) {echo "Transferencia bancaria";} elseif ($condiciones == 4) {echo "Crédito";}
?>
           </td>
        </tr>



    </table>
    <br>
    
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>Cant.</th>
            <th style="width: 50%" class='midnight-blue'>Descripción</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>Precio Unit.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>Total</th>

        </tr>
        <?php
$nums          = 1;
$impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
$nom_impuesto   = get_row('perfil', 'nom_impuesto', 'id_perfil', 1);
$sumador_total = 0;
$sum_total     = 0;
$t_iva         = 0;
$sql           = mysqli_query($conexion, "select * from productos, detalle_fact_ventas, facturas_ventas where productos.id_producto=detalle_fact_ventas.id_producto and detalle_fact_ventas.numero_factura=facturas_ventas.numero_factura and facturas_ventas.id_factura='" . $factura_id . "'");

while ($row = mysqli_fetch_array($sql)) {
    $id_producto     = $row["id_producto"];
    $codigo_producto = $row['codigo_producto'];
    $cantidad        = $row['cantidad'];
    $desc_tmp        = $row['desc_venta'];
    $nombre_producto = $row['nombre_producto'];
// control del impuesto por productos.
    if ($row['iva_producto'] == 0) {
        $p_venta   = $row['precio_venta'];
        $p_venta_f = number_format($p_venta, 2); //Formateo variables
        $p_venta_r = str_replace(",", "", $p_venta_f); //Reemplazo las comas
        $p_total   = $p_venta_r * $cantidad;
        $f_items   = rebajas($p_total, $desc_tmp); //Aplicando el descuento
        /*--------------------------------------------------------------------------------*/
        $p_total_f = number_format($f_items, 2); //Precio total formateado
        $p_total_r = str_replace(",", "", $p_total_f); //Reemplazo las comas

        $sum_total += $p_total_r; //Sumador
        $t_iva = ($sum_total * $impuesto) / 100;
        $t_iva = number_format($t_iva, 2, '.', '');
    }
    //end impuesto
    $precio_venta   = $row['precio_venta'];
    $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
    $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total   = $precio_venta_r * $cantidad;
    $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
    /*--------------------------------------------------------------------------------*/
    $precio_total_f = number_format($final_items, 2); //Precio total formateado
    $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    $sumador_total += $precio_total_r; //Sumador
    if ($nums % 2 == 0) {
        $clase = "clouds";
    } else {
        $clase = "silver";
    }
    ?>
    <tr>
            <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 60%; text-align: left"><?php echo $nombre_producto; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f; ?></td>
            <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $precio_total_f; ?></td>

        </tr>
    <?php

    $nums++;
}
$subtotal      = number_format($sumador_total, 2, '.', '');
$total_iva     = ($subtotal * $impuesto) / 100;
$total_impuesto     = number_format($total_iva, 2, '.', '') - number_format($t_iva, 2, '.', '');
//$total_factura = $subtotal + $total_iva;
$total_factura = $subtotal + $total_impuesto;
?>

<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL <?php echo $simbolo_moneda; ?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;"><?php echo $impuesto; ?>% <?php echo $nom_impuesto; ?></td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_impuesto, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $simbolo_moneda; ?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura, 2); ?></td>
        </tr>
</table>
</page>
