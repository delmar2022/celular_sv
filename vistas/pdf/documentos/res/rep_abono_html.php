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
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' footer='page'>
  <?php include "encabezado_general.php";?><br><br>
  <!--  Generalizada -->
  <?php
$tySql  = "SELECT * FROM creditos_abonos, clientes, users WHERE creditos_abonos.id_cliente = clientes.id_cliente and creditos_abonos.id_users_abono= users.id_users and creditos_abonos.id_abono ='$id_abono'";
$tyData = $conexion->query($tySql);

while ($tyResult = $tyData->fetch_array()) {
    $numero_factura = $tyResult['numero_factura'];
    $abono          = $tyResult['abono'];
    $nombre_users   = $tyResult['nombre_users'] . ' ' . $tyResult['apellido_users'];
    $date_added     = date('d/m/Y', strtotime($tyResult['fecha_abono']));
    $concepto       = $tyResult['concepto_abono'];
    // datos del Cliente
    $nombre    = $tyResult['nombre_cliente'];
    $direccion = $tyResult['direccion_cliente'];
    $telefono  = $tyResult['telefono_cliente'];
    $email     = $tyResult['email_cliente'];
    // calculos
    $impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
}
?>
<br>
<br>
<br>
      <table style="width:50%; font-size: 12pt;  padding: 5px;"> <!-- Lo cambiaremos por CSS -->
    <tr>
      <td style="width:50%;" class='midnight-blue' colspan="3">CLIENTE</td>
    </tr>
    <tr>
    <td style="width: 30%; text-align: left; font-weight: bold;">Nombre:</td>
    <td><?php echo $nombre; ?></td>
  </tr>
  <tr>
    <td style="width: 30%; text-align: left; font-weight: bold;">Direccion:</td>
    <td><?php echo $direccion; ?></td>
  </tr>
  <tr>
    <td style="width: 30%; text-align: left; font-weight: bold;">Telefono:</td>
    <td><?php echo $telefono; ?></td>
  </tr>
  <tr>
    <td style="width: 30%; text-align: left; font-weight: bold;">Email:</td>
    <td><?php echo $email; ?></td>
  </tr>
</table><br>
  <table cellspacing="0" style="width: 100%; text-align: left; font-size: 12px;">
    <tr>
      <th class="formato" style="width:20%;text-align: left;">Factura</th>
      <th class="formato" style="width:40%;text-align: left;">Concepto</th>
      <th class="formato" style="width:25%;text-align: left;">Fecha</th>
      <th class="formato" style="width:15%;text-align: right;">Valor Unit.</th>
    </tr>

    <tr>
      <td class="formato2" style="width: 20%; text-align: left;"><?php echo $numero_factura; ?></td>
      <td class="formato2" style="width: 40%; text-align: left;"><?php echo $concepto; ?></td>
      <td class="formato2" style="width: 25%; text-align: left;"><?php echo $date_added; ?></td>
      <td class="formato2" style="width: 15%; text-align: right;"><?php echo $simbolo_moneda . '' . number_format($abono, 2); ?></td>
    </tr>

    <tr>
      <td colspan="3" style="text-align: right;">SUBTOTAL <?php echo $simbolo_moneda; ?> </td>
      <td class="formato3" style="text-align: right;"> <?php echo number_format($abono, 2); ?></td>
    </tr>

    <tr>
      <td colspan="3"  style="text-align: right;">IVA (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda; ?> </td>
      <td class="formato3" style="text-align: right;">0.0</td>
    </tr>

    <tr>
      <td colspan="3" style="text-align: right;">TOTAL <?php echo $simbolo_moneda; ?> </td>
      <td class="formato3" style="text-align: right;"> <?php echo number_format($abono, 2); ?></td>
    </tr>
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
<br><br>
<div style='width:45%;font-size: 12pt; border-bottom: 1px solid #2c3e50;padding-bottom:10px'>F:</div>
<div style='width:45%;font-size: 12pt; border-bottom: 0px solid #2c3e50;padding-bottom:10px'><?php echo $nombre_users; ?></div>



</page>

