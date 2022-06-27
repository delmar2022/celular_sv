<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (empty($_POST['nombre2'])) {
    $errors[] = "Nombre vacío";
} else if ($_POST['estado2'] == "") {
    $errors[] = "Selecciona el estado del cliente";
} else if (
    !empty($_POST['mod_id']) &&
    !empty($_POST['nombre2']) &&
    $_POST['estado2'] != ""
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre2"], ENT_QUOTES)));
    $tel1        = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel12"], ENT_QUOTES)));
    $tel2        = mysqli_real_escape_string($conexion, (strip_tags($_POST["tel22"], ENT_QUOTES)));
    $empresa     = mysqli_real_escape_string($conexion, (strip_tags($_POST["empresa2"], ENT_QUOTES)));
    $comprobante = intval($_POST['comprobante2']);
    $banco       = mysqli_real_escape_string($conexion, (strip_tags($_POST["banco2"], ENT_QUOTES)));
    $cuenta      = mysqli_real_escape_string($conexion, (strip_tags($_POST["cuenta2"], ENT_QUOTES)));
    $estado      = intval($_POST['estado2']);
    $esp         = mysqli_real_escape_string($conexion, (strip_tags($_POST["esp2"], ENT_QUOTES)));

    $id_contra = intval($_POST['mod_id']);
    $sql       = "UPDATE contratistas SET nom_contra='" . $nombre . "',
                                        tel1_contra='" . $tel1 . "',
                                        tel2_contra='" . $tel2 . "',
                                        empresa_contra='" . $empresa . "',
                                        fiscal_contra='" . $comprobante . "',
                                        banco_contra='" . $banco . "',
                                        cuenta_contra='" . $cuenta . "',
                                        esp_contra='" . $esp . "',
                                        estado_contra='" . $estado . "'
                                        WHERE id_contra='" . $id_contra . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Contratista ha sido actualizado con Exito.";
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