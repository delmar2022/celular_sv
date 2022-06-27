<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$comp_id = get_row('perfil', 'comp_id', 'id_perfil', 1);
?>

			<select id = "id_comp" class = "form-control" name = "id_comp" required autocomplete="off" onchange="getval(this);">
				<?php
$sql   = "select * from  comprobantes order by nombre_comp ";
$query = mysqli_query($conexion, $sql);
while ($rrw = mysqli_fetch_array($query)) {
    $id_comp = $rrw['id_comp'];
    $nombre  = $rrw['nombre_comp'];
    if ($comp_id == $id_comp) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    ?>
					<option value="<?php echo $id_comp; ?>" <?php echo $selected; ?>><?php echo ($nombre); ?></option>
					<?php
}
?>
			</select>
