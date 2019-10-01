<?php
    require_once "../models/Direcciones.php";
    $direccion = new Direccion();
    $id_direccion = isset($_POST["id_direccion"]) ? limpiarCadena($_POST["id_direccion"]) : "";
    $provincia = isset($_POST["provincia"]) ? limpiarCadena($_POST["provincia"]) : "";
    $localidad = isset($_POST["localidad"]) ? limpiarCadena($_POST["localidad"]) : "";
    $barrio = isset($_POST["barrio"])? limpiarCadena($_POST["barrio"]):"";
    $calle = isset($_POST["calle"])? limpiarCadena($_POST["calle"]):"";
    $manzana =isset($_POST["manzana"])? limpiarCadena($_POST["manzana"]):"";
    $altura = isset($_POST["altura"])? limpiarCadena($_POST["altura"]):"";
    $nro_piso = isset($_POST["nro_piso"])? limpiarCadena($_POST["nro_piso"]):"";
    $nro_dpto = isset($_POST["nro_dpto"])? limpiarCadena($_POST["nro_dpto"]):"";
    $info_add = isset($_POST["info_add"])? limpiarCadena($_POST["info_add"]) : "";
    $persona_id = isset($_POST["persona_id"]) ? limpiarCadena($_POST["persona_id"]) : "";
 
    switch ($_GET["op"]) {
        case 'guardaryeditar':
        if(empty($id_direccion)){
            $respuesta = $direccion->insertar($provincia,$localidad,$barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto,$info_add,$persona_id);
            echo $respuesta ? "1": "0";
        }else{
            $respuesta = $direccion->editar($id_direccion,$provincia,$localidad,$barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto,$info_add);
            echo $respuesta? "2" : "3";
        }   
        break;
        case 'guardarDireccion':
            $prov = isset($_POST["provDire"])? limpiarCadena($_POST["provDire"]):"";
            $loc = isset($_POST["locDire"])? limpiarCadena($_POST["locDire"]):"";
            $bar = isset($_POST["barDire"])? limpiarCadena($_POST["barDire"]):"";
            $cal = isset($_POST["calDire"])? limpiarCadena($_POST["calDire"]):"";
            $alt = isset($_POST["altDire"])? limpiarCadena($_POST["altDire"]):"";
            $mz = isset($_POST["mzDire"])? limpiarCadena($_POST["mzDire"]):"";
            $piso = isset($_POST["pisoDire"])? limpiarCadena($_POST["pisoDire"]):"";
            $dpt = isset($_POST["dptDire"])? limpiarCadena($_POST["dptDire"]):"";
            $infadd = isset($_POST["infaddDire"])? limpiarCadena($_POST["infaddDire"]):"";
            $cliente_id = $_GET['id_cliente'];
            $respuesta = $direccion->insertarDireccion($prov,$loc,$bar,$cal,$mz,$alt,$piso,$dpt,$infadd,$cliente_id);
            echo $respuesta ? "1": "0";
        break;
        case 'listar':
            $respuesta = $direccion->listar($persona_id);
            $data = array();
            while ($reg = $respuesta->fetch_object()){

                $data[] = array(
                "0"=> $reg->id_direccion,
                "1"=> $reg->provincia,
                "2"=>$reg->localidad,
                "3"=>$reg->barrio,
                "4"=>$reg->calle,
                "5"=> $reg->manzana,
                "6"=> $reg->altura,
                "7"=> $reg->nro_piso,
                "8"=>$reg->nro_dpto,
                "9"=>$reg->info_add,
                "10"=>$reg->persona_id,
                "11"=>$reg->nombres,
                "12"=> $reg->apellidos,
                ); 
            }
            $result = array(
                "aaData"=>$data //aca se encuentra almacenado todos los registros
            );
            echo json_encode($result);
        break;
        case 'mostrar':
            $respuesta = $direccion->mostrar($id_direccion);
            echo json_encode($respuesta);
        break;
        case 'eliminar':
            $respuesta = $direccion->eliminar($id_direccion);
            echo $respuesta ? "1" : "0";
        break;
    }
?>