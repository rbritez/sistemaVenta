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
</head>
<body onload="window.print();">
<?php
//Incluímos la clase Venta
require_once "../models/Cuenta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Cuenta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->encabezadoFacturaCuota($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = "Formosa Aberturas ";
$documento = "20-26715747-2";
$direccion = "Av 25 de Mayo N°1295";
$telefono = "TEL: 4437915";
$email = "julioG_77@gmail.com";

?>
<table style="border: 1px solid black;border-radius:10px;">
<tr>
<td>
<table width="900px"  align="center" >
    <tr>
        <td style="padding-right:0px;margin-right:0px"><img src="formosaaberturas.jpg" alt="formosaaberturas" width="250px" style="margin:0px;padding:0px;"></td>
        <td style="padding:0px 32px 0px 32px" align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        </td>
        <td align="center" style="padding:0px 32px 0px 32px;"><p style=" border: 1px solid black;border-radius:10px; padding:10px;"><b>FECHA: </b><?php echo $newDate = date("d-m-Y", strtotime($reg->fecha)); ?></ap></td>
    </tr>    
</table>
<table align="center" width="800px">
    <tbody>
    <tr>
        <td><b>DATOS DEL CLIENTE:</b></td>
    </tr>
    <tr>
        <td><b>NOMBRE Y APELLIDO: </b> <?php echo $reg->nombre_cliente.' '. $reg->apellido_cliente; ?></td>
        <td><?php echo "<b>DNI: </b> ".$reg->documento_cliente; ?></td>
    </tr>
    <tr>
        <td><b>N° DE CLIENTE: </b><?php echo $reg->id_cliente?></td>
        <td><b>N° DE CUENTA: </b><?php echo $reg->id_cuenta?></td>
    </tr>
    </tbody>
