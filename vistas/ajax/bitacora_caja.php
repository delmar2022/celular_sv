<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../permisos.php";
//Archivo de funciones PHP
require_once "../funciones.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Categorias";
permisos($modulo, $cadena_permisos);
$user_id = $_SESSION['id_users'];
$action  = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $daterange   = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    $employee_id = intval($_REQUEST['employee_id']);
    $tables      = "detalle_caja,  users";
    $campos      = "*";
    $sWhere      = "users.id_users=detalle_caja.empleado_id";
    if ($employee_id > 0) {
        $sWhere .= " and detalle_caja.empleado_id = '" . $employee_id . "' ";
    }
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and detalle_caja.fecha between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " order by detalle_caja.caja_id";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 100; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
    if ($row = mysqli_fetch_array($count_query)) {$numrows = $row['numrows'];} else {echo mysqli_error($conexion);}
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../detalle_caja.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>CAJA</th>
                    <th>FECHA</th>
                    <th>HORA AP</th>
                    <th>S.INICIAL</th>
                    <th>ING EFECTIVO</th>
                    <th>ING CHEQUE</th>
                    <th>ING TRANSF</th>
                    <th>EGRESOS</th>
                    <th>H.CIERRE</th>
                    <th>TOTAL</th>
                    <th>ACCIONES</th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $caja_id        = $row['caja_id'];
            $num_caja       = $row['num_caja'];
            $fecha          = $row['fecha'];
            $hora_ap        = $row['hora_ap'];
            $s_inicial      = $row['s_inicial'];
            $ing_efectivo   = $row['ing_efectivo'];
            $ing_cheque     = $row['ing_cheque'];
            $ing_transf     = $row['ing_transf'];
            $egresos        = $row['egresos'];
            $h_cierre       = $row['h_cierre'];
            $total_caja     = $row['total_caja'];
            $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
            ?>

    <tr>
        <td><span class="badge badge-purple"><?php echo $caja_id; ?></span></td>
        <td><?php echo $fecha; ?></td>
        <td><?php echo $hora_ap; ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($s_inicial, 2); ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($ing_efectivo, 2); ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($ing_cheque, 2); ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($ing_transf, 2); ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($egresos, 2); ?></td>
        <td><?php echo $h_cierre; ?></td>
        <td><?php echo $simbolo_moneda . '' . number_format($total_caja, 2); ?></td>

        <td >
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                <div class="dropdown-menu dropdown-menu-right">
                   <?php if ($permisos_editar == 1) {?>
                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cerrarCaja"><i class='fa fa-edit'></i> Cierre de Caja</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#corteCaja"><i class='fa fa-edit'></i> Corte de Caja</a>
                   <?php }
            ?>


               </div>
           </div>

       </td>

   </tr>
   <?php
}
        ?>
<tr>
    <td colspan="12">
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
      <strong>Aviso!</strong> No hay Registro de Movimiento de caja
  </div>
  <?php
}
// fin else
}
?>