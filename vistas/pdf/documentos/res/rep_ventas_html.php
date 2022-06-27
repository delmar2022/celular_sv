<style type="text/css">
  .formato {
   text-align: left;
   vertical-align: top;
   border: 0.3px solid #000;
   border-collapse: collapse;
   padding: 1px;
 }
 .tabla{
  width:100%;
  border-radius: 12px 12px 12px 12px;
  -moz-border-radius: 12px 12px 12px 12px;
  -webkit-border-radius: 12px 12px 12px 12px;
  border: 2px solid #000000;
}
.cabeza-blue{
  background:#E6E6E6;
  padding: 4px 4px 4px;
  color:black;
  font-weight:bold;
  font-size:15px;
}
.midnight-blue{
  background:#2c3e50;
  padding: 4px 4px 4px;
  color:white;
  font-weight:bold;
  font-size:14px;
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

}
</style>
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='15mm' backright='15mm' footer='page'>
  <?php include "encabezado_general.php";?><br>
  <table cellpadding='4' cellspacing='0' border='0'>
    <tr>
      <td style="width:100%;" class='midnight-blue' align="center">REPORTE DE VENTAS</td>
    </tr>
  </table><br>
    <?php
$sql1        = mysqli_query($conexion, "select estado_factura from facturas_ventas where estado_factura='" . $estado_factura . "'");
$rw1         = mysqli_fetch_array($sql1);
$estado_fact = $rw1['estado_factura'];
if ($estado_fact == 1) {
    $estado = 'Pagado';
} elseif ($estado_fact == 2) {
    $estado = 'pendiente';
} else {
    $estado = 'Todos';
}
?>
<table cellspacing="0" style="width: 100%; text-align: left; font-size: 12px; border: 0px solid #000000;">
   <tr>
    <td class="formato" style='text-align:center;' colspan="5">ESTADO DE LA FACTURA: <?php echo $estado; ?></td>
  </tr>
  <tr class="cabeza-blue">
    <th class="formato" style="width:15%;text-align: center;">Factura Nº</th>
    <th class="formato" style="width:40%;text-align: center;">Cliente</th>
    <th class="formato" style="width:15%;text-align: center;">Fecha</th>
    <th class="formato" style="width:15%;text-align: center;">Estado</th>
    <th class="formato" style="width:15%;text-align: center;">Total</th>
  </tr>
    <?php
$sumador_total  = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    $numero_factura = $row['numero_factura'];
    $nombre_users   = $row['nombre_users'] . ' ' . $row['apellido_users'];
    $id_cliente     = $row['id_cliente'];
    $estado_factura = $row['estado_factura'];
    $sql            = mysqli_query($conexion, "select nombre_cliente from clientes where id_cliente='" . $id_cliente . "'");
    $rw             = mysqli_fetch_array($sql);
    $nombre_cliente = $rw['nombre_cliente'];
    $date_added     = $row['fecha_factura'];
    $total          = $row['monto_factura'];
    $sumador_total += $total;

    list($date, $hora) = explode(" ", $date_added);
    list($Y, $m, $d)   = explode("-", $date);
    $fecha             = $d . "-" . $m . "-" . $Y;
    if ($estado_factura != 2) {
        $estado = 'Pagado';
    } else { $estado = 'pendiente';}
    ?>
       <tr>
      <td class="formato" style="width: 15%; text-align: center"><?php echo $numero_factura; ?></td>
      <td class="formato" style="width: 40%; text-align: left;"><?php echo $nombre_cliente; ?></td>
      <td class="formato" style="width: 15%; text-align: left;"><?php echo $fecha; ?></td>
      <td class="formato" style="width: 15%; text-align: left;"><?php echo $estado; ?></td>
      <td class="formato" style="width: 15%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total, 2) ?></td>
    </tr>
    <?php
}

?>
  <tr>
    <td style='text-align:right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px' colspan="4">Total:</td>
    <td style='text-align:left;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px'><?php echo $simbolo_moneda . '' . number_format($sumador_total, 2) ?></td>
  </tr>
</table>
</page>