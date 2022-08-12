<?php
/*-------------------------
Autor: Delmar Lopez
Web: www.softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $id_categoria = intval($_REQUEST['categoria']);
    $estado = intval($_REQUEST['estadoo']);
    $sTable = "productos, lineas";
    $sWhere = "";
    $sWhere .= " WHERE productos.modelo_producto=lineas.id_linea";

    if ($_GET['q'] != "") {
        $sWhere .= " and (productos.codigo_producto like '%$q%' or productos.nombre_producto like '%$q%' or productos.color_producto like '%$q%' or lineas.nombre_linea like '%$q%')";
    }
    if ($id_categoria > 0) {
        $sWhere .= " and productos.modelo_producto = '" . $id_categoria . "' ";
    }
    if ($estado > 0) {
        $sWhere .= " and estado_producto = '" . $estado . "' ";
    }
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 5; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../venta/prueba.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <tr class="info">

                    <th>COD.</th>
                    <th class='text-center'>PRODUCTOS</th>
                    <th class='text-center'>MODELO</th>
                    <th class='text-center'>COLOR</th>
                    <th class='text-center'>ESTADO</th>
                    <th class='text-center'>STOCK</th>
                    <th class='text-center'>CANT</th>
                    <th class='text-center'>COSTO</th>
                    <th class='text-center' style="width: 36px;"></th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_producto     = $row['id_producto'];
                    $codigo_producto = $row['codigo_producto'];
                    $nombre_producto = $row['nombre_producto'];
                    $stock_producto  = $row['stock_producto'];
                    $costo_producto  = $row["costo_producto"];
                    $marca_producto       = $row['marca_producto'];
                    $modelo_producto      = $row['modelo_producto'];
                    $estado_producto      = $row['estado_producto'];
                    $color_producto       = $row['color_producto'];
                    $costo_producto  = number_format($costo_producto, 2, '.', '');
                    $image_path      = $row['image_path'];
                    if ($estado_producto == 1) {
                        $estado = "<span class='badge badge-success'>Nuevo</span>";
                    } else {
                        $estado = "<span class='badge badge-danger'>Usado</span>";
                    }
                    $marca = get_row('marcas', 'nombre_marca', 'id_marca', $marca_producto);
                    $modelo = get_row('lineas', 'nombre_linea', 'id_linea', $modelo_producto);
                ?>
                    <tr>
                        <td><?php echo $codigo_producto; ?></td>
                        <td><?php echo $nombre_producto; ?></td>
                        <td><?php echo $modelo; ?></td>
                        <td><?php echo $color_producto; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td class="text-center"><?php echo stock($stock_producto); ?></td>
                        <td class='col-xs-1' width="15%">
                            <div class="pull-right">
                                <input type="text" class="form-control" style="text-align:center" id="cantidad_<?php echo $id_producto; ?>" value="1">
                            </div>
                        </td>
                        <td class='col-xs-2' width="15%">
                            <div class="pull-right">
                                <input type="text" class="form-control" style="text-align:right" id="costo_producto_<?php echo $id_producto; ?>" value="<?php echo $costo_producto; ?>">
                            </div>
                        </td>
                        <td class='text-center'>
                            <a class='btn btn-success' href="#" title="Agregar a Factura" onclick="agregar('<?php echo $id_producto ?>')"><i class="fa fa-plus"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan=9><span class="pull-right">
                            <?php
                            echo paginate($reload, $page, $total_pages, $adjacents);
                            ?></span></td>
                </tr>
            </table>
        </div>
    <?php
    }
    //Este else Fue agregado de Prueba de prodria Quitar
    else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert" align="center">
            <strong>Aviso!</strong> No hay Registro de Producto
        </div>
<?php
    }
    // fin else
}
?>