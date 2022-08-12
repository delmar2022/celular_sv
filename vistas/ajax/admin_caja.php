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
  $tables      = "caja_chica,  users";
  $campos      = "*";
  $sWhere      = "users.id_users=caja_chica.users_caja";
  if ($employee_id > 0) {
    $sWhere .= " and caja_chica.tipo_caja = '" . $employee_id . "' ";
  }
  if (!empty($daterange)) {
    list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
    list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
    $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
    list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
    $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

    $sWhere .= " and caja_chica.fecha_caja between '$fecha_inicial' and '$fecha_final' ";
  }
  $sWhere .= " order by caja_chica.id_caja";

  include 'pagination.php'; //include pagination file
  //pagination variables
  $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
  $per_page  = 100; //how much records you want to show
  $adjacents = 4; //gap between pages after number of adjacents
  $offset    = ($page - 1) * $per_page;
  //Count the total number of row in your table*/
  $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
  if ($row = mysqli_fetch_array($count_query)) {
    $numrows = $row['numrows'];
  } else {
    echo mysqli_error($conexion);
  }
  $total_pages = ceil($numrows / $per_page);
  $reload      = '../detalle_caja.php';
  //main query to fetch the data
  $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
  //loop through fetched data

  if ($numrows > 0) {

?>
    <div class="table-responsive">
      <table class="table table-sm table-striped">
        <tr class="info">
          <th>ID CAJA</th>
          <th>FECHA</th>
          <th>HORA</th>
          <th>CANTIDAD</th>
          <th>CONCEPTO</th>
          <th>COMPROBANTE</th>
          <th>ACCIONES</th>

        </tr>
        <?php
        $total_gen = 0;
        while ($row = mysqli_fetch_array($query)) {
          $id_caja          = $row['id_caja'];
          $referencia_caja  = $row['referencia_caja'];
          $fecha_caja       = $row['fecha_caja'];
          $hora_caja        = $row['hora_caja'];
          $monto_caja       = $row['monto_caja'];
          $descripcion_caja = $row['descripcion_caja'];
          $tipo_caja        = $row['tipo_caja'];
          $simbolo_moneda   = get_row('perfil', 'moneda', 'id_perfil', 1);
          $total_gen = $total_gen + $monto_caja;
          if ($tipo_caja == 1) {
            $tipo = "EGRESO";
          } else {
            $tipo = "INGRESO";
          }

        ?>


          <input type="hidden" value="<?php echo $referencia_caja; ?>" id="referencia_caja<?php echo $id_caja; ?>">
          <input type="hidden" value="<?php echo $fecha_caja; ?>" id="fecha_caja<?php echo $id_caja; ?>">
          <input type="hidden" value="<?php echo $hora_caja; ?>" id="hora_caja<?php echo $id_caja; ?>">
          <input type="hidden" value="<?php echo $monto_caja; ?>" id="monto_caja<?php echo $id_caja; ?>">
          <input type="hidden" value="<?php echo $descripcion_caja; ?>" id="descripcion_caja<?php echo $id_caja; ?>">
          <input type="hidden" value="<?php echo $tipo_caja; ?>" id="tipo_caja<?php echo $id_caja; ?>">
          <tr>
            <td><span class="badge badge-purple"><?php echo $id_caja; ?></span></td>
            <td><?php echo $fecha_caja; ?></td>
            <td><?php echo $hora_caja; ?></td>
            <td><?php echo $simbolo_moneda . '' . number_format($monto_caja, 2); ?></td>
            <td><?php echo $referencia_caja; ?></td>
            <td><?php echo $tipo; ?></td>
            <td>
              <div class="btn-group dropdown">
                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <?php if ($permisos_editar == 1) { ?>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarEgreso" onclick="obtener_datos('<?php echo $id_caja; ?>');"><i class='fa fa-edit'></i> Editar</a>
                  <?php }
                  if ($permisos_eliminar == 1) { ?>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id_caja; ?>"><i class='fa fa-trash'></i> Borrar</a>
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
          <td colspan="7">
            <span class="pull-right">
              <?php
              echo paginate($reload, $page, $total_pages, $adjacents);
              ?></span>
          </td>
        </tr>
      </table>
    </div>
    <div class="alert alert-info alert-dismissible" role="alert" align="center">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>
        <h3> TOTAL: <?php echo $simbolo_moneda . ' ' . number_format($total_gen, 2) ?> </h3>
      </strong>
    </div>
  <?php
  }
  //Este else Fue agregado de Prueba de prodria Quitar
  else {
  ?>
    <div class="alert alert-warning alert-dismissible" role="alert" align="center">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Aviso!</strong> No hay Registro de Movimiento de Egresos
    </div>
<?php
  }
  // fin else
}
?>