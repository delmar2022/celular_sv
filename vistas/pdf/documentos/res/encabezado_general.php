<?php
if ($conexion) {
    /*Datos de la empresa*/
    $sql           = mysqli_query($conexion, "SELECT * FROM perfil");
    $rw            = mysqli_fetch_array($sql);
    $moneda        = $rw["moneda"];
    $bussines_name = $rw["nombre_empresa"];
    $address       = $rw["direccion"];
    $city          = $rw["ciudad"];
    $state         = $rw["estado"];
    $postal_code   = $rw["codigo_postal"];
    $phone         = $rw["telefono"];
    $email         = $rw["email"];
    $logo_url      = $rw["logo_url"];

/*Fin datos empresa*/
    ?>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 25%;">
                <img style="width: 100%;" src="../<?php echo $logo_url; ?>" alt="Logo"><br>
            </td>
            <td style="width: 50%;font-size:14px; text-align:center">
                <span style="font-size:20px;"><b><?php echo $bussines_name; ?></b></span>
                <br><?php echo $address . ", " . $city . " " . $state; ?><br>
                Teléfono: <?php echo $phone; ?><br>
                Email: <?php echo $email; ?>
            </td>
            <td style="width: 25%;text-align:right">
                <?php echo date('d/m/Y'); ?>
            </td>
        </tr>
    </table>
    <?php }?>