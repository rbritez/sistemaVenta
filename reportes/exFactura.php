<?php
if(strlen(session_id())< 1 )
    session_start();
if(!isset($_SESSION["nombres"])){
    echo "POR FAVOR INICIA SESION DE LA MANERA CORRECTA";
}else{
    //verificamos si tiene acceso al modulo
if($_SESSION['ventas'] == 1){
//Incluímos el archivo Factura.php
require('Factura.php');

//Establecemos los datos de la empresa
$logo = "logo.png";
$ext_logo = "png";
$empresa = "Formosa Aberturas";
$documento = "20-26715747-2";
$direccion = "Av 25 de Mayo 1290";
$provincia = "Formosa";
$localidad="Ciudad de Formosa";
$telefono = "931742904";


//Obtenemos los datos de la cabecera de la venta actual
require_once "../models/Ventas.php";
$venta= new Venta();
$rsptav = $venta->ventaCabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();
$email = ucwords($regv->nombre_usuario).' '.ucwords($regv->apellidos_usuario);
$newDate = date("d/m/Y", strtotime($regv->fecha));
//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("Dirección: ").utf8_decode($direccion)."\n".
                  utf8_decode("Teléfono: ").$telefono."\n" .utf8_decode("Provincia: ").$provincia."\n" .utf8_decode("Localidad: ").$localidad."\n" .
                  "Vendedor : ".$email,$logo,$ext_logo);
$pdf->fact_dev( "FACTURA TIPO: "."$regv->tipo_comprobante ");
$pdf->favser("SERIE: "."$regv->serie - $regv->codigo");
$pdf->temporaire( "" );
$pdf->addDate( $newDate);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse(utf8_decode($regv->nombre_cliente.' '.$regv->apellido_cliente),"Domicilio: ".utf8_decode(''),"DNI: ".$regv->nro_doc,"Email: "."Telefono: ".$regv->telefono);

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             "P.U."=>25,
             "DSCTO"=>20,
             "SUBTOTAL"=>22);
$pdf->addCols( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             "P.U."=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 89;

//Obtenemos todos los detalles de la venta actual
$rsptad = $venta->ventadetalle($_GET["id"]);

while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=> "$regd->cod_producto",
                "DESCRIPCION"=> utf8_decode("$regd->descripcion"),
                "CANTIDAD"=> "$regd->cantidad",
                "P.U."=> "$regd->precio_venta",
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL"=> "$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}

//Convertimos el total en letras
require_once "Letras.php";
$con_letra=strtoupper(valorEnLetras($regv->total_venta));
$pdf->addCadreTVAs("---".$con_letra);

//Mostramos el impuesto
$pdf->addTVAs( $regv->impuesto, $regv->total_venta,"S/ ");
$pdf->addCadreEurosFrancs("IVA"." $regv->impuesto %");
$pdf->Output('Reporte de Venta','I');
}else{
  echo "NO TIENES LOS PERMISOS NECESARIOS PARA VISUALIZAR EL REPORTE";
 }
 }
 ob_end_flush();
 ?>