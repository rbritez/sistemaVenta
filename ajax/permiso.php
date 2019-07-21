<?php
require_once "../models/Permisos.php";
//creamos el objeto categoria usando el constructor de categoria
$permiso  = new Permiso();
//Declaramos las variables que se utilizaran en el modelo MVC
//Primero validamos la existenia de la variable con isset
// Si existe el el objeto idcategoria y lo recibo por el metodo POST 
// Si existe Lo que tenga el objeto lo validamos con limpiarcadena
//si no existe lo dejo en cadena de texto vacia.
//lo mismo para los siguientes objetos

switch($_GET["op"]){
    case 'listar' :
        $respuesta = $permiso->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $data[] = array(
                "0"=> $reg->descripcion,
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
