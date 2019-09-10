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
                        <h1 id="title_venta" class="box-title">Clientes Deudores <a href="index_cuentas.php" type="button" role="button" class="btn btn-success"> Ir a Cuentas</a></h1>
                        <!-- boton para el modal  
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_categoria"><i class="fa fa-plus-circle"></i> Agregar</button>
                        -->
                        <div class="box-tools pull-right"></div>
                    </div>
                      <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros" align="center">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%;text-align: center; text-transform:uppercase; ">
                            <thead>
                                <th></th>
                                <th style="text-align: center">NOMBRES Y APELLIDOS</th>
                                <th style="text-align: center">CUENTAS ACTIVAS</th>
                                <th style="text-align: center">CUOTAS EN ESTADO PENDIENTE</th>
                                <th style="text-align: center">CUOTAS EN ESTADO MORA</th>
                            </thead>
                            <tbody align="center">
                            </tbody>
                            <tfoot>
                                <th></th>
                                <th style="text-align: center">NOMBRES Y APELLIDOS</th>
                                <th style="text-align: center">CUENTAS ACTIVAS</th>
                                <th style="text-align: center">CUOTAS EN ESTADO PENDIENTE</th>
                                <th style="text-align: center">CUOTAS EN ESTADO MORA</th>
                            </tfoot>
                        </table>
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

<?php
}else{
    require 'accesoDenegado.php';
};
require 'footer.php';
?>
<script type="text/javascript" src="scripts/clientesDeudores.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>