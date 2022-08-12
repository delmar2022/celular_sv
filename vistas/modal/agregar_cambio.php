<?php
if (isset($conexion)) {
?>
    <form class="form-horizontal" method="post" name="cambio_stock" id="cambio_stock">
        <!-- Modal -->
        <div id="cambio-stock" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title"> <i class="fa fa-edit"></i> Intercambio de Producto</h4>
                    </div>
                    <div class="modal-body">
                        <!--<div id="resultados_ajax"></div>-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prouducto" class="control-label">Producto:</label>
                                    <input type="text" class="form-control" id="producto" name="producto" autocomplete="off" value="<?php echo $rw_factura['nombre_producto']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="costo" class="control-label">Costo:</label>
                                    <input type="text" class="form-control" id="costo" name="costo" autocomplete="off" value="<?php echo $rw_factura['costo_producto']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity" class="control-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prouducto" class="control-label">Producto 2:</label>
                                    <input type="text" class="form-control" placeholder="BUSCAR PRODUCTO" id="nombre_producto" par autocomplete="off" style=" background-color:#A9D0F5; border-radius: 5px; border: 1px solid #39c; text-align: center" required>
                                    <input id="id_producto2" name="id_producto2" type='hidden'>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quan" class="control-label">Costo:</label>
                                    <input type="text" class="form-control" id="quan" name="quan" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quantity2" class="control-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="quantity2" name="quantity" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="motivo" class="control-label">Motivo:</label>
                                    <input type="text" class="form-control" id="motivo" name="motivo" autocomplete="off">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos2">Guardar</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
<?php
}
?>