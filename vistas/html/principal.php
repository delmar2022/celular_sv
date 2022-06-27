<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}

/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Inicio";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title  = "Inicio";
$Inicio = 1;
//Archivo de funciones PHP
require_once "../funciones.php";
$usu                   = $_SESSION['id_users'];
$users_users           = get_row('users', 'usuario_users', 'id_users', $usu);
$cargo_users           = get_row('users', 'cargo_users', 'id_users', $usu);
$nombre_users          = get_row('users', 'nombre_users', 'id_users', $usu);
$apellido_users        = get_row('users', 'apellido_users', 'id_users', $usu);
$email_users           = get_row('users', 'email_users', 'id_users', $usu);
$now_date              = date("Y-m-d");
$sql                   = "SELECT * FROM detalle_caja WHERE fecha ='" . $now_date . "' and empleado_id= '" . $usu . "' and estado_caja = 1;";
$query_check_user_name = mysqli_query($conexion, $sql);
$query_check_user      = mysqli_num_rows($query_check_user_name);
//$vista                 = 'modal_vuelto';
if ($query_check_user == true) {
    $vista = 'modal_inactiva';
} else {
    $vista = 'modal_vuelto';
}
?>
<?php require 'includes/header_start.php';?>
<!-- grafico -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="build/css/bootstrap-datetimepicker.min.css">
<script>
  $(document).ready(function () {
    $("#modal_vuelto").modal("show");
  });
</script>
<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper">

  <?php require 'includes/menu.php';?>




  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container">
        <?php if ($permisos_ver == 1) {
    ?>
        <!-- Modal -->
        <div class="modal fade" id="<?php echo $vista ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> Inicio de Caja </h4>
      </div>
      <div class="modal-body" align="center">
      <form class="form-horizontal" method="post" id="guardar_caja" name="guardar_caja">
      <div id="resultados_ajax"></div>
        <div class="alert alert-info" align="center">
        <strong><h4>INICIO DE CAJA DEL DIA</h4></strong>
        </div>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="users" class="control-label">Usuario</label>
              <input type="text" class="form-control" id="users" name="users" readonly="true" value="<?php echo $nombre_users . ' ' . $apellido_users ?>">
            </div>
          </div>
          </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha" class="control-label">FECHA</label>
              <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="hora" class="control-label">HORA</label>
              <input type="time" class="form-control" id="hora" name="hora" value="<?php echo date("H:i"); ?>" required>
            </div>
          </div>
        </div>
          <div class="row">
            <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="valor" class="control-label">Caja Inicial</label>
              <input type="text" class="form-control number-only" id="valor" name="valor" autocomplete="off" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a type="button" href="../../login.php?logout" class="btn btn-primary btn-block btn-lg waves-effect waves-light"><span class="fa fa-exit"></span> Cancelar</a><br>
        <button type="submit" class="btn btn-danger btn-lg btn-block waves-effect waves-light" id="guardar_datos"><span class="fa fa-save"></span> Aceptar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN Modal -->
          <div class="row">

            <div class="col-lg-6 col-xl-3">
            <a href="bitacora_compras.php">
              <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-danger pull-left">
                  <i class="ti-export text-pink"></i>
                </div>
                <div class="text-right">
                  <h5 class="text-dark text-center"><b class="counter text-pink"><?php total_egresos();?></b></h5>
                  <p class="text-muted mb-0">Compras</p>
                </div>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>

          <div class="col-lg-6 col-xl-3">
         <a href="bitacora_ventas.php">
          <div class="widget-bg-color-icon card-box fadeInDown animated">
            <div class="bg-icon bg-icon-primary pull-left">
              <i class=" ti-money text-info"></i>
            </div>
            <div class="text-right">
              <h5 class="text-dark"><b class="counter text-info"><?php total_ingresos();?></b></h5>
              <p class="text-muted mb-0">Ventas</p>
            </div>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>

       <div class="col-lg-6 col-xl-3">
           <a href="cxc.php">
            <div class="widget-bg-color-icon card-box">
              <div class="bg-icon bg-icon-purple pull-left">
                <i class="ti-dashboard text-purple"></i>
              </div>
              <div class="text-right">
                <h5 class="text-dark text-center"><b class="counter text-purple"><?php total_cxc();?></b></h5>
                <p class="text-muted mb-0">Cuentas x Cobrar</p>
              </div>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>

            <div class="col-lg-6 col-xl-3">
             <a href="cxp.php">
              <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-success pull-left">
                  <i class="ti-calendar text-success"></i>
                </div>
                <div class="text-right">
                  <h5 class="text-dark text-center"><b class="counter text-success"><?php total_cxp();?></b></h5>
                  <p class="text-muted mb-0">Cuentas x Pagar</p>
                </div>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>


    </div>
    <!-- end row -->

    <div class="row">


      <div class="col-lg-8">
        <div class="card-box">
          <h5 class="text-dark  header-title m-t-0 m-b-30">Estadisticas</h5>

          <div class="widget-chart text-center">
            <div class='row'>
              <div class='col-md-4'>
                <select class="form-control" id="periodo" onchange="drawVisualization();">
                  <?php
for ($anio = (date("Y")); 2016 <= $anio; $anio--) {
        echo "<option value=" . $anio . ">Período:" . $anio . "</option>";
    }
    ?>
                </select>
              </div>
            </div>
            <div id="chart_div" style="height: 300px;"></div>

          </div>
        </div>

      </div>
      <div class="col-lg-4">
        <div class="portlet">
          <div class="portlet-heading bg-purple">
            <h3 class="portlet-title">
              Ultimas Ventas
            </h3>
            <div class="portlet-widgets">
              <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
              <span class="divider"></span>
              <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
              <span class="divider"></span>
              <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
            </div>
            <div class="clearfix"></div>
          </div>
          <div id="bg-primary" class="panel-collapse collapse show">
            <div class="portlet-body">
              <div class="table-responsive">
                <table class="table table-sm no-margin table-striped">
                  <thead>
                    <tr>
                      <th>No. Factura</th>
                      <th>Fecha</th>
                      <th class="text-center">Monto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
latest_order();
    ?>
                  </tbody>
                </table>
              </div><!-- /.table-responsive -->
              <div class="box-footer clearfix">
                <a href="bitacora_ventas.php" class="btn btn-sm btn-danger btn-flat pull-right">Ver todas las Ventas</a>
              </div><!-- /.box-footer -->
            </div>
          </div>
        </div>
        <div class="card-box widget-user">
           <div class="portlet">
          <div class="portlet-heading bg-success">
            <h3 class="portlet-title">
              Ultimas Compras
            </h3>
            <div class="portlet-widgets">
              <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
              <span class="divider"></span>
              <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
              <span class="divider"></span>
              <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
            </div>
            <div class="clearfix"></div>
          </div>
          <div id="bg-primary" class="panel-collapse collapse show">
            <div class="portlet-body">
              <div class="table-responsive">
                <table class="table table-sm no-margin table-striped">
                  <thead>
                    <tr>
                      <th>No. Factura</th>
                      <th>Fecha</th>
                      <th class="text-center">Monto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
latest_compras();
    ?>
                  </tbody>
                </table>
              </div><!-- /.table-responsive -->
              <div class="box-footer clearfix">
                <a href="bitacora_compras.php" class="btn btn-sm btn-danger btn-flat pull-right">Ver todas las Compras</a>
              </div><!-- /.box-footer -->
            </div>
          </div>
        </div>
        </div>
      </div>

    </div>






    <?php
} else {
    ?>
    <section class="content">
      <div class="alert alert-danger" align="center">
        <h3>Acceso denegado! </h3>
        <p>No cuentas con los permisos necesario para acceder a este módulo.</p>
      </div>
    </section>
    <?php
}
?>
</div>
<!-- end container -->
</div>
<!-- end content -->

