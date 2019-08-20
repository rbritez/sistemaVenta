<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';

if($_SESSION['escritorio'] == 1){
    require_once "../models/Consultas.php";
    $consulta = new Consultas();
    $respuestaC = $consulta->totalComprasHoy();
    $regC = $respuestaC->fetch_object();
    $totalC = $regC->total_compra;

    $respuestaV = $consulta->totalVentasHoy();
    $regV = $respuestaV->fetch_object();
    $totalV = $regV->monto_total;

    // datos para el grafico
    $compras10 = $consulta->consultaCompras_10dias();
    $fechaC = "";
    $totalesC="";
    $nombremes="";
    while ( $regfechaC = $compras10->fetch_object()){
        list($dia,$mes)= explode("-",$regfechaC->fecha);
        switch ($mes) {
            case '1':
                $nombremes="Ene";
                break;
            case '2':
                $nombremes="Feb";
                break;
            case '3':
                $nombremes="Mar";
                break;
            case '4':
                $nombremes="Abr";
                break;
            case '5':
                $nombremes="May";
                break;
            case '6':
                $nombremes="Jun";
                break;
            case '7':
                $nombremes="Jul";
                break;
            case '8':
                $nombremes="Ago";
                break;
            case '9':
                $nombremes="Sep";
                break;
            case '10':
                $nombremes="Oct";
                break;
            case '11':
                $nombremes="Nov";
                break;
            case '12':
                $nombremes="Dic";
                break;
        }
        $fechaC = $fechaC.'"'.$dia.' de '.$nombremes .'",';
        $totalesC = $totalesC.$regfechaC->total.',';
    }
    //quitamos la ultima coma
    $fechaC = substr($fechaC,0,-1);
    $totalesC = substr($totalesC,0,-1);
    //DATOS DE VENTAS ULTIMOS 10 DIAS   
    $ventas10 = $consulta->consultaVentas_10dias();
    $fechaV = "";
    $totalesV="";
    $nombremes="";
    while ( $regfechaV = $ventas10->fetch_object()){
        list($dia,$mes)= explode("-",$regfechaV->fecha);
        switch ($mes) {
            case '1':
                $nombremes="Ene";
                break;
            case '2':
                $nombremes="Feb";
                break;
            case '3':
                $nombremes="Mar";
                break;
            case '4':
                $nombremes="Abr";
                break;
            case '5':
                $nombremes="May";
                break;
            case '6':
                $nombremes="Jun";
                break;
            case '7':
                $nombremes="Jul";
                break;
            case '8':
                $nombremes="Ago";
                break;
            case '9':
                $nombremes="Sep";
                break;
            case '10':
                $nombremes="Oct";
                break;
            case '11':
                $nombremes="Nov";
                break;
            case '12':
                $nombremes="Dic";
                break;
        }
        $fechaV = $fechaV.'"'.$dia.' de '.$nombremes .'",';
        $totalesV = $totalesV.$regfechaV->total.',';
    }
    //quitamos la ultima coma
    $fechaV = substr($fechaV,0,-1);
    $totalesV = substr($totalesV,0,-1);

     //DATOS DE VENTAS ULTIMOS 10 DIAS   
     $ventasMes = $consulta->ventas12meses();
     $fechaMV = "";
     $totalesMV="";
    
     while ( $regfechaMV = $ventasMes->fetch_object()){
         $fechaMV = $fechaMV.'"'.$regfechaMV->fecha .'",';
         $totalesMV = $totalesMV.$regfechaMV->total.',';
     }
     //quitamos la ultima coma
     $fechaMV = substr($fechaMV,0,-1);
     $totalesMV = substr($totalesMV,0,-1);

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
                        <h1 class="box-title">BIENVENIDO AL SISTEMA </h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body" style="text-align:center">
                        <div class="col-lg-6 col-md-6 col-ms-6 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="ineer">
                                    <h4 style="font-size:17px">
                                        <strong>$ <?php echo $totalC;?></strong>
                                    </h4>
                                    <p>Compras de Hoy</p>
                                    <div class="icon">
                                    <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="index_compras.php" style="color:white" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-ms-6 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="ineer">
                                    <h4 style="font-size:17px">
                                        <strong>$ <?php echo $totalV;?><b id="ganancias"></b></strong>
                                    </h4>
                                    <p>Ventas de Hoy</p>
                                    <div class="icon">
                                    <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="index_ventas.php" style="color:white" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-ms-6 col-xs-12">
                            <div class="box box-primary">
                            <div class="box-header with-border">
                                Compras de los ultimos 10 Dias
                            </div>
                                <!-- incluimos la etiqueta canvas que sirve para mostrar graficos estadisticos -->
                                <canvas id="compras" width="400" height="300"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-ms-6 col-xs-12">
                            <div class="box box-primary">
                            <div class="box-header with-border">
                                Ventas de los ultimos 10 Dias
                            </div>
                                <!-- incluimos la etiqueta canvas que sirve para mostrar graficos estadisticos -->
                                <canvas id="ventas" width="400" height="300"></canvas>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6 col-ms-6 col-xs-12">
                        
                            <div class="box box-primary">
                            <div class="box-header with-border">
                                Ventas de los ultimos 12 meses
                            </div>
                                <!-- incluimos la etiqueta canvas que sirve para mostrar graficos estadisticos -->
                                <canvas id="ventasMes" width="400" height="300"></canvas>
                            </div>
                        </div>   
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

<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript" src="scripts/escritorio.js"></script>
<script type="text/javascript">
var ctx = document.getElementById('compras').getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechaC;?>],
        datasets: [{
            label: '# Compras en $ de los ultimos 10 días',
            data: [<?php echo $totalesC;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
                // quitar o agregar mas segun la cantidad de dias
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
                // quitar o agregar mas segun la cantidad de dias
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<script type="text/javascript">
var ctx = document.getElementById('ventas').getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechaV;?>],
        datasets: [{
            label: '# Ventas en $ de los ultimos 10 días',
            data: [<?php echo $totalesV;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
                // quitar o agregar mas segun la cantidad de dias
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
                // quitar o agregar mas segun la cantidad de dias
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<script type="text/javascript">
var ctx = document.getElementById('ventasMes').getContext('2d');
var ventasMes = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechaMV;?>],
        datasets: [{
            label: '# Ventas en $ de los ultimos 12 Meses',
            data: [<?php echo $totalesMV;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
                // quitar o agregar mas segun la cantidad de dias
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
                // quitar o agregar mas segun la cantidad de dias
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<?php 
} //cerramos el else de sesion
ob_end_flush();
?>