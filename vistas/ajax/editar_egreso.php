<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $fecha    = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha2"], ENT_QUOTES)));
    $hora     = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora2"], ENT_QUOTES)));
    $importe  = floatval($_POST['importe2']);
    $concepto = mysqli_real_escape_string($conexion, (strip_tags($_POST["concepto2"], ENT_QUOTES)));
    $tipo     = intval($_POST['tipo2']);
    $obs      = mysqli_real_escape_string($conexion, (strip_tags($_POST["obs2"], ENT_QUOTES)));
    $id_caja  = intval($_POST['mod_id']);

    $sql = "UPDATE caja_chica SET  referencia_caja='" . $concepto . "',
                                    fecha_caja='" . $fecha . "',
                                    hora_caja='" . $hora . "',
                                    monto_caja='" . $importe . "',
                                    descripcion_caja='" . $obs . "',
                                    tipo_caja='" . $tipo . "'
                                    WHERE id_caja='" . $id_caja . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Egreso ha sido actualizada con Exito.";
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