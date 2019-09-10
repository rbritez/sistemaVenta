<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{
require 'header.php';
//verificamos si tiene acceso al modulo
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
                        <h1 class="box-title" id="title">LISTA DE CUENTAS <button type="button" class="btn btn-success" onclick="mostrarform(true)" id="btnpagar"><i class="fa fa-money" aria-hidden="true"></i> Pagar Cuota</button></h1>  <?php if($_SESSION['acceso'] =='1'){
                            echo '<button class="btn btn-warning" data-toggle="modal" data-target="#modal_interes" id="btnInteres" onclick="mostrarformInteres()" style="font-size:14.5px"><i class="fa fa-pencil"></i> Interes</button>';
                        }?>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead >
                                <th style="text-align: center;">OPCIONES</th>
                                <th style="text-align: center;">FECHA DE CUENTA</th>
                                <th style="text-align: center;">NOMBRE Y APELLIDO CLIENTE</th>
                                <th style="text-align: center;">DNI CLIENTE</th>
                                <th style="text-align: center;">USUARIO</th>
                                <th style="text-align: center;">TOTAL DE CUOTAS</th>
                                <th style="text-align: center;">ESTADO</th>
                            </thead>
                            <tbody style="text-align: center;text-transform:uppercase">
                            </tbody>
                            <tfoot>
                                <th style="text-align: center;">OPCIONES</th>
                                <th style="text-align: center;">FECHA DE CUENTA</th>
                                <th style="text-align: center;">NOMBRE Y APELLIDO CLIENTE</th>
                                <th style="text-align: center;">DNI CLIENTE</th>
                                <th style="text-align: center;">USUARIO</th>
                                <th style="text-align: center;">TOTAL DE CUOTAS</th>
                                <th style="text-align: center;">ESTADO</th>
                            </tfoot>
                        </table><br>
                        <div id="mostrarinteres" style="text-align:center; font-style:italic" align="center">
                            
                        </div>
                        
                    </div>
                    <div class="panel-body"  style="height: 400px;display:none" id="formularioregistros">
                        <div class="col-md-6 col-xs-12" style="text-transform:uppercase">
                            <label><h4>CLIENTE:</h4></label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker" data-live-search="true"></select>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label><h4>CUENTA:</h4></label>
                            <select name="cuenta_id" id="cuenta_id" class="form-control selectpicker" data-live-search="true"></select>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <label><h4>CUOTA:</h4></label>
                            <div id="divcuota">
                                <select name="cuota_id" id="cuota_id" class="form-control selectpicker" data-live-search="true"></select>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                        <label for=""></label></div>
                        <div class="col-lg-12 col-ms-12-col-md-12 col-xs-12">
                        <form name="formulariocuota" id="formulariocuota" method="POST">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="display:none;">
                            <thead style="background-color:#F39C12" style="text-align:center">
                                            <th style="text-align:center" >Opciones</th>
                                            <th style="text-align:center" >Fecha Vto</th>
                                            <th style="text-align:center" >Nro Cuota</th>
                                            <th style="text-align:center" >Monto Cuota</th>
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
                                    <th><p id="total" style="font-size:15px">$ 0.00</p><input type="hidden" name="total_compra" id="total_compra"></th>
                                </tfoot>
                            </table>
                        </div>
                        <tfoot>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                        <button class="btn btn-danger" onclick="cancelarform()"><i class="fa fa-arrow-circle-left"></i> VOLVER</button>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <button class="btn btn-primary pull-right" type="submit" id="btnguardar"><i class="fa fa-save"></i> GUARDAR</button>
                        </div>
                        </tfoot>    
                        </form>
                    </div>
                   <!-- Fin centro -->
                    <!-- MODAL INTERES -->
                    <div class="modal fade" id="modal_interes"> <!-- modallllllllll-->
                        <div class="modal-dialog">
                            <div class="modal-content"> <!-- div content --> 
                                <div class="modal-warning modal-header " style="background-color:#f39c12">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" style="color:white">&times;</span>
                                    </button>
                                    <h4 style="color:white;" id="title_proveedor" class="modal-title">MODIFICAR INTERES DE POR MORA</h4>
                                </div >
                                <div id="forminteres">
                                
                                </div>
                            </div><!-- div content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!-- FIN MODAL INTERES -->
                    <!-- modal -->
                    <div class="modal fade" id="modal_cuenta"> <!-- modallllllllll-->
                        <div class="modal-dialog" style="width:65% !important;">
                            <div class="modal-content"> <!-- div content --> 
                                <div class="modal-warning modal-header " style="background-color:#f39c12">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" style="color:white">&times;</span>
                                    </button>
                                    <h4 style="color:white;" id="title_proveedor" class="modal-title">DETALLES DE LA CUENTA</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <label ><h3 style="font-weight: bold;">Productos Comprados:</h3></label>
                                               <div class="col-md-12" id="mostrarProducto">
                                               
                                               </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label><h3 style="font-weight: bold;">Total de Compra:</h3></label>
                                                <div class="col-md-12" id="mostrarProductoTotal">
                                               
                                                </div> 
                                            </div>
                                        </div>
                                        
                                        <div class="panel-body table-responsive" id="listadoregistrosCuotas">
                                            <table id="tablalistadoCuota" class="table table-bordered table-hover nowrap" style="width:100% ;font-size:18px">
                                                <thead >
                                                    <th></th>
                                                    <th style="text-align: center;">N° Cuota</th>
                                                    <th style="text-align: center;">Fecha Vencimiento</th>
                                                    <th style="text-align: center;">Fecha Pago</th>
                                                    <th style="text-align: center;">Interes</th>
                                                    <th style="text-align: center;">Monto</th>
                                                    <th style="text-align: center;">Estado</th>
                                                </thead>
                                                <tbody style="text-align: center;text-transform:uppercase">
                                                </tbody>
                                                <tfoot>  
                                                    <th></th>
                                                    <th style="text-align: center;">N° Cuota</th>
                                                    <th style="text-align: center;">Fecha Vencimiento</th>
                                                    <th style="text-align: center;">Fecha Pago</th>
                                                    <th style="text-align: center;">Interes</th>
                                                    <th style="text-align: center;">Monto</th>
                                                    <th style="text-align: center;">Estado</th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>    
                                <div>    
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrar" name="cerrar" onclick="limpiar()"><i class="fa fa-arrow-circle-left" ></i> CANCELAR</button>
                                </div>
                            </div><!-- div content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                    </div> 
                    </div>  
                    <!-- fin modal -->
                   
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
    
<?php
}else{
    require 'accesoDenegado.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/cuentas.js"></script>

<?php
};
ob_end_flush();
?>