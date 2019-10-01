<?php
//iniciamos la sesion para poder usar las variables de sesion

if(strlen(session_id())<1)
session_start();
require_once "../models/Ventas.php";

$venta= new venta();
//valores de tabla venta
$id_venta = isset($_POST['id_venta']) ? limpiarCadena($_POST['id_venta']) : "";
$cliente_id = isset($_POST['cliente_id']) ? limpiarCadena($_POST['cliente_id']) : "";
$usuario_id = $_SESSION['id_usuario'];
$tipocomprobante = isset($_POST['tipocomprobante']) ? limpiarCadena($_POST['tipocomprobante']) : "";
$serie = isset($_POST['serie']) ? limpiarCadena($_POST['serie']) : "";
$codigo = isset($_POST['codigo']) ? limpiarCadena($_POST['codigo']) : "";
$fecha_venta = isset($_POST['fecha_venta']) ? limpiarCadena($_POST['fecha_venta']) : "";
$impuesto=isset($_POST['impuesto']) ? limpiarCadena($_POST['impuesto']) : "";
$tipo_pago=isset($_POST['tipo_pago']) ? limpiarCadena($_POST['tipo_pago']) : "";
$cantidadCuotas = isset($_POST['nro_cuotas']) ? limpiarCadena($_POST['nro_cuotas']) : "";
$monto_total=isset($_POST['total_compra']) ? limpiarCadena($_POST['total_compra']) : "";

