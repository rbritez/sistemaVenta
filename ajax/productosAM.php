<?php
require_once "../models/productosAM.php";
//creamos el objeto categoria usando el constructor de categoria
$productoAM = new ProductoAM();
//Declaramos las variables que se utilizaran en el modelo MVC
//Primero validamos la existenia de la variable con isset
// Si existe el el objeto idcategoria y lo recibo por el metodo POST 
// Si existe Lo que tenga el objeto lo validamos con limpiarcadena
//si no existe lo dejo en cadena de texto vacia.
//lo mismo para los siguientes objetos
$id_productomedida = isset($_POST["id_prod_medida"])? limpiarCadena($_POST["id_prod_medida"]): "" ;
$cfilas= isset($_POST["cfilas"])? limpiarCadena($_POST["cfilas"]): "";
$fecha_p= isset($_POST["fecha_p"])? limpiarCadena($_POST["fecha_p"]): "";
$cliente_id= isset($_POST["cliente_id"])? limpiarCadena($_POST["cliente_id"]): "";


switch($_GET["op"]){
    case 'guardaryeditar' :
        if(empty($id_productomedida)){
            $respuesta = $productoAM->insertar($cliente_id,$fecha_p,$_POST['cantidad'],$_POST['alto'],$_POST['ancho'],$_POST['prof'],$_POST['info_add'],$_POST['material_id'],$_POST['categoria_id']);
            echo $respuesta ? "1" : "0"; //si respuesta es igual a 1 enviar 1 , si es igual a 0 enviar 0. $respuesta recibe 1 si fue exitoso o 0 si hubo error.
        }else{
            $respuesta = $productoAM->editar($id_productomedida,$_POST['cantidad'],$_POST['alto'],$_POST['ancho'],$_POST['prof'],$_POST['fecha_p'],$_POST['info_add'],$_POST['cliente_id'],$_POST['material_id'],$_POST['categoria_id']);
            echo $respuesta ? "2" : "3";
        }
    break;

    case 'activar' :
        $respuesta = $productoAM->activar($id_productomedida);
        echo $respuesta ? "1" : "0";
    break;
    case 'desactivar' :
        $respuesta = $productoAM->desactivar($id_productomedida);
        echo $respuesta ? "1" : "0";
    break;

    case 'mostrar' :
        $respuesta = $productoAM->mostrar($id_productomedida);
        //Codificar el resultado con JSON
        echo json_encode($respuesta);
    break;
    case 'mostrarDetalles':
    //recibimos el id de la venta
    $id= $_GET['idp'];
    $prof = "";
    $respuesta= $productoAM->listarDetalles($id);
        echo '  <thead style="background-color:#F39C12" style="text-align:center">
        <th style="text-align:center" >Opciones</th>
        <th style="text-align:center" >Cantidad</th>
        <th style="text-align:center" >Alto</th>
        <th style="text-align:center" >Ancho</th>
        <th style="text-align:center" >Profundidad</th>
        <th style="text-align:center" >Material</th>
        <th style="text-align:center" >Categoria</th>
        <th style="text-align:center" >Información Adicional</th>
    </thead>';
    while($reg = $respuesta->fetch_object()){
        if($reg->profundidad == 0.00){
            $prof = "--NO DEFINIDO--"; 
        }else{
            $prof = $reg->profundidad;
        }

        echo '<tr class="filas" style="text-align:center">'.
        '<td></td>'.
        '<td>'.$reg->cantidad.'</td>'.
        '<td>'.$reg->alto.'</td>'.
        '<td>'.$reg->ancho.'</td>'.
        '<td>'.$prof.'</td>'.
        '<td>'.$reg->nombre_material.'</td>'.
        '<td>'.$reg->nombre_categoria.'</td>'.
        '<td>'.$reg->info_add.'</td>'.
        '</tr>';
    }
break; 

    case 'listar' :
        $respuesta = $productoAM->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $newDate = date("d-m-Y", strtotime($reg->fecha_pedido));
            if($reg->fecha_aviso){
                $dateAviso = date("d-m-Y", strtotime($reg->fecha_aviso));
            }else{
                $dateAviso = "AÚN SIN CONFIRMAR " ;
            }
            if($reg->condicion == 1){
                $estcondicion = '<span class="label bg-orange-active">En espera</span>';
            }else if($reg->condicion == 2){
                $estcondicion = '<span class="label bg-green-active">Avisado</span>';
            }else{
                $estcondicion = '<span class="label bg-red-active">HAN PASADO '.$reg->condicion.' DIAS SIN AVISAR</span>';
            }
            $data[] = array(
                "0"=>($reg->condicion == 2)?'<button class="btn btn-info" onclick="mostrar('.$reg->id_prod_medida.')"><i class="fa fa-eye"></i></button> '. ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_prod_medida.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-info" onclick="mostrar('.$reg->id_prod_medida.')"><i class="fa fa-eye"></i></button> '. ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_prod_medida.')"><i class="fa fa-close"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_prod_medida.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->apellidos.' '.$reg->nombres,
                "2"=>$newDate,
                "3"=>$dateAviso,
                "4"=>$estcondicion,
                "5"=>($reg->estado)?'<span class="label bg-green-active">Activo</span>':'<span class="label bg-red-active">Inactivo</span>',
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
