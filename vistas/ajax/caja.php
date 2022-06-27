<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
$users        = intval($_SESSION['id_users']);
$fecha_actual = date('Y-m-d');

$orderSql   = "SELECT * FROM caja where users_caja = '$users' and fecha_caja = '$fecha_actual'";
$orderQuery = $conexion->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $totalRevenue += $orderResult['apertura_caja'];
}

echo '' . $id_moneda . '' . number_format($totalRevenue, 2) . '';
