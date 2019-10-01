<?php
  require_once "../models/Contactos.php";
    $contacto = new Contacto();

    $id_contacto = isset($_POST["id_contacto"])? limpiarCadena($_POST["id_contacto"]):"";
    $persona_id = isset($_POST["persona_id"])? limpiarCadena($_POST["persona_id"]):"";
    $telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $celular = isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
    $email = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
    $fax = isset($_POST["fax"])? limpiarCadena($_POST["fax"]):"";

    switch ($_GET["op"]) {
        case 'guardaryeditar':
        if(empty($id_contacto)){
            $respuesta = $contacto->insertar($telefono,$celular,$email,$fax,$persona_id);
            echo $respuesta;
        }else{
            $respuesta = $contacto->editar($id_contacto,$telefono,$celular,$email,$fax);
            echo $respuesta ? "2" : "3"; 
        }
        break;
        case 'guardarContacto':
            $telefonoContacto = isset($_POST["telefonoContacto"])? limpiarCadena($_POST["telefonoContacto"]):"";
            $celularContacto = isset($_POST["celularContacto"])? limpiarCadena($_POST["celularContacto"]):"";
         
            $cliente_id = $_GET['id_cliente'];
            $respuesta = $contacto->insertarContacto($telefonoContacto,$celularContacto,$cliente_id);
            echo $respuesta ? "1": "0";
        break;

        case 'eliminar':
            $respuesta = $contacto->eliminar($id_contacto);
            echo $respuesta ? "1" : "0";
        break;

        case 'mostrar': //mostrar para editar, trae una fila
            $respuesta = $contacto->mostrar($id_contacto);
            echo json_encode($respuesta);
        break;
    
        case 'listar':
            $respuesta= $contacto->listar($persona_id);
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                $data[] = array(
                "0"=> $reg->id_contacto,
                "1"=> $reg->telefono,
                "2"=>$reg->celular,
                "3"=>$reg->email,
                "4"=>$reg->fax,
                "5"=> $reg->persona_id,
                "6"=>$reg->nombres,
                "7"=>$reg->apellidos,
                ); 
            }
            $result = array(
                "aaData"=>$data //aca se encuentra almacenado todos los registros
            );
            echo json_encode($result);
        break;
    }
?>