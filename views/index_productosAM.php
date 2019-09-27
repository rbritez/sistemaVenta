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
                        <h1 class="box-title" id="title_pm"></h1>
                        <div class="box-tools pull-right"></div> 
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%;text-transform:uppercase" align="center">
                            <thead style="text-align:center;" >
                                <th style="text-align:center;"  >OPCIONES</th>
                                <th style="text-align:center;" >NOMBRE Y APELLIDO DE CLIENTE</th>
                                <th style="text-align:center;"  >FECHA DE PEDIDO</th>
                                <th style="text-align:center;"  >FECHA DE CONFIRMACION</th>
                                <th style="text-align:center;"  >ESTADO DE CONFIRMACION</th>
                                <th style="text-align:center;"  >ESTADO</th>
                            </thead>
                            <tbody style="text-align:center;" >

                            </tbody>
                            <tfoot style="text-align:center;" >
                                <th style="text-align:center;"  >OPCIONES</th>
                                <th style="text-align:center;"  >NOMBRE Y APELLIDO DE CLIENTE</th>
                                <th style="text-align:center;"  >FECHA DE PEDIDO</th>
                                <th style="text-align:center;"  >FECHA DE CONFIRMACION</th>
                                <th style="text-align:center;"  >ESTADO DE CONFIRMACION</th>
                                <th style="text-align:center;"  >ESTADO</th>
                            </tfoot>
                        </table>
                    </div>
                        <div class="panel-body  style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" name="id_prod_medida" id="id_prod_medida">
                                    <label>CLIENTE:</label>
                                    <select class="form-control selectpicker" style="text-transform:uppercase;" data-live-search="true" name="cliente_id" id="cliente_id" required></select>
                                </div>
           
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                    <label>FECHA</label>
                                    <input type="date" class="form-control" name="fecha_p" id="fecha_p" required>
                                    <input type="hidden" name="cfilas" id="cfilas">
                                </div>
     
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="boton_block">
                                    <button type="button"  class="btn btn-block btn-success" onclick="agregardetalle()" >
                                            <span class="fa fa-plus"></span> Agregar Pedido 
                                    </button>
                                </div>
                                <div class="col-lg-12 col-ms-12-col-md-12 col-xs-12 table-responsive" >
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover nowrap" style="height:200px" align="center">
                                        <thead style="background-color:#F39C12" style="text-align:center">
                                            <th style="text-align:center" >Opciones</th>
                                            <th style="text-align:center" >Cantidad</th>
                                            <th style="text-align:center" >Alto</th>
                                            <th style="text-align:center" >Ancho</th>
                                            <th style="text-align:center" >Profundidad</th>
                                            <th style="text-align:center" >Material</th>
                                            <th style="text-align:center" >Categoria</th>
                                            <th style="text-align:center" >Información Adicional</th>
                                        </thead>
                                        <tbody style="height:200px" >
                                        
                                        </tbody>
                                       
                                    </table>
                                    <div  style="text-align:center; font-style:italic" align="center">
                                            <span>Las medidas utilizadas son <b>Metros (m)</b> Pj: 1 m = 100 cm , 0.5 m = 50 cm. </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                    <button class="btn btn-danger" onclick="cancelarform()" id="btnCancelar"> <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                    <button class="btn btn-primary pull-right" id="btnguardar" style="display:none" type="submit"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
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