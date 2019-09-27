<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';

if($_SESSION['ventas'] == 1){

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
                        <h1 id="title_venta" class="box-title">Lista de Ventas <button type="button" id="btnagregar" onclick="mostrarform(true)" class="btn btn-success" ><i class="fa fa-plus-circle"></i> Nueva Factura</button></h1>
                        <!-- boton para el modal  
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_categoria"><i class="fa fa-plus-circle"></i> Agregar</button>
                        -->
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%; text-transform:uppercase">
                            <thead>
                                <th>OPCIONES</th>
                                <th>FECHA</th>
                                <th>CLIENTE</th>
                                <th>USUARIO</th>
                                <th>FACTURA</th>
                                <th>NUMERO</th>
                                <th>TIPO PAGO</th>
                                <th>TOTAL VENTA</th>
                                <th>ESTADO</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>OPCIONES</th>
                                <th>FECHA</th>
                                <th>CLIENTE</th>
                                <th>USUARIO</th>
                                <th>FACTURA</th>
                                <th>NUMERO</th>
                                <th>TIPO PAGO</th>
                                <th>TOTAL VENTA</th>
                                <th>ESTADO</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- CONTENIDO DEL FORMULARIO DE COMPRA -->
                        <div class="panel-body" style="height:400px;display:none" id="formularioregistros" >
                        <form name="formulario" id="formulario" method="POST">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <input type="hidden" name="id_venta" id="id_venta">
                                    <label>CLIENTE:</label>
                                    <select class="form-control selectpicker" style="text-transform:uppercase;" data-live-search="true" name="cliente_id" id="cliente_id" required></select>
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                                    <label>TIPO FACTURA</label>
                                    <select name="tipocomprobante" id="tipocomprobante" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                                    <label>FECHA</label>
                                    <input type="date" class="form-control" name="fecha_venta" id="fecha_venta" required>
                                </div>
                                <div id="tipoPagoDiv" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                    <label>TIPO PAGO</label>
                                    <select name="tipo_pago" id="tipo_pago" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="efectivo" selected>EFECTIVO</option>
                                        <option value="tarjeta">TARJETA</option>
                                        <option value="cred_personal">CREDITO PERSONAL</option>
                                    </select>
                                </div>
                                <div id="cuotasDiv" class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
                                    <label>CUOTAS</label>
                                    <select name="nro_cuotas" id="nro_cuotas" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Seleccionar...</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
                                    <label>SERIE</label>
                                    <input type="text" class="form-control" maxlength="7" name="serie" id="serie" required>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
                                    <label>NUMERO</label>
                                    <input type="text" class="form-control" maxlength="10" name="codigo" id="codigo" required>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
                                    <label>IMPUESTO</label>
                                    <input type="text" class="form-control" name="impuesto" id="impuesto" required>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="boton_block">
                                    <button type="button"  class="btn btn-block btn-success" data-toggle="modal" data-target="#modal_categoria" >
                                            <span class="fa fa-plus"></span> Agregar Productos 
                                    </button>
                                </div>
                                <div class="col-lg-12 col-ms-12-col-md-12 col-xs-12">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover ">
                                        <thead style="background-color:#F39C12" style="text-align:center">
                                            <th style="text-align:center" >Opciones</th>
                                            <th style="text-align:center" >Producto</th>
                                            <th style="text-align:center" >Cantidad</th>
                                            <th style="text-align:center" >Precio Venta</th>
                                            <th style="text-align:center" >Descuento</th>
                                            <th style="text-align:center" >interes</th>
                                            <th style="text-align:center" >Subtotal</th>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                        <tfoot>
                                            <th>TOTAL</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><p id="total" style="font-size:15px">$ 0.00</p><input type="hidden" name="total_compra" id="total_compra"></th>
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


<div class="modal fade" id="modal_nuevoCliente"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12" id="agregarformularioCliente">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" class="modal-title">NUEVO CLIENTE</h4>
                </div> 
                <div id="EFC">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12"> 
                            <form class="form-horizontal" name="fCliente" id="fCliente" method="POST"> 
                                <div class="form-group"> 
                                    <label class="col-sm-3 col-sm-3 control-label">NOMBRES (*)</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" name="nombres" id="nombres" class="form-control" placeholder="" style="text-transform:uppercase" maxlength="50" required> 
                                    </div> 
                                </div> 
                                <div class="form-group"> 
                                    <label class="col-sm-3 col-sm-3 control-label">APELLIDOS (*)</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" name="apellidos" id="apellidos" class="form-control" style="text-transform:uppercase" maxlength="50" required> 
                                    </div> 
                                </div> 
                                <div class="form-group"> 
                                    <label class="col-sm-3 col-sm-3 control-label">NRO DOC/CUIL (*)</label> 
                                    <div class="col-sm-9"> 
                                        <input type="text" name="nro_doc" id="nro_doc" class="form-control" style="text-transform:uppercase" maxlength="50"> 
                                    </div> 
                                </div>
                        </div>
                    </div>             
                </div>                
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrarCliente" name="cerrarCliente" ><i class="fa fa-arrow-circle-left" ></i> VOLVER</button> 
                    <button type="submit" class="btn btn-info" id="btnGuardarCliente"><i class="fa fa-save" ></i> GUARDAR</button> 
                            </form> 
                </div> 
                </div>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
</div>


    <div class="modal fade" id="modal_categoria"> <!-- modallllllllll-->
        <div class="modal-dialog" style="width:65% !important;">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_categoria" class="modal-title">Seleccionar Producto</h4>
                </div>
                <div class="modal-body">
                <div class="panel-body table-responsive">
                <table id="tblproductos" class="table table-striped table-bordered table-condensed table-hover nowrap">
                    <thead>
                        <th>Opciones</th>
                        <th>Descripcion</th>
                        <th>Codigo</th>
                        <th>Stock</th>
                        <th>Material</th>
                        <th>Categoria</th>
                        <th>Precio Venta</th>
                        <th>Imagen</th>
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
                        <th>Precio Venta</th>
                        <th>Imagen</th>
                    </tfoot>
                    </table>
                </div>
                    
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
<script type="text/javascript" src="scripts/venta.js"></script>
<script type="text/javascript" src="scripts/ventaClienteNuevo.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>