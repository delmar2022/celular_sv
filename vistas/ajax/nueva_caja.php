<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['fecha'])) {
    $errors[] = "Fecha vacío";
} else if (!empty($_POST['fecha'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $fecha     = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
    $hora      = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES)));
    $s_inicial = mysqli_real_escape_string($conexion, (strip_tags($_POST["s_inicial"], ENT_QUOTES)));
    $users     = intval($_SESSION['id_users']);
    // check if user or email address already exists
    $sql                   = "SELECT * FROM detalle_caja WHERE fecha ='" . $fecha . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $errors[] = "la caja  ya está en uso.";
    } else {
        // write new user's data into database

        $sql = "INSERT INTO detalle_caja (fecha, hora_ap, s_inicial, empleado_id)
    VALUES ('$fecha','$hora','$s_inicial', '$users')";
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
            $messages[] = "Apertura de caja ingresada con Exito.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
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