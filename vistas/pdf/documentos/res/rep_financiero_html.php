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
      <td style="width:100%;" class='midnight-blue' align="center">REPORTE DE FINANCIERO</td>
    </tr>
  </table><br>
    <?php
$sql1          = mysqli_query($conexion, "select * from lineas where id_linea='" . $categoria . "'");
$rw1           = mysqli_fetch_array($sql1);
$nom_categoria = $rw1['nombre_linea'];
if (empty($nombre_categoria)) {
    $cat = "Todos";
} else {
    $cat = $nombre_categoria;
}

?>

  <table cellspacing="0" style="width: 100%; text-align: left; font-size: 12px; border: 0px solid #000000;">
   <tr>
    <td class="formato" style='text-align:center;' colspan="9">CATEGORIA: <?php echo $cat; ?></td>
  </tr>
  <tr class="cabeza-blue">
      <th class="formato" style="width:10%;text-align: left;">Codigo</th>
      <th class="formato" style="width:25%;text-align: left;">Producto</th>
      <th class="formato" style="width:5%;text-align: center;">Cant.</th>
      <th class="formato" style="width:10%;text-align: left;">Costo</th>
      <th class="formato" style="width:10%;text-align: left;">T. Costo</th>
      <th class="formato" style="width:10%;text-align: left;">P. Vendido</th>
      <th class="formato" style="width:10%;text-align: left;">Desc.</th>
      <th class="formato" style="width:10%;text-align: left;">T. Vendido</th>
      <th class="formato" style="width:10%;text-align: left;">Utilidad</th>
    </tr>
    <?php
$sumador_total  = 0;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
while ($row = mysqli_fetch_array($query)) {
    $id_producto     = $row['id_producto'];
    $codigo_producto = $row['codigo_producto'];
    $nombre_producto = $row['nombre_producto'];
    $costo_producto  = $row['costo_producto'];
    $precio_vendido  = $row['precio_venta'];
    $sql_kardex      = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
    $rww             = mysqli_fetch_array($sql_kardex);
    $costo_saldo     = $rww['costo_saldo'];
    //calculos de totales
    $sql           = mysqli_query($conexion, "select sum(cantidad) as cant, sum(desc_venta) as d, sum(importe_venta) as pv from detalle_fact_ventas, facturas_ventas where facturas_ventas.id_factura=detalle_fact_ventas.id_factura and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' and  detalle_fact_ventas.id_producto='" . $id_producto . "'");
    $rw            = mysqli_fetch_array($sql);
    $cantidad      = $rw['cant'];
    $desc_venta    = $rw['d'];
    $total_costo   = $cantidad * $costo_saldo;
    $total_pv      = $rw['pv'];
    $final_items   = rebajas($total_pv, $desc_venta); //Aplicando el descuento
    $descuento     = $total_pv - $final_items;
    $utilidad      = $final_items - $total_costo;
    $sumador_total = $sumador_total + $utilidad;

    ?>
      <tr>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $codigo_producto; ?></td>
       <td class="formato" style="width: 25%; text-align: left;"><?php echo $nombre_producto; ?></td>
       <td class="formato" style="width: 5%; text-align: center;"><?php echo $cantidad; ?></td>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($costo_producto, 2); ?></td>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total_costo, 2); ?></td>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($precio_vendido, 2); ?></td>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($descuento, 2); ?></td>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($final_items, 2); ?></td>
       <td class="formato" style="width: 10%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($utilidad, 2); ?></td>
     </tr>
     <?php
}

?>
   <tr>
   <td style='text-align:right;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px' colspan="8">Total:</td>
    <td style='text-align:left;border-top:3px solid #2c3e50;padding:4px;padding-top:4px;font-size:14px'><?php echo $simbolo_moneda . '' . number_format($sumador_total, 2) ?></td>
  </tr>
</table>
</page>