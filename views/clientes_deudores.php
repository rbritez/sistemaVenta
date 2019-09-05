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
                        <h1 id="title_venta" class="box-title">Clientes Deudores</h1>
                        <!-- boton para el modal  
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_categoria"><i class="fa fa-plus-circle"></i> Agregar</button>
                        -->
                        <div class="box-tools pull-right"></div>
                    </div>
                      <!-- /.box-header -->
                    <!-- centro -->
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

<?php
}else{
    require 'accesoDenegado.php';
};
require 'footer.php';
?>
<script type="text/javascript" src="scripts/venta.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>