</table>
<br>
<table align="center" width="700px" style="border-radius:10px; border:1px solid black;">
        <thead align="center">
        <th>COD. PRODUCTO</th>
        <th>DESCRIPCION</th>
        <th>CANTIDAD</th>
        </thead>
        <tbody align="center">
        <?php
            $rsptad = $venta->mostrardetalleProducto($_GET["id"]);
            while ($regd = $rsptad->fetch_object()) {
                echo "<tr>";
                echo "<td>".$regd->cod_producto."</td>";
                echo "<td>".$regd->descripcion."</td>";
                echo "<td> ".$regd->cantidad."</td>";
                echo "</tr>"; 
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
    <table align="center" width="700px" style="border-radius:10px; border:1px solid black;">
        <thead>
            <th>FECHA VTO.</th>
            <th>CUOTA</th>
            <th>IMPORTE</th>
            <th>INTERES</th>
            <th>SUBTOTAL</th>
        </thead>
        <tbody align="center">
        <?php
            $rsptad = $venta->mostrardetalleCuota($_GET["id"]);
            $total = 0;
            while ($regd = $rsptad->fetch_object()) {
                $newDate1 = date("d-m-Y", strtotime($regd
                ->fecha_v));
                echo "<tr>";
                echo "<td>".$newDate1."</td>";
                echo "<td>".$regd->nro_cuota.'/'.$regd->total_cuotas."</td>";
                echo "<td>$ ".$regd->monto."</td>";
                echo "<td>$ ".$regd->interes."</td>";
                echo "<td>$ ".$regd->subtotal."</td>";
                echo "</tr>";
                $total += $regd->subtotal; 
            }
            ?>
            <!-- Mostramos los totales de la venta en el documento HTML -->
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center"><b>TOTAL:</b></td>
                <td align="center"><b>$  <?php echo $total;  ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table align="center" width="700px">
        <tbody>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>      
        <tr>
            <td colspan="3" align="center">¡Gracias por su Pago!</td>
        </tr>
        <tr>
            <td colspan="3" align="center">Ustd. fue atendido por : <?php echo ucwords($reg->nombre_usuario).' '.ucwords($reg->apellido_usuario);?></td>
        </tr>
        <tr>
            <td colspan="3" align="center">Formosa - Argentina</td>
        </tr>
        <tr>
            <td colspan="3" align="center">Comprobante para el Cliente</td>
        </tr>
        </tbody>
        </td>
        </tr>
    </table>
</table>
<!-- codigo imprimir -->
<br/>
<br/>
    <hr size="3">
<br/>
<br/>
<table style="border: 1px solid black;border-radius:10px;">
<tr>
<td>
<table width="900px"  align="center" >
    <tr>
        <td style="padding-right:0px;margin-right:0px"><img src="formosaaberturas.jpg" alt="formosaaberturas" width="250px" style="margin:0px;padding:0px;"></td>
        <td style="padding:0px 32px 0px 32px" align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        </td>
        <td align="center" style="padding:0px 32px 0px 32px;"><p style=" border: 1px solid black;border-radius:10px; padding:10px;"><b>FECHA: </b><?php echo $newDate = date("d-m-Y", strtotime($reg->fecha)); ?></ap></td>
    </tr>    
</table>
<table align="center" width="800px">
    <tbody>
    <tr>
        <td><b>DATOS DEL CLIENTE:</b></td>
    </tr>
    <tr>
        <td><b>NOMBRE Y APELLIDO: </b> <?php echo $reg->nombre_cliente.' '. $reg->apellido_cliente; ?></td>
        <td><?php echo "<b>DNI: </b> ".$reg->documento_cliente; ?></td>
    </tr>
    <tr>
        <td><b>N° DE CLIENTE: </b><?php echo $reg->id_cliente?></td>
        <td><b>N° DE CUENTA: </b><?php echo $reg->id_cuenta?></td>
    </tr>
    </tbody>
</table>
<br>
<table align="center" width="700px" style="border-radius:10px; border:1px solid black;">
        <thead align="center">
        <th>COD. PRODUCTO</th>
        <th>DESCRIPCION</th>
        <th>CANTIDAD</th>
        </thead>
        <tbody align="center">
        <?php
            $rsptad = $venta->mostrardetalleProducto($_GET["id"]);
            while ($regd = $rsptad->fetch_object()) {
                echo "<tr>";
                echo "<td>".$regd->cod_producto."</td>";
                echo "<td>".$regd->descripcion."</td>";
                echo "<td> ".$regd->cantidad."</td>";
                echo "</tr>"; 
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
    <table align="center" width="700px" style="border-radius:10px; border:1px solid black;">
        <thead>
            <th>FECHA VTO.</th>
            <th>CUOTA</th>
            <th>IMPORTE</th>
            <th>INTERES</th>
            <th>SUBTOTAL</th>
        </thead>
        <tbody align="center">
        <?php
            $rsptad = $venta->mostrardetalleCuota($_GET["id"]);
            $total = 0;
            while ($regd = $rsptad->fetch_object()) {
                $newDate1 = date("d-m-Y", strtotime($regd
                ->fecha_v));
                echo "<tr>";
                echo "<td>".$newDate1."</td>";
                echo "<td>".$regd->nro_cuota.'/'.$regd->total_cuotas."</td>";
                echo "<td>$ ".$regd->monto."</td>";
                echo "<td>$ ".$regd->interes."</td>";
                echo "<td>$ ".$regd->subtotal."</td>";
                echo "</tr>";
                $total += $regd->subtotal; 
            }
            ?>
            <!-- Mostramos los totales de la venta en el documento HTML -->
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center"><b>TOTAL:</b></td>
                <td align="center"><b>$  <?php echo $total;  ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br/>
    <table align="center" width="700px">
        <tbody>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>      
        <tr>
            <td colspan="3" align="center">¡Gracias por su Pago!</td>
        </tr>
        <tr>
            <td colspan="3" align="center">Ustd. fue atendido por : <?php echo ucwords($reg->nombre_usuario).' '.ucwords($reg->apellido_usuario);?></td>
        </tr>
        <tr>
            <td colspan="3" align="center">Formosa - Argentina</td>
        </tr>
        <tr>
            <td colspan="3" align="center">Comprobante para el Comercio</td>
        </tr>
        </tbody>
        </td>
        </tr>
    </table>
</table>
</body>
</html>
<?php 
}else{
  echo "NO TIENES LOS PERMISOS NECESARIOS PARA VISUALIZAR EL REPORTE";
 }
 }
 ob_end_flush();
 ?>