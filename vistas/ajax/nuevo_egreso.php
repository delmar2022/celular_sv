<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['fecha'])) {
    $errors[] = "Fecha vacía";
} else if (!empty($_POST['fecha'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $fecha      = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
    $hora       = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES)));
    $importe    = floatval($_POST['importe']);
    $concepto   = mysqli_real_escape_string($conexion, (strip_tags($_POST["concepto"], ENT_QUOTES)));
    $tipo       = intval($_POST['tipo']);
    $obs        = mysqli_real_escape_string($conexion, (strip_tags($_POST["obs"], ENT_QUOTES)));
    $date_added = date("Y-m-d H:i:s");
    $users      = intval($_SESSION['id_users']);

    // write new user's data into database
    $sql = "INSERT INTO caja_chica (referencia_caja, fecha_caja, hora_caja, monto_caja, descripcion_caja, tipo_caja, users_caja, date_added_caja)
    VALUES ('$concepto','$fecha','$hora','$importe','$obs','$tipo','$users','$date_added')";
    $query_new_insert = mysqli_query($conexion, $sql);

    if ($query_new_insert) {
        $messages[] = "Egreso ha sido ingresado con Exito.";
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