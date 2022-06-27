<?php
if ($conexion) {
    /*Datos de la empresa*/
    $sql           = mysqli_query($conexion, "SELECT * FROM perfil");
    $rw            = mysqli_fetch_array($sql);
    $moneda        = $rw["moneda"];
    $bussines_name = $rw["nombre_empresa"];
    $giro          = $rw["giro_empresa"];
    $address       = $rw["direccion"];
    $city          = $rw["ciudad"];
    $state         = $rw["estado"];
    $postal_code   = $rw["codigo_postal"];
    $phone         = $rw["telefono"];
    $email         = $rw["email"];
    $logo_url      = $rw["logo_url"];
    $fiscal        = $rw["fiscal_empresa"];

/*Fin datos empresa*/
    ?>
    <table cellspacing="0" style="width: 100%;"  border="0">
        <tr>
            <td style="width: 25%; color: #444444;text-align: center;">
                <img style="width: 100%; width: 100px; height: 100px" src="./<?php echo $logo_url; ?>"><br>
            </td>
            <td style="width: 45%; color: #000000;font-size:10px;text-align:center">
                <span style="color: #000000;font-size:16px;font-weight:bold"><?php echo $bussines_name; ?></span><br>
                <span style="color: #000000;font-size:12px;font-weight:bold"><?php echo $giro; ?></span><br>
                <span style="color: #000000;font-size:12px;font-weight:bold">RUC: <?php echo $fiscal; ?> 1331 DV. 28</span>
                <br><?php echo $address . ' ' . $city . '.' . $state; ?><br>
                <span style="color: #000000;font-size:16px;font-weight:bold">Teléfono: <?php echo $phone; ?></span>
            </td>
            <td style="width: 30%;text-align:center; color:#ff0000">
            <span style="color: #000000;font-size:10px;font-weight:bold">No. FACTURA </span>
            <span style="color: #ff0000;font-size:10px;font-weight:bold"><?php echo $numero_factura; ?></span>
            </td>

        </tr>
    </table>
    <?php }?>