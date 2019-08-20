<?php
if(strlen(session_id())< 1 )
    session_start();
if(!isset($_SESSION["nombres"])){
    echo "POR FAVOR INICIA SESION DE LA MANERA CORRECTA";
}else{
    //verificamos si tiene acceso al modulo
if($_SESSION['ventas'] == 1){
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../models/Ventas.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->ventaCabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = "Formosa Aberturas ";
$documento = "20-26715747-2";
$direccion = "Av 25 de Mayo N°1295";
$telefono = "TEL: 4437915";
$email = "jcarlos.ad7@gmail.com";

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        </td>
    </tr>
    <tr>
        <td align="center"><?php echo $newDate = date("d/m/Y", strtotime($reg->fecha)); ?></td>
    </tr>
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Cliente: <?php echo $reg->nombre_cliente.' '. $reg->apellido_cliente; ?></td>
    </tr>
    <tr>
        <td><?php echo "DNI: ".$reg->nro_doc; ?></td>
    </tr>
    <tr>
        <td>Nº de venta: <?php echo $reg->serie." - ".$reg->codigo ; ?></td>
    </tr>    
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="300px">
    <tr>
        <td>CANT.</td>
        <td>DESCRIPCIÓN</td>
        <td align="right">IMPORTE</td>
    </tr>
    <tr>
      <td colspan="3">==========================================</td>
    </tr>
    <?php
    $rsptad = $venta->ventadetalle($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".$regd->cantidad."</td>";
        echo "<td>".$regd->descripcion;
        echo "<td align='right'>S/ ".$regd->subtotal."</td>";
        echo "</tr>";
        $cantidad+=$regd->cantidad;
    }
    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL:</b></td>
    <td align="right"><b>S/  <?php echo $reg->total_venta;  ?></b></td>
    </tr>
    <tr>
      <td colspan="3">Nº de artículos: <?php echo $cantidad; ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>      
    <tr>
      <td colspan="3" align="center">¡Gracias por su compra!</td>
    </tr>
    <tr>
      <td colspan="3" align="center">Ustd. fue atendido por : <?php echo ucwords($reg->nombre_usuario).' '.ucwords($reg->apellidos_usuario);?></td>
    </tr>
    <tr>
      <td colspan="3" align="center">Formosa - Argentina</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}else{
  echo "NO TIENES LOS PERMISOS NECESARIOS PARA VISUALIZAR EL REPORTE";
 }
 }
 ob_end_flush();
 ?>