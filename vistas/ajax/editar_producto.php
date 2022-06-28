<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (!empty($_POST['mod_id'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $codigo           = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo2"], ENT_QUOTES)));
    $nombre           = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre2"], ENT_QUOTES)));
    $marca            = intval($_POST['marca2']);
    $modelo            = intval($_POST['modelo2']);
    $color            = mysqli_real_escape_string($conexion, (strip_tags($_POST["color2"], ENT_QUOTES)));
    $imei            = intval($_POST['emei2']);
    $estado           = intval($_POST['estado2']);
    $costo            = floatval($_POST['costo2']);
    $utilidad         = floatval($_POST['utilidad2']);
    $precio     = floatval($_POST['precio2']);
    $status           = intval($_POST['status2']);
    $id_producto     = $_POST['mod_id'];
    $sql             = "UPDATE productos SET codigo_producto='" . $codigo . "',
                                            nombre_producto='" . $nombre . "',
                                            marca_producto='" . $marca . "',
                                            modelo_producto='" . $modelo . "',
                                            color_producto='" . $color . "',
                                            imei_producto='" . $imei . "',
                                            estado_producto='" . $estado . "',
                                            costo_producto='" . $costo . "',
                                            utilidad_producto='" . $utilidad . "',
                                            precio_producto='" . $precio . "',
                                            status_producto='" . $status . "'
                                        WHERE id_producto='" . $id_producto . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Producto ha sido actualizado satisfactoriamente.";
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