<?php require 'includes/pie.php';?>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->


<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/principal.js"></script>
<script src='build/locale/es-do.js'></script>
<script src="build/js/bootstrap-datetimepicker.min.js"></script>
 <script type="text/javascript">
                                      $(function () {
                                        $('#fecha').datetimepicker({
                                          format: 'YYYY-MM-DD',
                                          sideBySide: true,
      //daysOfWeekDisabled: [0, 7]

    });

                                      });
                                    </script>
<script>
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawVisualization);

  function errorHandler(errorMessage) {
            //curisosity, check out the error in the console
            console.log(errorMessage);
            //simply remove the error, the user never see it
            google.visualization.errors.removeError(errorMessage.id);
          }

          function drawVisualization() {
        // Some raw data (not necessarily accurate)
    var periodo=$("#periodo").val();//Datos que enviaremos para generar una consulta en la base de datos
    var jsonData= $.ajax({
      url: 'chart.php',
      data: {'periodo':periodo,'action':'ajax'},
      dataType: 'json',
      async: false
    }).responseText;

    var obj = jQuery.parseJSON(jsonData);
    var data = google.visualization.arrayToDataTable(obj);



    var options = {
      title : 'VENTAS VS COMPRAS'+periodo,
      vAxis: {title: 'Monto'},
      hAxis: {title: 'Meses'},
      seriesType: 'bars',
      series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    google.visualization.events.addListener(chart, 'error', errorHandler);
    chart.draw(data, options);
  }

  // Haciendo los graficos responsivos
  jQuery(document).ready(function(){
    jQuery(window).resize(function(){
     drawVisualization();
   });
  });

</script>
<script>
$("#guardar_caja").submit(function(event) {
      $('#guardar_datos').attr("disabled", true);
      var valor = $("#valor").val();
      var parametros = $(this).serialize();
      if (isNaN(valor)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'CAJA INICIAL NO ES UN VALOR VALIDO, INTENTAR DE NUEVO')
        $("#valor").val('');
        $("#valor").focus();
        $('#guardar_datos').attr("disabled", false);
        return false;
      }
      $.ajax({
        type: "POST",
        url: "../ajax/guardar_caja.php",
        data: parametros,
        beforeSend: function(objeto) {
          $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
          $("#resultados_ajax").html(datos);
          $('#guardar_datos').attr("disabled", false);
          $('#modal_vuelto').modal('hide'); //CIERRA LA MODAL
                //resetea el formulario
                $("#guardar_caja")[0].reset();
                $("#valor").focus();
                //desaparecer la alerta
                $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'CAJA APERTURADA CON EXITO')
                window.setTimeout(function() {
                  $(".alert").fadeTo(200, 0).slideUp(200, function() {
                    $(this).remove();
                  });
                }, 2000);
            }
        });
      event.preventDefault();
    })
</script>
<?php require 'includes/footer_end.php'
?>
