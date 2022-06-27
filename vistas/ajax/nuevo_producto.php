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
    $descripcion      = mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $linea            = intval($_POST['linea']);
    $linea2           = intval($_POST['linea2']);
    $marca            = intval($_POST['marca']);
    $estado           = intval($_POST['estado']);
    $impuesto         = intval($_POST['impuesto']);
    $inv              = intval($_POST['inv']);
    $marca            = intval($_POST['marca']);
    $costo            = floatval($_POST['costo']);
    $costo2           = floatval($_POST['costo2']);
    $utilidad         = floatval($_POST['utilidad']);
    $precio_venta     = floatval($_POST['precio']);
    $precio_mayoreo   = floatval($_POST['preciom']);
    $precio_especial  = floatval($_POST['precioe']);
    $stock            = floatval($_POST['stock']);
    $stock_minimo     = floatval($_POST['minimo']);
    $date_added       = date("Y-m-d H:i:s");
    $users            = intval($_SESSION['id_users']);
    $query_new_insert = '';
// check if user or email address already exists
    $sql                   = "SELECT * FROM productos WHERE codigo_producto ='" . $codigo . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $sql = "UPDATE productos SET codigo_producto='" . $codigo . "',
                                        nombre_producto='" . $nombre . "',
                                        descripcion_producto='" . $descripcion . "',
                                        id_linea_producto='" . $linea . "',
                                        id_linea2_producto='" . $linea2 . "',
                                        id_marca_producto='" . $marca . "',
                                        inv_producto='" . $inv . "',
                                        iva_producto='" . $impuesto . "',
                                        estado_producto='" . $estado . "',
                                        costo_producto='" . $costo . "',
                                        costo2_producto='" . $costo2 . "',
                                        utilidad_producto='" . $utilidad . "',
                                        valor1_producto='" . $precio_venta . "',
                                        valor2_producto='" . $precio_mayoreo . "',
                                        valor3_producto='" . $precio_especial . "',
                                        stock_producto='" . $stock . "',
                                        stock_min_producto='" . $stock_minimo . "'


                                        WHERE codigo_producto='" . $codigo . "'";
        $query_update = mysqli_query($conexion, $sql);
    } else {
        $sql              = "INSERT INTO productos (codigo_producto, nombre_producto, descripcion_producto, id_linea_producto, id_linea2_producto, id_marca_producto, inv_producto, iva_producto, estado_producto, costo_producto, costo2_producto, utilidad_producto, valor1_producto,valor2_producto,valor3_producto, stock_producto,stock_min_producto, date_added,id_imp_producto) 
                                VALUES ('$codigo','$nombre','$descripcion','$linea','$linea2','$marca','$inv','$impuesto','$estado','$costo','$costo2','$utilidad','$precio_venta','$precio_mayoreo','$precio_especial','$stock','$stock_minimo','$date_added','0')";
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