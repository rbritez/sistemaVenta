<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{
    require 'header.php';
    //verificamos si tiene acceso al modulo
if($_SESSION['almacen'] == 1){
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Lista de productos <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_producto"><i class="fa fa-plus-circle"></i> Agregar</button>
                        <a target="_blank" href="../reportes/rptarticulos.php"><button class="btn btn-info">Reporte</button></a>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead>
                                <th>Opciones</th>
                                <th>Codigo del Producto</th>
                                <th>Descripcion</th>
                                <th>Stock</th>
                                <th>Material</th>
                                <th>Categoria</th>
                                <th>Imagenes</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Codigo del Producto</th>
                                <th>Descripcion</th>
                                <th>Stock</th>
                                <th>Material</th>
                                <th>Categoria</th>
                                <th>Imagenes</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- <div class="panel-body  style="height: 400px;" id="formularioregistros">
                    </div>
                    Fin centro -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
    <div class="modal fade" id="modal_producto"> <!-- modal para crear productos -->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_product" class="modal-title">Nuevo Producto</h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario" id="formulario" method="POST" >
                                <div class="form-group">
                                    <input type="hidden" name="id_producto" id="id_producto">
                                    <label class="col-sm-2 col-sm-2 control-label">Codigo de Producto</label>
                                    <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" name="cod_producto" id="cod_producto" class="form-control" placeholder="" maxlength="" required>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success" type="button" onclick="generarBarcode()"><i class="fa fa-barcode"></i> Generar</button>
                                                </span>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info" onclick="printBarcode()"> <i class="fa fa-print"></i> Imprimir</button>
                                                </span>
                                            </div>    
                                            <div id="printbarcode" style="display:none">
                                                <svg id="barcode"></svg>
                                            </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Descripcion</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Stock</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="stock" id="stock" class="form-control" placeholder="" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Precio</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="precio" id="precio" class="form-control" placeholder="" min="1" step="0.01"  value="1.00"required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Material</label>
                                    <div class="col-sm-10">
                                        <select name="material_id" id="material_id" class="form-control selectpicker" data-live-search="true" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Categoria</label>
                                    <div class="col-sm-10">
                                        <select name="categoria_id" id="categoria_id" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"  id="cerrar" name="cerrar"><i class="fa fa-arrow-circle-left"></i> Volver</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> Guardar</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal_imagenProducto"> <!-- modallllllllll para guardar nuevas imagenes-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header"  id="modalimagen" style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" class="modal-title">Nueva Imagen</h4>
                </div>  
                  <!-- contenido  -->
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
}else{
    require 'accesoDenegado.php';
}
    require 'footer.php';
?>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type='text/javascript' src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="scripts/producto.js"></script>
<?php
}
ob_end_flush();

?>