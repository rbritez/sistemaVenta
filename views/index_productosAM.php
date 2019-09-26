<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';

if($_SESSION['servicios'] == 1){

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
                        <!-- <h1 class="box-title">Lista de Consultas y Pedidos de Productos a Medida <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_categoria"><i class="fa fa-plus-circle"></i> Nuevo Pedido</button></h1>
                        <div class="box-tools pull-right"></div> -->
                        <h1 class="box-title">Lista de Consultas y Pedidos de Productos a Medida <button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo Pedido</button></h1>
                        <div class="box-tools pull-right"></div> 
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead>
                                <th>OPCIONES</th>
                                <th>N Y A CLIENTE</th>
                                <th>FECHA PEDIDO</th>
                                <th>ALTO</th>
                                <th>ANCHO</th>
                                <th>PROF.</th>
                                <th>MATERIAL</th>
                                <th>CATEGORIA</th>
                                <th>INFORMACION ADICIONAL</th>
                                <th>ESTADO</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <th>OPCIONES</th>
                                <th>N Y A CLIENTE</th>
                                <th>FECHA PEDIDO</th>
                                <th>ALTO</th>
                                <th>ANCHO</th>
                                <th>PROF.</th>
                                <th>MATERIAL</th>
                                <th>CATEGORIA</th>
                                <th>INFORMACION ADICIONAL</th>
                                <th>ESTADO</th>
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
    <div class="modal fade" id="modal_categoria"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_categoria" class="modal-title">Nuevo Pedido o Consulta de Producto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario" id="formulario" method="POST">
                                <div class="form-group">
                                    <!-- <input type="hidden" name="id_categoria" id="id_categoria"> -->
                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" placeholder="" maxlength="50" required>
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
}else{
    require 'accesoDenegado.php';
};
require 'footer.php';
?>
<script type="text/javascript" src="scripts/productosAM.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>