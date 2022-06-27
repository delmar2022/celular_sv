<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_caja'])) {
    $errors[] = "ID vacío";
} else if (!empty($_POST['id_caja'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $fecha      = mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
    $hora       = mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES)));
    $efectivo   = floatval($_POST['efectivo']);
    $cheque     = floatval($_POST['cheque']);
    $trans      = floatval($_POST['trans']);
    $diferencia = floatval($_POST['diferencia']);
    $compras    = floatval($_POST['compras']);
    $subtotal   = floatval($_POST['subtotal']);
    $total      = floatval($_POST['total']);
    $users      = intval($_SESSION['id_users']);
    $id_caja    = intval($_POST['id_caja']);

    // write new user's data into database

    $sql = "UPDATE detalle_caja SET  ing_efectivo='" . $efectivo . "',
    ing_cheque='" . $cheque . "',
    ing_transf='" . $trans . "',
    egresos='" . $compras . "',
    h_cierre='" . $hora . "',
    total_caja='" . $total . "',
    estado_caja='2'
    WHERE caja_id='" . $id_caja . "'";
    $query_update = mysqli_query($conexion, $sql);

    if ($query_update) {
        echo "<script>
        $('#modalSalir').modal('show');
        </script>";
        //$messages[] = "Cierre de caja Exitoso.";
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
<!-- Modal -->
<form id="eliminarDatos">
    <div class="modal fade" id="modalSalir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="id_egreso" name="id_egreso">
                <h3 class="text-center text-muted">Estas seguro?</h3>
                <p class="lead text-muted text-center" style="display: block;margin:9px">CIERRE DE CAJA EXITOSO, SU SECCION A CADUCADO</p>
                <div class="modal-footer">
                    <a type="button" href="../../login.php?logout" class="btn btn-danger btn-block btn-lg waves-effect waves-light"><span class="fa fa-exit"></span> Aceptar</a>
                </div>
            </div>
        </div>
    </div>
</form>