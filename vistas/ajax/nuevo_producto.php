<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['codigo'])) {
    $errors[] = "Codigod vacío";
} else if (!empty($_POST['codigo'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    //Archivo de funciones PHP
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $codigo           = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo"], ENT_QUOTES)));
    $nombre           = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $marca            = intval($_POST['marca']);
    $modelo            = intval($_POST['modelo']);
    $color            = mysqli_real_escape_string($conexion, (strip_tags($_POST["color"], ENT_QUOTES)));
    $imei            = intval($_POST['emei']);
    $estado           = intval($_POST['estado']);
    $costo            = floatval($_POST['costo']);
    $utilidad         = floatval($_POST['utilidad']);
    $precio     = floatval($_POST['precio']);
    $status           = intval($_POST['status']);
    $date_added       = date("Y-m-d H:i:s");
    $users            = intval($_SESSION['id_users']);
    $stock = 0;
    $query_new_insert = '';
    // check if user or email address already exists
    $sql                   = "SELECT * FROM productos WHERE codigo_producto ='" . $codigo . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $sql = "UPDATE productos SET codigo_producto='" . $codigo . "',
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
                                        WHERE codigo_producto='" . $codigo . "'";
        $query_update = mysqli_query($conexion, $sql);
    } else {
        $sql              = "INSERT INTO productos (codigo_producto, nombre_producto, marca_producto, modelo_producto, color_producto, imei_producto, estado_producto, costo_producto, utilidad_producto, precio_producto, status_producto, date_added) 
                                VALUES ('$codigo','$nombre','$marca','$modelo','$color','$imei','$estado','$costo','$utilidad','$precio','$status','$date_added')";
        $query_new_insert = mysqli_query($conexion, $sql);
    }
    //Seleccionamos el ultimo compo numero_fatura y aumentamos una
    $sql         = mysqli_query($conexion, "select LAST_INSERT_ID(id_producto) as last from productos order by id_producto desc limit 0,1 ");
    $rw          = mysqli_fetch_array($sql);
    $id_producto = $rw['last'];
    //GURDAMOS LAS ENTRADAS EN EL KARDEX
    $saldo_total    = $stock * $costo;
    $sql_kardex     = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
    $rww            = mysqli_fetch_array($sql_kardex);
    $cant_saldo     = isset($rww['cant_saldo']) + $stock;
    $saldo_full     = isset($rww['total_saldo']) + $saldo_total;
    $costo_promedio = isset($rww['total_saldo']) + $saldo_total / $cant_saldo;
    $tipo           = 5;

    guardar_entradas($date_added, $id_producto, $stock, $costo, $saldo_total, $cant_saldo, $costo_promedio, $saldo_full, $date_added, $users, $tipo);

    if ($query_new_insert or $query_update) {
        $messages[] = "Producto ha sido ingresado satisfactoriamente.";
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