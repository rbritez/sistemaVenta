<?php
    require_once "../models/Material.php";
    $material = new Material();

    $idmaterial = isset($_POST["id_material"]) ? limpiarCadena($_POST["id_material"]) : "";
    $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
    switch($_GET["op"]){
        case 'guardaryeditar':
            if(empty($idmaterial)){
                $respuesta = $material->insertar($nombre);
                echo $respuesta ? "1" : "0";
            }else{
                $respuesta = $material->editar($idmaterial, $nombre);
                echo $respuesta ? "respuesta 1 " : "respuesta 2";
            }
        break;
        case 'activar' :
            $respuesta = $material->activar($idmaterial);
            echo $respuesta ? "1" : "0";
        break;
        case 'desactivar':
            $respuesta = $material->desactivar($idmaterial);
            echo $respuesta ? "1" : "0";
        break;
        case 'mostrar' :
            $respuesta = $material->mostrar($idmaterial);
            echo json_encode($respuesta);
        break;
        case 'listar':
            $respuesta = $material->listar();
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                $data[] = array(
                    "0"=>($reg->condicion)?'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_material" onclick="mostrar('.$reg->id_material.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_material.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_material" onclick="mostrar('.$reg->id_material.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_material.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>($reg->condicion)?'<span class="label bg-green-active">Activo</span>':'<span class="label bg-red-active">Inactivo</span>',

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
    }
?>