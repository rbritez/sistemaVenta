<?php
//iniciamos la sesion para poder usar las variables de sesion

if(strlen(session_id())<1)
session_start();
require_once "../models/Compras.php";

$compra= new Compra();
//valores de tabla compra
$id_compra = isset($_POST['id_compra']) ? limpiarCadena($_POST['id_compra']) : "";
$proveedor_id = isset($_POST['proveedor_id']) ? limpiarCadena($_POST['proveedor_id']) : "";
$usuario_id = $_SESSION['id_usuario'];
$tipocomprobante = isset($_POST['tipocomprobante']) ? limpiarCadena($_POST['tipocomprobante']) : "";
$serie = isset($_POST['serie']) ? limpiarCadena($_POST['serie']) : "";
$numcomprobante = isset($_POST['numcomprobante']) ? limpiarCadena($_POST['numcomprobante']) : "";
$fecha_compra = isset($_POST['fecha_compra']) ? limpiarCadena($_POST['fecha_compra']) : "";
$impuesto=isset($_POST['impuesto']) ? limpiarCadena($_POST['impuesto']) : "";
$total_compra=isset($_POST['total_compra']) ? limpiarCadena($_POST['total_compra']) : "";

//
switch ($_GET['op']) {
    case 'guardaryeditar':
        if(empty($id_compra)){
            $respuesta = $compra->insertar($proveedor_id,$usuario_id,$tipocomprobante,$serie,$numcomprobante,$fecha_compra,$impuesto,$total_compra,$_POST['producto_id'],$_POST['cantidad'],$_POST['precio_compra'],$_POST['precio_venta']);
            echo $respuesta ? "1" : "0";

        }else{

        }
        break;
    case 'anular':
        $respuesta = $compra->anular($id_compra);
        echo $respuesta ? "1" : "0" ;
        break;
    case 'mostrar':
        $respuesta=$compra->mostrar($id_compra);
        echo json_encode($respuesta);
        break;
    case 'mostrarDetalles':
        //recibimos el id de la compra
        $id= $_GET['id'];
        $total=0;
        $respuesta= $compra->listarDetalles($id);
            echo ' <thead style="background-color:#F39C12">
            <th id="opciones">Opciones</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Subtotal</th>   
            </thead>';
        while($reg = $respuesta->fetch_object()){
            $subtotal=$reg->cantidad * $reg->precio_compra;
            $total = $total + $subtotal;
           
            echo '<tr class="filas" style="text-align:center">'.
            '<td id="TD_opciones"></td>'.
            '<td>'.$reg->descripcion.'</td>'.
            '<td>'.$reg->cantidad.'</td>'.
            '<td>'.$reg->precio_compra.'</td>'.
            '<td>'.$reg->precio_venta.'</td>'.
            '<td>'.$subtotal.'</td>'.
            '</tr>';
        }
        echo ' <tfoot>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><p id="total" style="font-size:20px">$ '.$total.'</p><input type="hidden" name="total_compra" id="total_compra"></th>
        </tfoot>';

    break; 
    case 'listar':
        $respuesta = $compra->listar();
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $data[]= array(
                "0" =>($reg->estado =='aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_compra.')"><i class="fa fa-eye"></i></button>'. ' <button class="btn btn-danger" onclick="anular('.$reg->id_compra.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_compra.')"><i class="fa fa-eye"></i></button>',
                "1"=>$reg->fecha,
                "2"=>$reg->nombre_proveedor.' '. $reg->apellido_proveedor,
                "3"=>$reg->nombre_usuario,
                "4"=>$reg->tipocomprobante,
                "5"=>$reg->serie.' - '. $reg->numcomprobante,
                "6"=>$reg->total_compra,
                "7"=>($reg->estado=='aceptado') ? '<span class="label bg-green">ACEPTADO<span>' : '<span class="label bg-red" >ANULADO<span>',
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
    case 'selectProveedor':
        require_once "../models/Proveedores.php";
        $proveedor = new Proveedor();
        $respuestaSelect = $proveedor->selectProveedor();
        while($reg = $respuestaSelect->fetch_object())
        {
            echo '<option style="text-transform:uppercase;" value="'.$reg->id_proveedor.'">'.$reg->razon_social.' | '.$reg->nombres.' '.$reg->apellidos.'</option>';
        }
    break;
    case 'listarProductos':
    require_once "../models/Producto.php";
    $producto = new Producto();
    $respuesta = $producto->listarActivos();
    $data = array();
    while($reg = $respuesta->fetch_object())
    {
        $data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregardetalle('.$reg->id_producto.',\''.$reg->descripcion.'\')"><span class="fa fa-plus"><span></button>',
            "1"=>$reg->cod_producto,
            "2"=>$reg->descripcion,
            "3"=>$reg->stock,
            "4"=>$reg->material_id,
            "5"=>$reg->categoria_id,
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