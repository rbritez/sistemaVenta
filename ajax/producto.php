<?php
    require_once "../models/Producto.php";
    
    $producto = new Producto();

    $idproducto = isset($_POST['id_producto'])? limpiarCadena($_POST['id_producto']):"";
    $cod_producto = isset($_POST['cod_producto'])? limpiarCadena($_POST['cod_producto']):"";
    $descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']):"";
    $stock = isset($_POST['stock'])? limpiarCadena($_POST['stock']):"";
    $material_id = isset($_POST['material_id'])? limpiarCadena($_POST['material_id']):"";
    $categoria_id = isset($_POST['categoria_id'])? limpiarCadena($_POST['categoria_id']):"";

    switch ($_GET["op"])
    {
        case 'guardaryeditar':
            if(empty($idproducto)){
                $respuesta = $producto->insertar($cod_producto,$descripcion,$stock,$material_id,$categoria_id);
                echo $respuesta ? "1" : "0" ;
            }else{
                $respuesta = $producto->editar($idproducto,$cod_producto,$descripcion,$stock,$material_id,$categoria_id);
                echo $respuesta ? "2" : "3" ;
            }
        break;
        case 'activar':
            $respuesta = $producto->activar($idproducto);
            echo $respuesta ? "1": "0";
        break;
        case 'desactivar':
            $respuesta = $producto->desactivar($idproducto);
            echo $respuesta ? "1" : "0";
        break;
        case 'mostrar':
            $respuesta = $producto->mostrar($idproducto);
            //Codificar el resultado con JSON
            echo json_encode($respuesta);
        break;
        case 'listar':
            $respuesta = $producto->listar();
            
            require_once "../models/Imagenes.php";
            $imagen = new Imagen();
            //Vamos a declarar un array para luego mostrar uno a uno en la tabla de la vista. 
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                $mostrarImagen = $imagen->mostrar($reg->id_producto);
                $mostrar = '';
                while ($registroimagen = $mostrarImagen->fetch_object())
                { //traemos todas las imagenes  y cargamos cuando sean las relacionadas al producto
                    if($reg->id_producto == $registroimagen->producto_id){
                        $mostrar .= ' <div style="height:50px;width:50px;float:left;padding:3px 53px 53px 3px;background-color:gray; margin-right:5px;border-radius: 5px;">
                                        <button class="close" onclick=EliminarImagen('.$registroimagen->id_imagen.') style="position:relative;right:-50px;">
                                        <span aria-hidden="true" style="color:black">&times;</span>
                                        </button>
                                            <img src="../files/images/productos/'.$registroimagen->descripcion.'" height="50" width="50">
                                            <div style="position:relative;right:-15px;bottom:16px;font-weight: bold;"><a class="sb" href="../files/images/productos/'.$registroimagen->descripcion.'" style="text-decoration:none;color:black;">Ver</a></div>
                                        
                                    </div> ';
                    }
                }
                //creamos la tabla que se mostrata en la vista
                $data[] = array(
                    "0"=>($reg->condicion)?'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_producto" onclick="mostrar('.$reg->id_producto.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_producto.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" data-toggle="modal" data-target="#modal_producto" onclick="mostrar('.$reg->id_producto.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_producto.')"><i class="fa fa-check"></i></button>',
                    "1"=>$reg->cod_producto,
                    "2"=>$reg->descripcion,
                    "3"=>$reg->stock,
                    "4"=>$reg->material_id,
                    "5"=>$reg->categoria_id,
                    "6"=> $mostrar.' <button class="btn btn-file" data-toggle="modal" onclick=formImagen('.$reg->id_producto.') data-target="#modal_imagenProducto"><i class="fa fa-upload"></i></button>',
                    "7"=>($reg->condicion)?'<span class="label bg-green-active">Activo</span>':'<span class="label bg-red-active">Inactivo</span>',
                );
                $mostrar = '';
            }
            $results = array(
                "sEcho" =>1, //Informacion para el data table
                "iTotalRecords"=>count($data), //enviamos el total de registros al data table
                "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
                "aaData"=>$data //aca se encuentra almacenado todos los registros
            );
            echo json_encode($results);//devolvemos en json el ultimo array y sera utilizado por el data table

        break;
        case "selectCategoria":
            require_once "../models/Categoria.php";
            $categoria = new Categoria();
            $respuesta = $categoria->selectCategoria();
            while ($reg = $respuesta->fetch_object())
            {
                echo '<option value='.$reg->id_categoria. '>'.$reg->nombre_categoria.'</option>';
            }
        break;
        case "selectMaterial":
            require_once "../models/Material.php";
            $material = new Material();
            $respuesta = $material->selectMaterial();
            while ($reg = $respuesta->fetch_object())
            {
                echo '<option value='.$reg->id_material. '>'.$reg->nombre.'</option>';
            }
        break;
        case 'guardaryeditarImagen':
            require_once "../models/Imagenes.php";
            $imagen = new Imagen();
            $producto_id = isset($_POST['producto_id'])? limpiarCadena($_POST['producto_id']):"";
            $ruta = '../files/images/productos/'; //Decalaramos una variable con la ruta en donde almacenaremos los archivos
            $mensage = '';//Declaramos una variable mensaje quue almacenara el resultado de las operaciones.
            foreach ($_FILES as $key) //Iteramos el arreglo de archivos
            {
                if($key['error'] == UPLOAD_ERR_OK )//Si el archivo se paso correctamente Ccontinuamos 
                {
                    $name= $key['name'];
                    $ext = explode(".",$key['name']);

                    $descripcion = round(microtime(true)) . "$name." . end($ext);//Obtenemos el nombre original del archivo
                    $temporal = $key['tmp_name']; //Obtenemos la ruta Original del archivo
                    $Destino = $ruta.$descripcion;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo	
                    
                    move_uploaded_file($temporal, $Destino); //Movemos el archivo temporal a la ruta especificada	
                    $respuesta = $imagen->insertar($descripcion,$producto_id);
                }
                if ($key['error']=='' && $respuesta == 1) //Si no existio ningun error, retornamos un mensaje por cada archivo subido
                {
                    $mensage .= '-> Archivo <b>'.$name.'</b> Subido correctamente. <br>';
                }
                if ($key['error']!='' && $respuesta == 0)//Si existio algún error retornamos un el error por cada archivo.
                {
                    $mensage .= '-> No se pudo subir el archivo <b>'.$name.'</b> debido al siguiente Error: n'.$key['error']; 
                }
            }
            echo $mensage;// Regresamos los mensajes generados al cliente
        break;
        case 'mostrarImagen':
            require_once "../models/Imagenes.php";
            $imagen = new Imagen();
            $respuesta = $imagen->mostrar($idproducto);
            while ($reg = $respuesta->fetch_object())
            {   
                $rutaimg= '../files/images/productos/'.$reg->descripcion;
                echo ' <button><input type="hidden" name="idimagen" id="idimagen" value="'.$reg->id_imagen.'">
                <img src="'.$rutaimg.'" height="100px" width="100px"></button>';
            }
        break;
        case 'EliminarImagen':
            require_once "../models/Imagenes.php";
            $idimagen = isset($_POST['id_imagen'])? limpiarCadena($_POST['id_imagen']):"";
            $imagen = new Imagen();
            $nombreimagen = $imagen->nombreimagen($idimagen);
            while ($reg = $nombreimagen->fetch_object())
            {
                $ruta = '../files/images/productos/'.$reg->descripcion;
                $files = glob($ruta); //obtenemos todos los nombres de los ficheros
                foreach($files as $file){
                    if(is_file($file))
                    unlink($file); //elimino el fichero
                }
                $respuesta = $imagen->eliminar($idimagen);
            }
           
            echo $respuesta ? "1" : "0";
        break;
    }


?>