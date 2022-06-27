<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$session_id     = session_id();
$comp_id        = get_row('perfil', 'comp_id', 'id_perfil', 1);
$sumador_total  = 0;
$t              = 0;
$subtotal       = 0;
$total_iva      = 0;
$total_impuesto = 0;
$total_factura  = 0;
$sql            = mysqli_query($conexion, "select * from productos, tmp_ventas where productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
while ($row = mysqli_fetch_array($sql)) {
    $cantidad       = $row['cantidad_tmp'];
    $desc_tmp       = $row['desc_tmp'];
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
    $subtotal = number_format($sumador_total, 2, '.', '');
    if ($row['iva_producto'] == 1) {
        $total_iva = iva($precio_venta);
    } else {
        $total_iva = 0;
    }
    $total_impuesto += rebajas($total_iva, $desc_tmp) * $cantidad;
    $total_factura = $subtotal + $total_impuesto;
}
?>
<input type="hidden" class="form-control" autocomplete="off" id="total_ft" required name="total_ft" value="<?php echo number_format($total_factura, 2); ?>">
