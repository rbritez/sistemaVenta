<?php
require_once "../models/Envios.php";
//creamos el objeto categoria usando el constructor de categoria
$envio = new Envio();
//Declaramos las variables que se utilizaran en el modelo MVC
//Primero validamos la existenia de la variable con isset
// Si existe el el objeto idenvio y lo recibo por el metodo POST 
// Si existe Lo que tenga el objeto lo validamos con limpiarcadena
//si no existe lo dejo en cadena de texto vacia.
//lo mismo para los siguientes objetos
 $idenvio = isset($_POST["id_envio"])? limpiarCadena($_POST["id_envio"]): "" ;
// $nombre_envio= isset($_POST["nombre_envio"])? limpiarCadena($_POST["nombre_envio"]): "";


switch($_GET["op"]){
    case 'guardaryeditar' :
        if(empty($idcategoria)){
            $respuesta = $categoria->insertar($nombre_categoria);
            echo $respuesta ? "1" : "0"; //si respuesta es igual a 1 enviar 1 , si es igual a 0 enviar 0. $respuesta recibe 1 si fue exitoso o 0 si hubo error.
        }else{
            $respuesta = $categoria->editar($idcategoria,$nombre_categoria);
            echo $respuesta ? "2" : "3";
        }
    break;

    case 'activar' :
        $respuesta = $envio->activar($idenvio);
        echo $respuesta ?"1" : "0";
    break;
    case 'desactivar' :
        $respuesta = $envio->desactivar($idenvio);
        echo $respuesta ? "1" : "0";
    break;

    case 'mostrar' :
        $respuesta = $categoria->mostrar($idcategoria);
        //Codificar el resultado con JSON
        echo json_encode($respuesta);
    break;

    case 'listar' :
        $respuesta = $envio->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $newDate = date("d-m-Y", strtotime($reg->fecha_envio));
            if($reg->fh_entrega){
                $newDate1 = date("d-m-Y H:i", strtotime($reg->fh_entrega));
                $entregado = $newDate1;
            }else{
                $entregado = 'ENVIO AÚN NO REALIZADO';
            }
            if($reg->estado_conf == 1){
                $confi = '<span class="label bg-orange-active">PENDIENTE</span>';
            }else if( $reg->estado_conf == 2){
                $confi= '<span class="label bg-green-active">ENTREGADO</span>';
            }else{
                $confi='<span class="label bg-red-active">ATRASADO</span>';
            }
            if($reg->estado == 1){
                $estadofin = '<span class="label bg-green-active">Activo</span>';
            }else if( $reg->estado == 0){
                $estadofin= '<span class="label bg-red-active">Cancelado</span>';
            }else{
                $estadofin='<span class="label bg-green-active"><i class="fa fa-check-square"></i>Finalizado</span>';
            }
            $hora = substr($reg->hora_envio, 0,-3);
            $data[] = array(
                "0"=>($reg->estado)?'<button class="btn btn-info" data-toggle="modal" data-target="#modal_categoria" onclick="mostrar('.$reg->id_envio.')"><i class="fa fa-eye"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_envio.')"><i class="fa fa-check"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_envio.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_categoria" onclick="mostrar('.$reg->id_envio.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_envio.')"><i class="fa fa-check"></i></button>',
                "1"=>$newDate .' ' .$hora,
                "2"=>$entregado,
                "3"=>$reg->precio_envio,
                "4"=>($reg->condicion_pago)? 'PAGADO EN EL DOMICILIO':'PAGA EN DOMICILIO',
                "5"=>$confi,
                "6"=>$estadofin,
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
