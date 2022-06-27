<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$session_id     = session_id();
$comp_id        = get_row('perfil', 'comp_id', 'id_perfil', 1);
$id_factura     = $_SESSION['id_factura'];
$sumador_total  = 0;
$t              = 0;
$subtotal       = 0;
$total_iva      = 0;
$total_impuesto = 0;
$total_factura  = 0;
$sql            = mysqli_query($conexion, "select * from productos, facturas_cot, detalle_fact_cot where facturas_cot.id_factura=detalle_fact_cot.id_factura and  facturas_cot.id_factura='$id_factura' and productos.id_producto=detalle_fact_cot.id_producto");
while ($row = mysqli_fetch_array($sql)) {
    $id_detalle      = $row["id_detalle"];
    $id_producto     = $row["id_producto"];
    $codigo_producto = $row['codigo_producto'];
    $cantidad        = $row['cantidad'];
    $desc_tmp        = $row['desc_venta'];
    $nombre_producto = $row['nombre_producto'];
    $precio_venta    = $row['precio_venta'];
    $precio_venta_f  = number_format($precio_venta, 2); //Formateo variables
    $precio_venta_r  = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total    = $precio_venta_r * $cantidad;
    $final_items     = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
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
