<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';

if($_SESSION['compras'] == 1){

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
                        <h1 class="box-title">Lista de Compras <button type="button" id="btnagregar" onclick="mostrarform(true)" class="btn btn-success" ><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <!-- boton para el modal  
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_categoria"><i class="fa fa-plus-circle"></i> Agregar</button>
                        -->
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead>
                                <th>OPCIONES</th>
                                <th>FECHA</th>
                                <th>PROVEEDOR</th>
                                <th>USUARIO</th>
                                <th>FACTURA</th>
                                <th>NUMERO</th>
                                <th>TOTAL COMPRA</th>
                                <th>ESTADO</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>OPCIONES</th>
                                <th>FECHA</th>
                                <th>PROVEEDOR</th>
                                <th>USUARIO</th>
                                <th>FACTURA</th>
                                <th>NUMERO</th>
                                <th>TOTAL COMPRA</th>
                                <th>ESTADO</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- CONTENIDO DEL FORMULARIO DE COMPRA -->
                        <div class="panel-body" style="height:400px;display:none" id="formularioregistros" >
                            <form name="formulario" id="formulario" method="POST">
                                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="hidden" name="id_compra" id="id_compra">
                                    <label>PROVEEDOR:</label>
                                    <select class="form-control selectpicker" style="text-transform:uppercase;" data-live-search="true" name="proveedor_id" id="proveedor_id" required></select>
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                                    <label>FECHA</label>
                                    <input type="date" class="form-control" name="fecha_compra" id="fecha_compra" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                    <label>TIPO COMPROBANTE</label>
                                    <select name="tipocomprobante" id="tipocomprobante" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="boleta">BOLETA</option>
                                        <option value="factura">FACTURA</option>
                                        <option value="ticket">TICKET</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
                                    <label>SERIE</label>
                                    <input type="text" class="form-control" maxlength="7" name="serie" id="serie" required>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
                                    <label>NUMERO</label>
                                    <input type="text" class="form-control" maxlength="10" name="numcomprobante" id="numcomprobante" required>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
                                    <label>IMPUESTO</label>
                                    <input type="text" class="form-control" name="impuesto" id="impuesto" required>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="boton_block">
                                    <button type="button"  class="btn btn-block btn-warning" data-toggle="modal" data-target="#modal_categoria" onclick="listarProductos()">
                                            <span class="fa fa-plus"></span> Agregar Productos 
                                    </button>
                                </div>
                                <div class="col-lg-12 col-ms-12-col-md-12 col-xs-12">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#F39C12">
                                            <th>Opciones</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Compra</th>
                                            <th>Precio Venta</th>
                                            <th>Subtotal</th>
                                            
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                        <tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><p id="total" style="font-size:20px">$ 0.00</p><input type="hidden" name="total_compra" id="total_compra"></th>
                                        </tfoot>
                                       
                                    </table>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                                    <button class="btn btn-danger" onclick="cancelarform()" id="btnCancelar"> <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                                    <button class="btn btn-primary pull-right" type="submit" id="btnguardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- FIN DE FORMULARIO -->
                    <!-- Fin centro -->
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
                    <h4 style="color:white;" id="title_categoria" class="modal-title">Seleccionar Producto</h4>
                </div>
                <div class="modal-body">
                    <table id="tblproductos" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Opciones</th>
                        <th>Descripcion</th>
                        <th>Codigo</th>
                        <th>Stock</th>
                        <th>Material</th>
                        <th>Categoria</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>Opciones</th>
                        <th>Descripcion</th>
                        <th>Codigo</th>
                        <th>Stock</th>
                        <th>Material</th>
                        <th>Categoria</th>
                    </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php
}else{
    require 'accesoDenegado.php';
};
require 'footer.php';
?>
<script type="text/javascript" src="scripts/compras.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>