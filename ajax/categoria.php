<?php
require_once "../models/Categoria.php";
//creamos el objeto categoria usando el constructor de categoria
$categoria = new Categoria();
//Declaramos las variables que se utilizaran en el modelo MVC
//Primero validamos la existenia de la variable con isset
// Si existe el el objeto idcategoria y lo recibo por el metodo POST 
// Si existe Lo que tenga el objeto lo validamos con limpiarcadena
//si no existe lo dejo en cadena de texto vacia.
//lo mismo para los siguientes objetos
$idcategoria = isset($_POST["id_categoria"])? limpiarCadena($_POST["id_categoria"]): "" ;
$nombre_categoria= isset($_POST["nombre_categoria"])? limpiarCadena($_POST["nombre_categoria"]): "";


switch($_GET["op"]){
    case 'guardaryeditar' :
        if(empty($idcategoria)){
            $respuesta = $categoria->insertar($nombre_categoria);
            echo $respuesta ? "1" : "0";
        }else{
            $respuesta = $categoria->editar($idcategoria,$nombre_categoria);
            echo $respuesta ? "2" : "3";
        }
    break;

    case 'activar' :
        $respuesta = $categoria->activar($idcategoria);
        echo $respuesta ? "1" : "0";
    break;
    case 'desactivar' :
        $respuesta = $categoria->desactivar($idcategoria);
        echo $respuesta ? "1" : "0";
    break;

    case 'mostrar' :
        $respuesta = $categoria->mostrar($idcategoria);
        //Codificar el resultado con JSON
        echo json_encode($respuesta);
    break;

    case 'listar' :
        $respuesta = $categoria->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $data[] = array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_categoria" onclick="mostrar('.$reg->id_categoria.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_categoria.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_categoria" onclick="mostrar('.$reg->id_categoria.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_categoria.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre_categoria,
                "2"=>($reg->condicion)?'<span class="label bg-green-active">Activo</span>':'<span class="label bg-red-active">Inactivo</span>',
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
