<?php
/*-----------------------
Autor: Delmar Lopez
http://www.softwys.com
----------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Clientes";
permisos($modulo, $cadena_permisos);
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_marca'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['id_marca'])

) {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_marca = intval($_POST['id_marca']);
    $query    = mysqli_query($conexion, "select * from productos where id_marca_producto='" . $id_marca . "'");
    $count    = mysqli_num_rows($query);
    if ($count == 0) {
        if ($delete1 = mysqli_query($conexion, "DELETE FROM marcas WHERE id_marca='" . $id_marca . "'")) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <strong>Aviso!</strong> Datos eliminados exitosamente.
          </div>
          <?php
} else {
            ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
      </div>
      <?php

        }

    } else {
        ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <strong>Error!</strong> No se pudo eliminar éste Medicamento. Existe Información vinculadas.
  </div>
  <?php
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

?>