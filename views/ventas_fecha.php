<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';

if($_SESSION['consultav'] == 1){

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
                        <h1 class="box-title">Consulta de Ventas</h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label >FECHA INICIO</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label >FECHA FIN</label>
                    <input type="date" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros" style="text-align:center">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead >
                                <th style="text-align:center">FECHA</th>
                                <th style="text-align:center" >CLIENTE</th>
                                <th style="text-align:center" >USUARIO</th>
                                <th style="text-align:center" >COMPROBANTE</th>
                                <th style="text-align:center" >SERIE | NUMERO</th>
                                <th style="text-align:center" >TOTAL COMPRA</th>
                                <th style="text-align:center" >ESTADO</th>
                            </thead>
                            <tbody >

                            </tbody>
                            <tfoot>
                                <th style="text-align:center" >FECHA</th>
                                <th style="text-align:center" >CLIENTE</th>
                                <th style="text-align:center" >USUARIO</th>
                                <th style="text-align:center" >COMPROBANTE</th>
                                <th style="text-align:center" >SERIE | NUMERO</th>
                                <th style="text-align:center" >TOTAL COMPRA</th>
                                <th style="text-align:center" >ESTADO</th>
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

<?php
}else{
    require 'accesoDenegado.php';
};
require 'footer.php';
?>
<script type="text/javascript" src="scripts/ventasFecha.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>