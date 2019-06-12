<?php
    require 'header.php';
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
    <div class="modal fade" id="modal_producto"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" class="modal-title">Nuevo Producto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario" id="formulario" method="POST" >
                                <div class="form-group">
                                    <input type="hidden" name="id_producto" id="id_producto">
                                    <label class="col-sm-2 col-sm-2 control-label">Codigo de Producto</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="cod_producto" id="cod_producto" class="form-control" placeholder="" maxlength="" required>
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

    <div class="modal fade" id="modal_imagenProducto"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" class="modal-title">Nueva Imagen</h4>
                </div>
                <div class="modal-body">
                    <form  class="form-horizontal"  name="formularioImagen" id="formularioImagen" method="POST">
                    <input type="hidden" name="idimagen" id="idimagen">
                    <input type="hidden" name="producto_id" id="producto_id">
                        <input type="file"  id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} archivos seleccionados" accept="image/x-png,image/jpg,image/jpeg" multiple="" />
                        <label for="file-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                        <span class="iborrainputfile">Seleccionar archivo</span>
                        </label>           
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"  id="cerrarformImagen" name="cerrarformImagen"><i class="fa fa-arrow-circle-left"></i> Volver</button>
                    <button type="submit" class="btn btn-info" id="btnGuardarImagen"> <i class="fa fa-save" ></i> Guardar</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
    require 'footer.php';
?>
<script type="text/javascript" src="scripts/producto.js"></script>