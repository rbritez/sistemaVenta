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
                        <h1 class="box-title">Lista de Proveedores <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_proveedor"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%,">
                            <thead >
                                <th style="text-align: center;">Opciones</th>
                                <th style="text-align: center;">Razon Social</th>
                                <th style="text-align: center;">Nombres</th>
                                <th style="text-align: center;">Apellidos</th>
                                <th style="text-align: center;">Contactos</th>
                                <th style="text-align: center;">Direcciones</th>
                                <th style="text-align: center;">Estado</th>
                            </thead>
                            <tbody style="text-align: center;">

                            </tbody>
                            <tfoot>
                                <th style="text-align: center;">Opciones</th>
                                <th style="text-align: center;">Razon Social</th>
                                <th style="text-align: center;">Nombres</th>
                                <th style="text-align: center;">Apellidos</th>
                                <th style="text-align: center;">Contactos</th>
                                <th style="text-align: center;">Direcciones</th>
                                <th style="text-align: center;">Estado</th>
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
    <div class="modal fade" id="modal_proveedor"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_proveedor" class="modal-title">Nuevo Proveedor</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario" id="formulario" method="POST">
                                <div class="form-group">
                                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                                    <input type="hidden" name="persona_id" id="persona_id">
                                    <label class="col-sm-2 col-sm-2 control-label">NOMBRES</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nombres" id="nombres" class="form-control" placeholder="" maxlength="50" required>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrar" name="cerrar"><i class="fa fa-arrow-circle-left" ></i> Volver</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> Guardar</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php
require 'footer.php';
?>
<script type="text/javascript" src="scripts/proveedor.js"></script>
