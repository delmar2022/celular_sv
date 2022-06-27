<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_factura'])) {
    $errors[] = "ID DE FACTURA VACÍO";
} else if (
    !empty($_POST['id_factura'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_factura = intval($_POST['id_factura']);
    $condicion  = intval($_POST['condicion']);
    $resibido   = floatval($_POST['resibido']);
    $monto      = floatval($_POST['monto']);
    //$cambio     = $resibido - $monto;
    if ($resibido == 0) {
        $money = 0;
    } else {
        $money = $resibido;
    }
    /*if ($resibido < $monto) {
    echo "<script>
    $.Notification.notify('error','bottom center','ERROR', 'EL DINERO RESIBIDO DEBE SER IGUAL O MAYOR QUE EL TOTAL')
    $(#resibido).focus();
    })</script>";
    exit;
    }*/

    $sql = "UPDATE facturas_ventasx SET  estado_factura='" . $condicion . "',
                                dinero_resibido_fac='" . $money . "'
                                WHERE id_factura='" . $id_factura . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {

        $messages[] = "Venta Procesada con Exito con Exito.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
    <?php
}
if (isset($messages)) {

    ?>
    <div class="alert alert-success" role="alert">
        <strong>¡Bien hecho!</strong>
        <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
    </div>
    <?php
}

?>
