<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{
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
                        <h1 id="title_venta" class="box-title" style="font-size:25px">ACERCA DE GSyF(Sistema de Gestion y Facturación)</h1>
                   
                        <!-- boton para el modal  
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_categoria"><i class="fa fa-plus-circle"></i> Agregar</button>
                        -->
                        <div class="box-tools pull-right"></div>
                    </div>
                    <div class="box-body" style="margin:5px 0px 0px 0px;text-align:center; font-size:30px;padding:200px 0px">
                        <div class="col-md-12">
                        <img src="../reportes/logoicono.jpg" alt="GsyF" width="70px"> <b>GSyF</b>, Versión 1.1.0 <br>
                        Copyright <i class="fa fa-copyright"></i> 2019-2023 Gerardo Britez A.S, Producido para <b>FA S.R.L</b> - Formosa Aberturas S.R.L <br><b>Todos los Derechos Reservados.</b> <br>
                        Este producto está protegido por la Patente de <b>CESSI Argentina</b>, Obra Inédita N° 9.153.544.
                        </div>
                    </div>
                      <!-- /.box-header -->
                    <!-- centro -->
                   
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
<footer class="main-footer" style="font-size:15px;">
        <b>Advertencia:</b> Este programa está protegido por las leyes de copyright y propiedad intelectual. Queda terminantemente prohibida cualquier forma de reproducción o distribución parcial o total sin permiso en primera instancia expreso de Gerardo Britez A.S y en segunda instancia expreso de FA- Formosa Abertura en cualquiera de sus versiones, y se penalizará asta el grado máximo en que lo permitan las leyes nacionales e internacionales.
        GSyF, GSyF logotipo, GSyF Sistema Web y todas las marcas pertenecientes a GSyF son marcas de propiedad intelecutal y obra Inedita regstradas son propiedad de sus respectivos propietarios. 
    </footer>

<?php
require 'footer.php';
}
?>