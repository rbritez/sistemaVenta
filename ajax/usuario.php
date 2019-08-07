<?php
    require_once "../models/Usuarios.php";
    require_once "../models/Personas.php";
    $persona = new Persona();
    $usuario = new Usuario();
    
    $id_usuario = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
    $persona_id = isset($_POST["persona_id"])? limpiarCadena($_POST["persona_id"]):"";
    $nombres = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
    $apellidos = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
    $nro_doc = isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
    $fecha_nac = isset($_POST["fecha_nac"])? limpiarCadena($_POST["fecha_nac"]):"";
    $nombre_usuario= isset($_POST["nombre_usuario"])? limpiarCadena($_POST["nombre_usuario"]):"";
    $imagen_usuario=isset($_POST["imagen_anterior"])? limpiarCadena($_POST["imagen_anterior"]):"";//imagen anterior
    $claveAnt=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
    $clave=isset($_POST["clave1"])? limpiarCadena($_POST["clave1"]):"";
    $cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
    // $login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
    $passHash = password_hash($clave, PASSWORD_BCRYPT);


   
    switch ($_GET["op"]) {
        case 'guardaryeditar':
            if(empty($id_usuario)){
                
                $datos= [
                    'nombres' => $nombres,
                    'apellidos'=> $apellidos,
                    'nro_doc' => $nro_doc,
                    'fecha_nac'=>$fecha_nac
                ];
                /* 
                 0 -> la persona no se pudo guardar
                 1 -> la persona se guardo, pero no se guardo el usuario
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
                        //si se guardo correctamente los datos de la persona se trae el ID que obtuvo y usamos para relacionar, proximamente se pasa a relacionar con la tabla usuario,
                        //pasamos a guardar en usuario
                        $ruta = '../files/images/usuarios/';
                        $name= $_FILES['imagen_usuario']['name'];
                        $ext = explode(".",$_FILES['imagen_usuario']['name']);

                        $imagen_usuario1 = round(microtime(true)) . "$name." . end($ext);//Obtenemos el nombre original del archivo
                        $temporal = $_FILES['imagen_usuario']['tmp_name']; //Obtenemos la ruta Original del archivo
                        $Destino = $ruta.$imagen_usuario1;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo	
                        
                        move_uploaded_file($temporal, $Destino); //Movemos el archivo temporal a la ruta 

                        $respuestaUsuario = $usuario->insertar($id_persona,$nombre_usuario,$passHash,$cargo,$imagen_usuario1,$_POST['permiso']);
                        echo $respuestaUsuario ? "2" :"1";
                    }
            }else{
                 //pasamos a guardar en usuario ,FALTA HACER QUE ELIMINE LA IMAGEN ANTERIOR
                 $ruta = '../files/images/usuarios/';
                 $name= $_FILES['imagen_usuario']['name'];
                 $ext = explode(".",$_FILES['imagen_usuario']['name']);

                 $imagen_usuario1 = round(microtime(true)) . "$name." . end($ext);//Obtenemos el nombre original del archivo
                 $temporal = $_FILES['imagen_usuario']['tmp_name']; //Obtenemos la ruta Original del archivo
                 $Destino = $ruta.$imagen_usuario1;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo
                 if(empty($name)){
                    $imagen_usuario1 = $imagen_usuario;
                 }else{
                    $ruta = '../files/images/usuarios/'.$imagen_usuario;
                    $files = glob($ruta); //obtenemos todos los nombres de los ficheros
                    foreach($files as $file){
                        if(is_file($file))
                        unlink($file); //elimino el fichero
                    }
                }
                 move_uploaded_file($temporal, $Destino); //Movemos el archivo temporal 
                // editamos la tabla persona y la tabla usuario
                $respuestaPersona = $persona->editar($nombres,$apellidos,$nro_doc,$fecha_nac,$persona_id);
                $respuestaUsuario = $usuario->editar($id_usuario,$nombre_usuario,$cargo,$imagen_usuario1,$_POST['permiso']);
                echo $respuestaPersona ? "3" : "4"; 
            }
        break;
        case 'verificarPass':
            $passHash= $usuario->traerPass($id_usuario);
            $clavetraida =$passHash["clave"];
            $resultado = password_verify($claveAnt, $clavetraida);
       
            if ($resultado == 1) {
                $passHash = password_hash($clave, PASSWORD_BCRYPT);
                $usuario->cambiarPass($id_usuario,$passHash);
                $respuesta = "1";
            } else {
                $respuesta = "0";
            }
            echo $respuesta;
        break;
        case 'activar':
            $respuesta = $usuario->activar($id_usuario);
            echo $respuesta ? "1" : "0";
        break;
        
        case 'desactivar':
            $respuesta = $usuario->desactivar($id_usuario);
            echo $respuesta ? "1" : "0";
        break;
        
        case 'mostrar':
            $respuesta = $usuario->mostrar($id_usuario);
            echo json_encode($respuesta);
        break;
        
        case 'listar':
        $respuesta = $usuario->listar();
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                if($reg->imagen_usuario){
                    $mostrar = ' <div style="height:40px;">
                    <img src="../files/images/usuarios/'.$reg->imagen_usuario.'"style="border:2px solid gray;border-radius: 5px;; width="30" height="45" >
                    <div style="position:relative;bottom:16px;font-weight: bold;"><a class="sb"  target="_blank" href="../files/images/usuarios/'.$reg->imagen_usuario.'" style="text-decoration:none;color:black;">Ver</a></div></div> ';
                }else{
                    $mostrar= 'no posee foto de perfil';
                }
                $data[] = array(
                "0"=>($reg->condicion) ?' <button class="btn btn-warning" data-toggle="modal" data-target="#modal_Pass" onclick="mostrarFormPass('.$reg->id_usuario.')"><i class="fa fa-key"></i></button> '.' <button class="btn btn-warning" data-toggle="modal" data-target="#modal_usuario" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button> '.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_usuario.')"><i class="fa fa-close"></i></button> ':' <button class="btn btn-warning" data-toggle="modal" data-target="#modal_Pass" onclick="mostrarFormPass('.$reg->id_usuario.')"><i class="fa fa-key"></i></button> '.' <button class="btn btn-warning" data-toggle="modal" data-target="#modal_material" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button> '.' <button class="btn btn-success" onclick="activar('.$reg->id_usuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombres,
                "2"=>$reg->apellidos,
                "3"=>$reg->nro_doc,
                "4"=>$reg->nombre_usuario,
                "5"=>$reg->cargo,
                "6"=>$mostrar,
                "7"=>($reg->contactos) ? '<button class="btn btn-info" onclick="mostrarContacto('.$reg->id_persona.')"><i class="fa fa-book"></i></button> <button class="btn btn-success" data-toggle="modal" data-target="#modal_contacto"onclick="mandarid_contacto('.$reg->id_persona.')"><i class="fa fa-plus"></i></button>' :' <button class="btn btn-success" data-toggle="modal" data-target="#modal_contacto"onclick="mandarid_contacto('.$reg->id_persona.')"><i class="fa fa-plus"></i></button>',
                "8"=>($reg->direcciones)?'<button class="btn btn-info" onclick="mostrarDireccion('.$reg->id_persona.')"><i class="fa fa-location-arrow" ></i></button> <button class="btn btn-success" data-toggle="modal" data-target="#modal_direcciones" onclick="mandarid_direccion('.$reg->id_persona.')"><i class="fa fa-plus"></i></button>' :' <button class="btn btn-success" data-toggle="modal" data-target="#modal_direcciones" onclick="mandarid_direccion('.$reg->id_persona.')"><i class="fa fa-plus"></i></button>',
                "9"=>($reg->login_usuario)?'<span style="color:green;font-weight:bold">En linea</span>':'<span style="color:gray;font-weight:bold">Desconectado</span>',
                "10"=>($reg->condicion) ? '<span class="label bg-green-active">Activo</span>':'<span class="label bg-red-active">Inactivo</span>',
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
        case 'selectPermisos':
            require_once "../models/Permisos.php";
            $permiso = new Permiso();
            $respuesta = $permiso->listar();
            $id = $_POST['id_usuario'];
            $marcados= $usuario->mostrarPermisos($id);
            $valores= array();
            while($per= $marcados->fetch_object())
            {
                array_push($valores,$per->permiso_id);
            }
            
            while ($reg = $respuesta->fetch_object())
            {
                $selected = in_array($reg->id_permiso,$valores)?'selected':'';
                echo '<option value="'.$reg->id_permiso. '" '.$selected.'>'.$reg->descripcion.'</option>';
            }
        break;
        case 'verificar':
            $loginA = $_POST['loginA'];
            $clave = $_POST['claveA'];
            //verificar nombre de usuario
            $respuestaLogin = $usuario->verificaruser($loginA);
            $datosUser = json_encode($respuestaLogin);
            $obj = json_decode($datosUser,true);
            $id_user = $obj["id_usuario"];
            if(empty($id_user)){
                echo "no existe este usuario";
                exit();
            }else{    
            // inicio verificar pass
            $passHash= $usuario->traerPass($id_user);
            $clavetraida =$passHash["clave"];
            $resultado = password_verify($clave, $clavetraida);
            if ($resultado == 1) {
                //si la contraseña es correcta
                $respuesta = $usuario->verificarLogin($id_user,$loginA);
                $fetch = $respuesta->fetch_object();
                if(isset($fetch))
                {
                    //creamos las variables de sesión
                    $_SESSION['id_usuario'] = $fetch->id_usuario;
                    $_SESSION['nombres'] = $fetch->nombres;
                    $_SESSION['apellidos'] = $fetch->apellidos;
                    $_SESSION['imagen'] = $fetch->imagen_usuario;
                    $_SESSION['login'] = $fetch->login_usuario;
                }
                echo json_encode($fetch); exit();
            } else { echo "clave incorrecta"; exit();}
                //fin verificar pass
            }
            //encriptar clave y verificar;



            // $respuesta = $usuario->verificarLogin($loginA,$clave);
            // $fetch = $respuesta->fetch_object();
            // if(isset($fetch))
            // {
            //     //creamos las variables de sesión
            //     $_SESSION['id_usuario'] = $fetch->id_usuario;
            //     $_SESSION['nombres'] = $fetch->nombres;
            //     $_SESSION['apellidos'] = $fetch->apellidos;
            //     $_SESSION['imagen'] = $fetch->imagen_usuario;
            //     $_SESSION['login'] = $fetch->login_usuario;
            // }
            // echo $id_user;
        break;
    }
?>