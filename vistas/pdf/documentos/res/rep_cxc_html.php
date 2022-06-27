  <style type="text/css">
      .formato {
       text-align: left;
       vertical-align: top;
       border: 0.3px solid #000;
       border-collapse: collapse;
       padding: 5px;
       background:#2c3e50;
       color:white;
       font-weight:bold;
     }
     .formato2 {
       text-align: left;
       vertical-align: top;
       border: 0.3px solid #000;
       border-collapse: collapse;
       padding: 5px;
     }
     .formato3 {
       text-align: left;
       vertical-align: top;
       border: 0.3px solid #000;
       border-collapse: collapse;
       padding: 5px;
        background:#EAECEE;
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
      font-size:14px;
      text-align: center;
    }
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
    .prueba{
      width: 300px;
      margin: 10px auto;
      padding: 5px;
      font: normal 13px arial, helvetica, sans-serif;
      white-space: normal;
    }
  }
</style>
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='15mm' backright='15mm' style="font-size: 14px; font-family: helvetica">
  <?php include "encabezado_general.php";?>
      <?php
$sql_abono = mysqli_query($conexion, "select * from creditos_abonos, clientes where creditos_abonos.numero_factura='$numero_factura' and creditos_abonos.id_cliente=clientes.id_cliente");
$rw        = mysqli_fetch_array($sql_abono);
?>
  <br>
  <table cellspacing="0" style="width: 100%; text-align: left; font-size: 12px;">
   <tr>
    <td class="formato2" style='text-align:center;' colspan="5">Cliente:<?php echo $rw['nombre_cliente']; ?> </td>
  </tr>
  <tr>
     <th class="formato" style="width:20%;text-align: left;">Factura</th>
     <th class="formato" style="width:20%;text-align: left;">Fecha</th>
     <th class="formato" style="width:20%;text-align: left;">Crédito</th>
     <th class="formato" style="width:20%;text-align: left;">Abonos</th>
     <th class="formato" style="width:20%;text-align: left;">Saldos</th>
   </tr>
   <?php
while ($row = mysqli_fetch_array($query)) {
    ?>
    <tr>
      <td class="formato2" style="width: 20%; text-align: left;"><?php echo $row['numero_factura']; ?></td>
      <td class="formato2" style="width: 20%; text-align: left;"><?php echo date("d/m/Y", strtotime($row['fecha_abono'])); ?></td>
      <td class="formato2" style="width: 20%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($row['monto_abono'], 2); ?></td>
      <td class="formato2" style="width: 20%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($row['abono'], 2); ?></td>
      <td class="formato2" style="width: 20%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($row['saldo_abono'], 2); ?></td>
    </tr>
    <?php }?>
  </table>
  <br><br>
<br><br>
<?php
$orderSql   = "SELECT * FROM creditos_abonos where numero_factura = '$numero_factura'";
$orderQuery = $conexion->query($orderSql);
$countOrder = $orderQuery->num_rows;

$total_abono = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $total_abono += $orderResult['abono'];
    $credito = $orderResult['monto_abono'];
    $saldo   = $orderResult['saldo_abono'];
}
?>
<table cellspacing="0" style="width: 100%; text-align: left; font-size: 12px;">
   <tr>
    <td class="formato2" style='text-align:center;' colspan="3">Detalle del Crédito</td>
  </tr>
  <tr>
    <th class="formato3" style="width:35%;text-align: left;">Crédito</th>
    <th class="formato3" style="width:35%;text-align: left;">Total Abonado</th>
    <th class="formato3" style="width:30%;text-align: left;">Saldo</th>
  </tr>
  <tr>
    <td class="formato2" style="width: 35%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($credito, 2); ?></td>
    <td class="formato2" style="width: 35%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total_abono, 2); ?></td>
    <td class="formato2" style="width: 30%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($saldo, 2); ?></td>
  </tr>
</table>
<br><br>
<br><br>
  <page_footer>
  <table style="width: 100%; border: solid 0px black;">
    <tr>
      <td style="text-align: left;    width: 50%"></td>
      <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
    </tr>
  </table>
  </page_footer>
</page>