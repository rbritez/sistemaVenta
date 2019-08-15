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
$monto_total=isset($_POST['total_compra']) ? limpiarCadena($_POST['total_compra']) : "";

//
switch ($_GET['op']) {
    case 'guardaryeditar':
        if(empty($id_compra)){
            $respuesta = $venta->insertar($tipocomprobante,$serie,$codigo,$cliente_id,$usuario_id,$fecha_venta,$impuesto,$tipo_pago,$monto_total,$_POST['producto_id'],$_POST['cantidad'],$_POST['precio_venta'],$_POST['descuento'],$_POST['interes']);
            echo $respuesta ? "1" : "0";
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
        while($reg = $respuesta->fetch_object()){
            $subtotal=$reg->cantidad * $reg->precio_venta;
            $total = $total + $subtotal;
            echo ' <thead style="background-color:#F39C12" style="text-align:center">
            <th style="text-align:center">Opciones</th>
            <t style="text-align:center"h>Producto</th>
            <th style="text-align:center">Cantidad</th>
            <th style="text-align:center">Precio Venta</th>
            <th style="text-align:center">Descuento</th>
            <th style="text-align:center">interes</th>
            <th style="text-align:center">Subtotal</th>
            </thead>';
            echo '<tr class="filas" style="text-align:center">'.
            '<td id="TD_opciones"></td>'.
            '<td>'.$reg->descripcion.'</td>'.
            '<td>'.$reg->cantidad.'</td>'.
            '<td>'.$reg->precio_compra.'</td>'.
            '<td>'.$reg->precio_venta.'</td>'.
            '<td>'.$subtotal.'</td>'.
            '</tr>';
            echo ' <tfoot>
            <th>TOTAL</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><p id="total" style="font-size:20px">$ '.$total.'</p><input type="hidden" name="total_compra" id="total_compra"></th>
            </tfoot>';
        }
    break; 
    case 'listar':
        $respuesta = $venta->listar();
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $data[]= array(
                "0" =>($reg->estado =='aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_factura.')"><i class="fa fa-eye"></i></button>'. ' <button class="btn btn-danger" onclick="anular('.$reg->id_factura.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_factura.')"><i class="fa fa-eye"></i></button>',
                "1"=>$reg->fecha_venta,
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
        while($reg = $respuestaSelect->fetch_object())
        {
            echo '<option style="text-transform:uppercase;" value="'.$reg->id_clientes.'">'.$reg->nombres.' '.$reg->apellidos.'</option>';
        }
    break;
    case 'listarProductos':
    require_once "../models/Producto.php";
    $producto = new Producto();
    $respuesta = $producto->listarActivosVenta();
    $data = array();
    while($reg = $respuesta->fetch_object())
    {
        $data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregardetalle('.$reg->id_producto.',\''.$reg->descripcion.'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus"><span></button>',
            "1"=>$reg->cod_producto,
            "2"=>$reg->descripcion,
            "3"=>$reg->stock,
            "4"=>$reg->nombre_material,
            "5"=>$reg->nombre_categoria,
            "6"=>'$ '.$reg->precio_venta,
            "7"=>'<div style="height:50px;width:50px;float:left;padding:3px 53px 53px 3px;background-color:gray; margin-right:5px;border-radius: 5px;">
                <img src="../files/images/productos/'.$reg->imagen_producto.'" height="50" width="50"></div> '
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
}
?>