//
switch ($_GET['op']) {
    case 'guardaryeditar':
        if(empty($id_compra)){
            if(isset($_POST['fecha_envio']) && !empty($_POST['fecha_envio'])){
                $fecha_envio=isset($_POST['fecha_envio']) ? limpiarCadena($_POST['fecha_envio']) : "";
                $hora_envio=isset($_POST['hora_envio']) ? limpiarCadena($_POST['hora_envio']) : "";
                $monto_envio=isset($_POST['monto_envio']) ? limpiarCadena($_POST['monto_envio']) : "";
                $pago_envio=isset($_POST['pago_envio']) ? limpiarCadena($_POST['pago_envio']) : "";
                $id_contacto=isset($_POST['id_contacto_enviar']) ? limpiarCadena($_POST['id_contacto_enviar']) : "";;
                $id_direccion=isset($_POST['id_direccion_enviar']) ? limpiarCadena($_POST['id_direccion_enviar']) : "";
                   
                $respuesta = $venta->insertarConEnvio($tipocomprobante,$serie,$codigo,$cliente_id,$usuario_id,$fecha_venta,$impuesto,$tipo_pago,$cantidadCuotas,$monto_total,$_POST['producto_id'],$_POST['cantidad'],$_POST['precio_venta'],$_POST['descuento'],$_POST['interes'],$fecha_envio,$hora_envio,$monto_envio,$pago_envio,$id_contacto,$id_direccion);
                echo $respuesta ? "1" : "0";
            }else{
                $respuesta = $venta->insertar($tipocomprobante,$serie,$codigo,$cliente_id,$usuario_id,$fecha_venta,$impuesto,$tipo_pago,$cantidadCuotas,$monto_total,$_POST['producto_id'],$_POST['cantidad'],$_POST['precio_venta'],$_POST['descuento'],$_POST['interes']);
                            echo $respuesta ? "1" : "0";
            }    
        }else{

        }
        break;
    case 'anular':
        $respuesta = $venta->anular($id_venta);
        echo $respuesta ? "1" : "0" ;
        break;
    case 'mostrar':
        $respuesta=$venta->mostrar($id_venta);
        echo json_encode($respuesta);
        break;
    case 'mostrarDetalles':
        //recibimos el id de la venta
        $id= $_GET['id'];
        $total=0;
        $respuesta= $venta->listarDetalles($id);
            echo ' <thead style="background-color:#F39C12" style="text-align:center">
                <th style="text-align:center">Opciones</th>
                <th style="text-align:center"h>Producto</th>
                <th style="text-align:center">Cantidad</th>
                <th style="text-align:center">Precio Venta</th>
                <th style="text-align:center">Descuento</th>
                <th style="text-align:center">interes</th>
                <th style="text-align:center">Subtotal</th>
                </thead>';
        while($reg = $respuesta->fetch_object()){
            $subtotal=$reg->cantidad * $reg->precio_venta - $reg->descuento;
            $total = $total + $subtotal;
            
            echo '<tr class="filas" style="text-align:center">'.
            '<td></td>'.
            '<td>'.$reg->descripcion.'</td>'.
            '<td>'.$reg->cantidad.'</td>'.
            '<td>'.$reg->precio_venta.'</td>'.
            '<td>'.$reg->descuento.'</td>'.
            '<td>'.$reg->interes.'</td>'.
            '<td>'.$subtotal.'</td>'.
            '</tr>';
        }
        echo ' <tfoot>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><p id="total" style="font-size:20px">$ '.$total.'</p><input type="hidden" name="total_compra" id="total_compra"></th>
        </tfoot>';
    break; 
    case 'listar':
        $respuesta = $venta->listar();
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            if($reg->tipo_pago =="tarjeta"){
                $url = '../reportes/exTicket.php?id='.$reg->id_factura;
            }else{

            }
            $newDate = date("d-m-Y", strtotime($reg->fecha_venta));
            $data[]= array(
                "0" =>($reg->estado =='aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_factura.')"><i class="fa fa-eye"></i></button>'. ' <button class="btn btn-danger" onclick="anular('.$reg->id_factura.')"><i class="fa fa-close"></i></button>'.' <button class="btn btn-info" onclick="imprimir('.$reg->id_factura.',\''.$reg->tipo_pago.'\')"><i class="fa fa-print"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_factura.')"><i class="fa fa-eye"></i></button>',
                "1"=>$newDate,
                "2"=>$reg->nombre_cliente.' '. $reg->apellido_cliente,
                "3"=>$reg->nombre_usuario,
                "4"=>$reg->tipo_comprobante,
                "5"=>$reg->serie.' - '. $reg->codigo,
                "6"=>$reg->tipo_pago,
                "7"=>$reg->monto_total,
                "8"=>($reg->estado=='aceptado') ? '<span class="label bg-green">ACEPTADO<span>' : '<span class="label bg-red" >ANULADO<span>',
            );
        }
        $result = array(
            "sEcho" =>1, //Informacion para el data table
            "iTotalRecords"=>count($data), //enviamos el total de registros al data table
            "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
            "aaData"=>$data //aca se encuentra almacenado todos los registros
        );
        echo json_encode($result);
    break;
    case 'selectCliente':
        require_once "../models/Clientes.php";
        $cliente = new Cliente();
        $respuestaSelect = $cliente->selectCliente();
        echo '<option value="">Seleccionar...</option><option value="7">CONSUMIDOR FINAL</option>';
        while($reg = $respuestaSelect->fetch_object())
        {
            echo '<option style="text-transform:uppercase;" value="'.$reg->id_clientes.'"> '.$reg->apellidos.' '.$reg->nombres.' | DNI: '.$reg->nro_doc.'</option>';
        }
    break;
    case 'ultimocodigo':
        $respuesta=$venta->mandarUltCodySerie();
        echo json_encode($respuesta);
    break;
    case 'listarProductos':
    require_once "../models/Producto.php";
    $producto = new Producto();
    $respuesta = $producto->listarActivosVenta();
    $data = array();
    while($reg = $respuesta->fetch_object())
    {   
            if($reg->imagen_producto){
                $mostrarimagen = '<div style="height:50px;width:50px;float:left;padding:3px 53px 53px 3px;background-color:gray; margin-right:5px;border-radius: 5px;">
                <img src="../files/images/productos/'.$reg->imagen_producto.'" height="50" width="50"></div> ';
            }else{
                $mostrarimagen= "No hay Imagen Para Mostrar";
            };
        $data[]=array(
         
            "0"=>'<button class="btn btn-warning" id="agregarP'.$reg->id_producto.'"  onclick="agregardetalle('.$reg->id_producto.',\''.$reg->descripcion.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"><span></button><button type="button" id="mostrarP'.$reg->id_producto.'" style="display:none" class="btn btn-success"><span class="fa fa-check"></span></button>',
            "1"=>$reg->cod_producto,
            "2"=>$reg->descripcion,
            "3"=>$reg->stock,
            "4"=>$reg->nombre_material,
            "5"=>$reg->nombre_categoria,
            "6"=>'$ '.$reg->precio_venta,
            "7"=>$mostrarimagen
        );
    }
    $results = array(
        "sEcho" =>1, //Informacion para el data table
        "iTotalRecords"=>count($data), //enviamos el total de registros al data table
        "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
        "aaData"=>$data //aca se encuentra almacenado todos los registros
    );
    echo json_encode($results);//devolvemos en json el ultimo array y sera utilizado por el data table
    break;
    case 'ultimaFactura':
    $id=$_POST['id_user'];
    $respuesta=$venta->ultimaFacturaUser($id);
    echo json_encode($respuesta);
    break;
    case 'consultaDirTel':
        $id_cliente= $_POST['id_cliente'];
        $respuesta = $venta->consultaDirTel($id_cliente);
        echo json_encode($respuesta);
    break;
    case 'traerContactoCliente':
        $id_cliente = $_GET['id_cliente'];
        $respuesta = $venta->selectContactoEnvio($id_cliente);
        $data = array();
        while($reg = $respuesta->fetch_object())
        {   
            $data[]=array(
                "0"=>'<button class="btn btn-warning botn-agregarC" id="agregarC'.$reg->id_contacto.'"  onclick="agregarContacto('.$reg->id_contacto.')"><span class="fa fa-plus"><span></button><button type="button" id="mostrarC'.$reg->id_contacto.'"  style="display:none" class="btn btn-success botn-mostrarC"><span class="fa fa-check"></span></button>',
                "1"=>$reg->telefono,
                "2"=>$reg->celular,
            );
        }
        $results = array(
            "sEcho" =>1, //Informacion para el data table
            "iTotalRecords"=>count($data), //enviamos el total de registros al data table
            "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
            "aaData"=>$data //aca se encuentra almacenado todos los registros
        );
        echo json_encode($results);//devolvemos en json
    break;
    case 'traerDireccionCliente':
    $id_cliente = $_GET['id_cliente'];
    $respuesta = $venta->selectDireccionEnvio($id_cliente);
    $data = array();
    while($reg = $respuesta->fetch_object())
    {   
        $data[]=array(
            "0"=>'<button class="btn btn-warning botn-agregarD" id="agregarD'.$reg->id_direccion.'"  onclick="agregarDireccion('.$reg->id_direccion.')"><span class="fa fa-plus"><span></button><button type="button" id="mostrarD'.$reg->id_direccion.'"  style="display:none" class="btn btn-success botn-mostrarD"><span class="fa fa-check"></span></button>',
            "1"=>$reg->provincia,
            "2"=>$reg->localidad,
            "3"=>$reg->barrio,
            "4"=>$reg->calle,
            "5"=>$reg->altura,
            "6"=>$reg->manzana,
            "7"=>$reg->nro_piso,
            "8"=>$reg->nro_dpto,
            "9"=>$reg->info_add
        );
    }
    $results = array(
        "sEcho" =>1, //Informacion para el data table
        "iTotalRecords"=>count($data), //enviamos el total de registros al data table
        "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
        "aaData"=>$data //aca se encuentra almacenado todos los registros
    );
    echo json_encode($results);//devolvemos en json
break;
}
?>