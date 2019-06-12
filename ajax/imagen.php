<?php
    require_once "../models/Imagen.php";

    $imagen = new Imagen();
    $idimagen = isset($_POST['id_imagen'])? limpiarCadena($_POST['id_imagen']):"";
    $descripcion = isset($_POST['imagen'])? limpiarCadena($_POST['imagen']):"";
    $producto_id = isset($_POST['producto_id'])? limpiarCadena($_POST['producto_id']): "";

    switch ($_GET["op"])
    {
        case 'guardaryeditar':
            if(empty($idimagen)){
                foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
                {
                    //validamos si existe el archivo
                    if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']) )
                    {
                        //si no existe no se guarda nada y se pone los campos vacios
                        $idimagen= "";
                        $descripcion = "";
                        $producto_id ="";
                    }else{
                        $ext = explode("",$_FILES["imagen"]["name"][$key]); //obtenemos la extension del archivo con el nombre

                        if ($_FILES['imagen']['type'] =="image/jpg" || $_FILES['imagen']['type'] =="image/jpeg" || $_FILES['imagen']['type'] =="image/png")
                        {
                            $source = $_FILES["imagen"]['tmp_name'][$key]; //obtenemos el nombre temporal
                            //guardamos la imagen con nombre segun el dia hora minuto y segundo  en que se guardo para evitar nombres repatidos.
                            $descripcion = round(microtime(true)) . '.'. end($ext);
                            move_uploaded_file($source, "../files/images/productos". $descripcion);
                            $respuesta = $imagen->insertar($descripcion,$producto_id);
                        }
                    }
                }
                echo $respuesta ? "1" : "0";
            }else{
                $respuesta = $imagen->editar($idimagen,$descripcion,$producto_id);
                echo $respuesta ? "2" : "0";
            }
        break;
        case 'mostrar':
            $respuesta = $imagen->mostrar($producto);
            echo json_encode($respuesta);
        break;
        case 'listar':
            
        break;
    }

?>