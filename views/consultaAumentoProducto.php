<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{
    require 'header.php';
    //verificamos si tiene acceso al modulo
if($_SESSION['almacen'] == 1){
  
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
                        <h1 class="box-title">HISTORIAL DE PRECIOS POR PRODUCTO </h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->

                    <div class="col-md-12 box-header with-border">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <select name="id_producto" id="id_producto" class="form-control selectpicker " data-live-search="true">
                                    <option value="">Seleccione un producto...</option>
                                </select>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead>
                                <th>Descripcion</th>
                                <th>Precio Compra</th>
                                <th>Aumento en $</th>
                                <th>Aumento en %</th>
                                <th>Fecha de Compra</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th>Descripcion</th>
                                <th>Precio Compra</th>
                                <th>Aumento en $</th>
                                <th>Aumento en %</th>
                                <th>Fecha de Compra</th>
                            </tfoot>
                        </table>
                    </div>
                        
                    <div class="panel-body" id="divgrafico" style="display:none">
                            <!-- <div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
                            <div class="box box-primary">
                            <div class="box-header with-border">
                                Historial de Precio 
                            </div>
                            <div > -->
                                    <!-- incluimos la etiqueta canvas que sirve para mostrar graficos estadisticos -->
                                
                                <!-- <input type="hidden" id="fechas" value="">
                                <input type="hidden" id="precios" value="">
                            </div>
                            </div> -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- aqui insertaremos el slider Inicio carousel -->
                            <div id="carousel1" class="carousel slide" data-ride="carousel">
                                <!-- Indicatodores -->
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel1" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel1" data-slide-to="1"></li>
                                    <li data-target="#carousel1" data-slide-to="2"></li>
                                </ol>
                                <!-- Contenedor de las imagenes -->
                                <div class="carousel-inner" role="listbox">

                                    <div class="item active">
                                    <canvas id="precioProducto" width="300" height="100" alt="Imagen 1"></canvas>
                                    <div class="carousel-caption" style="color:black"> Grafico de Precios en el Tiempo en $ </div>
                                    </div>

                                    <div class="item">
                                    <canvas id="aumentoProducto" width="300" height="100" alt="Imagen 2"></canvas>
                                    <div class="carousel-caption" style="color:black"> Grafico aumento en $ </div>
                                    </div>

                                    <div class="item">
                                    <canvas id="aumentoPorcentaje" width="300" height="100" alt="Imagen 2"></canvas>
                                    <div class="carousel-caption" style="color:black"> Grafico en % </div>
                                    </div>
                                </div>
                                <!-- Controls -->
                                <a class="left carousel-control" href="#carousel1" role="button" data-slide="prev" style="color:black">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="right carousel-control" href="#carousel1" role="button" data-slide="next" style="color:black">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                        </div><!-- fin carrousel -->
                    </div><!-- Fin centro panel body -->
                    
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
<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javaScript">
var pecios = 0;
var ctx = document.getElementById('precioProducto').getContext('2d');
var AumPro = document.getElementById('aumentoProducto').getContext('2d');
var AumPor = document.getElementById('aumentoPorcentaje').getContext('2d');
    function myFunction(fecha,precios,aumentoenteros,aumentoporcentaje) {

        if(fecha){
                var el = document.getElementById('divgrafico');
                el.style.display = 'block';           
                console.log(aumentoporcentaje);
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels:fecha,
                        datasets: [{
                        label:['Precio del Producto en $'],
                            data: precios, //mostramos precios
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
                var myLineChart2 = new Chart(AumPro, {
                    type: 'line',
                    data: {
                        labels:fecha,
                        datasets: [{
                        label:['Aumento de Precio del Producto en $'],
                            data: aumentoenteros, //mostramos aumento en entereos
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
                var myLineChart3 = new Chart(AumPor, {
                    type: 'line',
                    data: {
                        labels:fecha,
                        datasets: [{
                        label:['Aumento de Precio del Producto en %'],
                            data: aumentoporcentaje, //mostramos aumento en entereos
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
        }else{
            console.log("no hay nada para mostrar")
        } 
        
    }
</script>
<?php
}else{
    require 'accesoDenegado.php';
}
    require 'footer.php';
?>
<script type="text/javascript" src="scripts/historialProductos.js"></script>
<?php
}
ob_end_flush();

?>