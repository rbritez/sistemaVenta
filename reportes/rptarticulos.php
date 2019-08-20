
<?php
if(strlen(session_id())< 1 )
    session_start();
if(!isset($_SESSION["nombres"])){
    echo "POR FAVOR INICIA SESION DE LA MANERA CORRECTA";
}else{
    //verificamos si tiene acceso al modulo
if($_SESSION['almacen'] == 1){
// //Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
// //Instanciamos la clase para generar el documento pdf
$pdf = new PDF_MC_Table();
// //Agregamos la primera página al documento pdf
$pdf->AddPage();
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
// //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE PRODUCTOS',1,0,'C'); 
$pdf->Ln(10);
// //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(58,6,'Descripcion',1,0,'C',1); 
$pdf->Cell(50,6,utf8_decode('Código'),1,0,'C',1);
$pdf->Cell(12,6,utf8_decode('Stock'),1,0,'C',1);
$pdf->Cell(30,6,'Categoria',1,0,'C',1);
$pdf->Cell(35,6,utf8_decode('Material'),1,0,'C',1);
$pdf->Ln(10);
// //Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../models/Producto.php";
$producto = new Producto();

$rspta = $producto->listar();
// //Implementamos las celdas de la tabla con los registros a mostrar
$pdf->SetWidths(array(58,50,12,30,35));

while($reg= $rspta->fetch_object())
{  
    $nombre = $reg->descripcion;
    $codigo = $reg->cod_producto;
    $stock = $reg->stock;
    $categoria = $reg->categoria_id;
    $material =$reg->material_id;
 	
     $pdf->SetFont('Arial','',10);
     $pdf->Row(array(utf8_decode($nombre),utf8_decode($codigo),utf8_decode($stock),utf8_decode($categoria),utf8_decode($material),));
}
// //Mostramos el documento pdf
$pdf->Output();
}else{
 echo "NO TIENES LOS PERMISOS NECESARIOS PARA VISUALIZAR EL REPORTE";
}
}
ob_end_flush();
?>