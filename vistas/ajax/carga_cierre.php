<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$user_id = $_SESSION['id_users'];
//Archivo de funciones PHP
require_once "../funciones.php";
$id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
$fecha_actual = date('Y-m-d');
$hora_actual  = date('H:i');
//---------------------------------------------------------------------------------------
$orderSql   = "SELECT * FROM facturas_ventas WHERE DATE(fecha_factura)='$fecha_actual' and id_users_factura='$user_id' and condiciones=1";
$orderQuery = $conexion->query($orderSql);
$totalVenta = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $totalVenta += $orderResult['monto_factura'];
}
//---------------------------------------------------------------------------------------
$orderSql    = "SELECT * FROM facturas_compras WHERE DATE(fecha_factura)='$fecha_actual' and id_users_factura='$user_id' and condiciones=1";
$orderQuery  = $conexion->query($orderSql);
$totalCompra = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $totalCompra += $orderResult['monto_factura'];
}
// -------------------------------------------------------------------------------------- -
$caja    = mysqli_query($conexion, "select * from detalle_caja where empleado_id='$user_id' and fecha ='$fecha_actual'");
$rw      = mysqli_fetch_array($caja);
$id_caja = $rw['caja_id'];
?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="fecha" class="control-label">FECHA:</label>
			<input type="date" class="form-control UpperCase" id="fecha" name="fecha"  autocomplete="off" value="<?php echo $fecha_actual; ?>" required>
			<input id="id_caja" name="id_caja" value="<?php echo $id_caja; ?>" type='hidden'>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="hora" class="control-label">HORA:</label>
			<input type="time" class="form-control UpperCase" id="hora" name="hora"  autocomplete="off" value="<?php echo $hora_actual; ?>" required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="efectivo" class="control-label">EFECTIVO:</label>
			<input type="text" class="form-control UpperCase" id="efectivo" name="efectivo"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="cheque" class="control-label">CHEQUE:</label>
			<input type="text" class="form-control UpperCase" id="cheque" name="cheque"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="0.00" required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="trans" class="control-label">TRANSFERENCIA:</label>
			<input type="text" class="form-control UpperCase" id="trans" name="trans"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="0.00" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="diferencia" class="control-label">DIFERENCIA:</label>
			<input type="text" class="form-control UpperCase" id="diferencia" name="diferencia"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="0.00" required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="compras" class="control-label">COMPRAS:</label>
			<input type="text" class="form-control UpperCase" id="compras" name="compras"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="<?php echo $id_moneda . ' ' . number_format($totalCompra, 2); ?>" readonly>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="subtotal" class="control-label">SUBTOTA EFECTIVO:</label>
			<input type="text" class="form-control UpperCase" id="subtotal" name="subtotal"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales"  required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="total" class="control-label">TOTAL:</label>
			<input type="text" class="form-control UpperCase" id="total" name="total"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="<?php echo $id_moneda . ' ' . number_format($totalVenta, 2); ?>" readonly>
		</div>
	</div>

</div>
