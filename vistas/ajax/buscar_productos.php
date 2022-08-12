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
//Archivo de funciones PHP
include "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q            = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
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


    $sWhere .= " order by codigo_producto asc";

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
    $reload      = '../html/productos.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr class="info">
                    <th>ID</th>
                    <th></th>
                    <th>CODIGO</th>
                    <th>NOMBRE PRODUCTO</th>
                    <th>MARCA</th>
                    <th>MODELO</th>
                    <th>COLOR</th>
                    <th>IMEI</th>
                    <th class='text-center'>EXIST.</th>
                    <th class='text-left'>COSTO</th>
                    <th class='text-left'>P. VENTA</th>
                    <th>ESTADO</th>
                    <th class='text-right'>ACCIONES</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_producto          = $row['id_producto'];
                    $codigo_producto      = $row['codigo_producto'];
                    $nombre_producto      = $row['nombre_producto'];
                    $marca_producto       = $row['marca_producto'];
                    $modelo_producto      = $row['modelo_producto'];
                    $color_producto       = $row['color_producto'];
                    $emei_producto        = $row['imei_producto'];
                    $estado_producto      = $row['estado_producto'];
                    $costo_producto       = $row['costo_producto'];
                    $utilidad_producto    = $row['utilidad_producto'];
                    $precio_producto      = $row['precio_producto'];
                    $status_producto      = $row['status_producto'];
                    $stock_producto       = $row['stock_producto'];
                    $date_added           = date('d/m/Y', strtotime($row['date_added']));
                    $image_path           = $row['image_path'];
                    if ($estado_producto == 1) {
                        $estado = "<span class='badge badge-success'>Nuevo</span>";
                    } else {
                        $estado = "<span class='badge badge-danger'>Usado</span>";
                    }
                    $marca = get_row('marcas', 'nombre_marca', 'id_marca', $marca_producto);
                    $modelo = get_row('lineas', 'nombre_linea', 'id_linea', $modelo_producto);
                ?>

                    <input type="hidden" value="<?php echo $codigo_producto; ?>" id="codigo_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $nombre_producto; ?>" id="nombre_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $marca_producto; ?>" id="marca_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $modelo_producto; ?>" id="modelo_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $color_producto; ?>" id="color_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $emei_producto; ?>" id="emei_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $estado_producto; ?>" id="estado_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo number_format($costo_producto, 2, '.', ''); ?>" id="costo_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $utilidad_producto; ?>" id="utilidad_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo number_format($precio_producto, 2, '.', ''); ?>" id="precio_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $status_producto; ?>" id="status<?php echo $id_producto; ?>">
                    <tr>
                        <td><span class="badge badge-purple"><?php echo $id_producto; ?></span></td>
                        <td class='text-center'>
                            <?php
                            if ($image_path == null) {
                                echo '<img src="../../img/productos/default.jpg" class="" width="60">';
                            } else {
                                echo '<img src="' . $image_path . '" class="" width="60">';
                            }

                            ?>
                            <!--<img src="<?php echo $image_path; ?>" alt="Product Image" class='rounded-circle' width="60">-->
                        </td>
                        <td><?php echo $codigo_producto; ?></td>
                        <td><?php echo $nombre_producto; ?></td>
                        <td><?php echo $marca; ?></td>
                        <td><?php echo $modelo; ?></td>
                        <td><?php echo $color_producto; ?></td>
                        <td><?php echo $emei_producto; ?></td>
                        <td class='text-center'><?php echo stock($stock_producto); ?></td>
                        <td><span class='pull-left'><?php echo $simbolo_moneda . '' . number_format($costo_producto, 2); ?></span></td>
                        <td><span class='pull-left'><?php echo $simbolo_moneda . '' . number_format($precio_producto, 2); ?></span></td>
                        <td><?php echo $estado; ?></td>
                        <td>

                            <div class="btn-group dropdown pull-right">
                                <button type="button" class="btn btn-warning btn-rounded waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if ($permisos_ver == 1) { ?>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarProducto" onclick="obtener_datos('<?php echo $id_producto; ?>');carga_img('<?php echo $id_producto; ?>');"><i class='fa fa-edit'></i> Editar</a>
                                    <?php }
                                    if ($permisos_editar == 1) { ?>
                                        <a class="dropdown-item" href="historial.php?id=<?php echo $id_producto; ?>"><i class='fa fa-calendar'></i> Ajuste Inventario</a>
                                        <a class="dropdown-item" href="kardex.php?id=<?php echo $id_producto; ?>"><i class='fa fa-calendar'></i> Kardex</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id_producto; ?>"><i class='fa fa-trash'></i> Borrar</a>
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
                    <td colspan=13><span class="pull-right">
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> No hay Registro de Producto
        </div>
<?php
    }
    // fin else
}
?>