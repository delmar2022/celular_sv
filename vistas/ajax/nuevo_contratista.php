<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
    $errors[] = "Nombre vacío";
} else if (!empty($_POST['nombre'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $tel1        = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel1"], ENT_QUOTES)));
    $tel2        = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel2"], ENT_QUOTES)));
    $empresa     = mysqli_real_escape_string($conexion, (strip_tags($_POST["empresa"], ENT_QUOTES)));
    $comprobante = intval($_POST['comprobante']);
    $banco       = mysqli_real_escape_string($conexion, (strip_tags($_POST["banco"], ENT_QUOTES)));
    $cuenta      = mysqli_real_escape_string($conexion, (strip_tags($_POST["cuenta"], ENT_QUOTES)));
    $estado      = intval($_POST['estado']);
    $esp         = mysqli_real_escape_string($conexion, (strip_tags($_POST["esp"], ENT_QUOTES)));
    $date_added  = date("Y-m-d H:i:s");
    // check if user or email address already exists
    $sql                   = "SELECT * FROM contratistas WHERE nom_contra ='" . $nombre . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $errors[] = "Lo sentimos , el nombre ya está en uso.";
    } else {
        // write new user's data into database
        $sql              = "INSERT INTO contratistas (nom_contra, tel1_contra, tel2_contra, empresa_contra, fiscal_contra, banco_contra,cuenta_contra, esp_contra, estado_contra, date_addedc) VALUES ('$nombre','$tel1','$tel2','$empresa','$comprobante','$banco','$cuenta','$esp','$estado','$date_added')";
        $query_new_insert = mysqli_query($conexion, $sql);
        if ($query_new_insert) {
            $messages[] = "Contratista ha sido ingresado con Exito.";
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