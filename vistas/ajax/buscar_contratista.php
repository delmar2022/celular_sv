<?php

/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
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
//Finaliza Control de Permisos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nom_contra'); //Columnas de busqueda
    $sTable   = "contratistas";
    $sWhere   = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by nom_contra";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/agendab.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tel1</th>
                    <th>Tel2</th>
                    <th>Empresa</th>
                    <th>comprobante Fiscal</th>
                    <th>Banco</th>
                    <th>No. Cuenta</th>
                    <th>Especialidad</th>
                    <th>Estado</th>
                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id_contra      = $row['id_contra'];
            $nom_contra     = $row['nom_contra'];
            $tel1_contra    = $row['tel1_contra'];
            $tel2_contra    = $row['tel2_contra'];
            $empresa_contra = $row['empresa_contra'];
            $fiscal_contra  = $row['fiscal_contra'];
            $banco_contra   = $row['banco_contra'];
            $cuenta_contra  = $row['cuenta_contra'];
            $esp_contra     = $row['esp_contra'];
            $estado_contra  = $row['estado_contra'];
            $date_added     = date('d/m/Y', strtotime($row['date_addedc']));
            if ($estado_contra == 1) {
                $estado = "<span class='badge badge-success'>Activo</span>";
            } else {
                $estado = "<span class='badge badge-danger'>Inactivo</span>";
            }
            if ($fiscal_contra == 1) {
                $comprobante = "SI";
            } else {
                $comprobante = "NO";
            }

            ?>

                    <input type="hidden" value="<?php echo $nom_contra; ?>" id="nom_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $tel1_contra; ?>" id="tel1_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $tel2_contra; ?>" id="tel2_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $empresa_contra; ?>" id="empresa_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $fiscal_contra; ?>" id="fiscal_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $banco_contra; ?>" id="banco_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $cuenta_contra; ?>" id="cuenta_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $esp_contra; ?>" id="esp_contra<?php echo $id_contra; ?>">
                    <input type="hidden" value="<?php echo $estado_contra; ?>" id="estado_contra<?php echo $id_contra; ?>">




                    <tr>
                        <td><span class="badge badge-purple"><?php echo $id_contra; ?></span></td>
                        <td><?php echo $nom_contra; ?></td>
                        <td ><?php echo $tel1_contra; ?></td>
                        <td><?php echo $tel2_contra; ?></td>
                        <td><?php echo $empresa_contra; ?></td>
                        <td><?php echo $comprobante; ?></td>
                        <td><?php echo $banco_contra; ?></td>
                        <td><?php echo $cuenta_contra; ?></td>
                        <td><?php echo $esp_contra; ?></td>
                        <td><?php echo $estado; ?></td>

                        <td >
                            <div class="btn-group dropdown pull-right">
                                <button type="button" class="btn btn-warning btn-rounded btn-sm waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                 <?php if ($permisos_editar == 1) {?>
                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarContra" onclick="obtener_datos('<?php echo $id_contra; ?>');"><i class='fa fa-edit'></i> Editar</a>
                                 <?php }
            if ($permisos_eliminar == 1) {?>
                                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id_contra; ?>"><i class='fa fa-trash'></i> Borrar</a>
                                 <?php }?>


                             </div>
                         </div>

                     </td>

                 </tr>
                 <?php
}
        ?>
             <tr>
                <td colspan="11">
                    <span class="pull-right">
                        <?php
echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span>
                    </td>
                </tr>
            </table>
        </div>
        <?php
}
//Este else Fue agregado de Prueba de prodria Quitar
    else {
        ?>
        <div class="alert alert-warning alert-dismissible" role="alert" align="center">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Aviso!</strong> No hay Registro de Contratistas
      </div>
      <?php
}
// fin else
}
?>