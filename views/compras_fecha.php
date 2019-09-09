<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';

if($_SESSION['consultac'] == 1){

?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border" id="titlebtn">
                        <h1 class="box-title">Consulta de Compras</h1>
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
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%;text-transform:uppercase">
                            <thead>
                                <th>FECHA</th>
                                <th>PROVEEDOR</th>
                                <th>USUARIO</th>
                                <th>COMPROBANTE</th>
                                <th>SERIE | NUMERO</th>
                                <th>TOTAL VENTA</th>
                                <th>ESTADO</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>FECHA</th>
                                <th>PROVEEDOR</th>
                                <th>USUARIO</th>
                                <th>COMPROBANTE</th>
                                <th>SERIE | NUMERO</th>
                                <th>TOTAL VENTA</th>
                                <th>ESTADO</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="text-align:center">
                        <div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border" id="textofecha" style="font-size:18px">
                                    
                                </div>
                                <!-- incluimos la etiqueta canvas que sirve para mostrar graficos estadisticos -->
                                <canvas id="comprasFecha" width="300" height="100"></canvas>
                            </div>
                        </div>
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
<style>
#verGrafico:hover{
    text-decoration:none;
    border:none;
    color:red;
    border:red;
}
#verGrafico:active{
    text-decoration:none;
    border:none;
}
#verGrafico:focus{
    text-decoration:none;
    border:none;
}
</style>
<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javaScript">
var ctx = document.getElementById('comprasFecha').getContext('2d');
    function myFunction(fechaC,totalesC) {
        if(fechaC[0] == false){       
             $("#comprasFecha").hide();
             $("#textofecha").hide();
        }else{
            $("#comprasFecha").show();
            $("#textofecha").show();
               // grafico de aumento en precio total
               var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels:fechaC,
                        datasets: [{
                        label:['Compras por Fecha '],
                            data: totalesC, //mostramos precios
                            backgroundColor: [
                                'rgba(255, 255, 255,0.10)',

                            ],
                            borderColor:[
                                "rgba(243,156,18)"
                            ]
                        }]
                    },
                        options: {
                        scales: {
                            yAxes: [{
                                stacked: true
                            }]
                        }
                    }
                });
        }
    }
</script>
<?php
}else{
    require 'accesoDenegado.php';
};
require 'footer.php';
?>
<script type="text/javascript" src="scripts/comprasFecha.js"></script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>