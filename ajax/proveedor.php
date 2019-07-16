<?php
    require_once "../models/Proveedores.php";
    require_once "../models/Personas.php";
    require_once "../models/Direcciones.php";
    $direccion = new Direccion();
    $persona = new Persona();
    $proveedor = new Proveedor();
    
 

    $id_proveedor = isset($_POST["id_proveedor"])? limpiarCadena($_POST["id_proveedor"]):"";
    $id_persona = isset($_POST["persona_id"])? limpiarCadena($_POST["persona_id"]):"";
    $id_direccion = isset($_POST["id_direccion"])? limpiarCadena($_POST["id_direccion"]):"";
    $nombres = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
    $apellidos = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
    $nro_doc = isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
    $fecha_nac = isset($_POST["fecha_nac"])? limpiarCadena($_POST["fecha_nac"]):"";
    $razonsocial = isset($_POST["razonsocial"])? limpiarCadena($_POST["razonsocial"]):"";

   
    switch ($_GET["op"]) {
        case 'guardaryeditar':
            if(empty($id_proveedor)){
                
                $datos= [
                    'nombres' => $nombres,
                    'apellidos'=> $apellidos,
                    'nro_doc' => $nro_doc,
                ];
                /* 
                 0 -> la persona no se pudo guardar
                 1 -> la persona se guardo, pero no se guardo el proveedor
                 2 -> se guardo todo con exito
                 3 -> Se edito los datos con exito
                 4 -> no se Pudo editar
                */
                //primero guardamos los datos de la tabla persona y verificamos de que se guarde de manera correcta para poder continuar...
                $respuestaPersona = $persona->insertar($datos);
                    if ($respuestaPersona == 0) {
                    // Si no se guardo el registro de la persona devolvera 0, entonces informamos que falto completar algun campo de los datos de la persona
                       $respuesta = "0";//error al guardar persona
                       echo $respuesta; 
                    }else{
                        //tomamos el valor que devuelve como ID guardado recientemente 
                        $id_persona = $respuestaPersona;
                        //si se guardo correctamente los datos de la persona se trae el ID que obtuvo y usamos para relacionar, proximamente se pasa a relacionar con la tabla proveedor,
                        //pasamos a guardar en proveedor
                        $respuestaProveedor = $proveedor->insertar($razonsocial,$id_persona);
                        echo $respuestaProveedor ? "2" : "1";
                    }
            }else{
                //editamos la tabla persona y la tabla proveedor
                $respuestaPersona = $persona->editar_sinFN($nombres,$apellidos,$nro_doc,$id_persona);
                $respuestaProveedor = $proveedor->editar($id_proveedor,$razonsocial);
                echo $respuestaPersona ? "3" : "4"; 
            }
        break;
        
        case 'activar':
            $respuesta = $proveedor->activar($id_proveedor);
            echo $respuesta ? "1" : "0";
        break;
        
        case 'desactivar':
            $respuesta = $proveedor->desactivar($id_proveedor);
            echo $respuesta ? "1" : "0";
        break;
        
        case 'mostrar':
            $respuesta = $proveedor->mostrar($id_proveedor);
            echo json_encode($respuesta);
        break;
        
        case 'listar':
        $respuesta = $proveedor->listar();
            $data = array();
            while ($reg = $respuesta->fetch_object()){

                $data[] = array(
                "0"=>($reg->condicion) ?'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_proveedor" onclick="mostrar('.$reg->id_proveedor.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_proveedor.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_material" onclick="mostrar('.$reg->id_proveedor.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_proveedor.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->razon_social,
                "2"=>$reg->nombres,
                "3"=>$reg->apellidos,
                "4"=>($reg->contactos) ? '<button class="btn btn-info"><i class="fa fa-eye"></i></button> <button class="btn btn-success" data-toggle="modal" data-target="#modal_contacto"><i class="fa fa-plus"></i></button>' :' <button class="btn btn-success" data-toggle="modal" data-target="#modal_contacto"><i class="fa fa-plus"></i></button>',
                "5"=>($reg->direcciones)?'<button class="btn btn-info" onclick="mostrarDireccion('.$reg->id_persona.')"><i class="fa fa-eye" ></i></button> <button class="btn btn-success" data-toggle="modal" data-target="#modal_direcciones" onclick="mandarid_direccion('.$reg->id_persona.')"><i class="fa fa-plus"></i></button>' :' <button class="btn btn-success" data-toggle="modal" data-target="#modal_direcciones" onclick="mandarid_direccion('.$reg->id_persona.')"><i class="fa fa-plus"></i></button>',
                "6"=>($reg->condicion) ? '<span class="label bg-green-active">Activo</span>':'<span class="label bg-red-active">Inactivo</span>',
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