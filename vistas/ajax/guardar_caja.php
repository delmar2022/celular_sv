<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['valor'])) {
    $errors[] = "Valor vacío";
} else if (!empty($_POST['valor'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $fecha      = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
    $hora       = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES)));
    $valor      = floatval($_POST['valor']);
    $date_added = date("Y-m-d");
    $users      = intval($_SESSION['id_users']);
    // check if user or email address already exists
    $sql                   = "SELECT * FROM caja WHERE fecha_caja ='" . $date_added . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $errors[] = "La caja ya ha sido activada.";
    } else {
        // write new user's data into database
        $sql2 = "INSERT INTO detalle_caja (fecha, hora_ap, s_inicial, empleado_id, estado_caja)
    VALUES ('$fecha','$hora','$valor', '$users', 1)";
        $new_insert = mysqli_query($conexion, $sql2);

        if ($query_new_insert) {
            $messages[] = "Caja ha sido aperturada con Exito.";
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