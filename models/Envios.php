<?php
//conectamos a la base de datos
require "../config/conexion.php";

Class Envio
{
    //Impementamos nuestro constructor
    Public function __construct(){

    }
    //Implementamos un metodo para insertar registros
    Public function insertar($nombre_categoria){
        $sql = "INSERT INTO categorias (nombre_categoria) VALUES ('$nombre_categoria')";
        return ejectuarConsulta($sql);

    }
    //Implementamos un metodo para editar registros
    Public function editar($id_categoria, $nombre_categoria){
        $sql = "UPDATE categorias SET nombre_categoria = '$nombre_categoria' WHERE id_categoria = '$id_categoria'";
        return ejectuarConsulta($sql);

    }
    //Implementamos un metood para eliminar/ocultar/deshabilitar registros
    Public function activar($id_envio){
        $sql = "UPDATE envios SET fh_entrega= NOW(),estado_conf='2', estado = '1' WHERE id_envio= '$id_envio' ";
        return ejectuarConsulta($sql);
    }
    Public function desactivar($id_envio){
        $sql = "UPDATE envios SET estado = '0' WHERE id_envio= '$id_envio' ";
        return ejectuarConsulta($sql);
    }
    //Implementamos un metodo para mostrar los datos de un registro a modificar
    Public function mostrar($idcategoria){
        $sql = "SELECT * FROM categorias WHERE id_categoria = '$idcategoria'";
        return ejectuarConsultaSimpleFila($sql);
    }
    //Implementamos un metodo para listar los registros
    Public function listar(){
        $sql = "SELECT * FROM envios";
        return ejectuarConsulta($sql);
    }
    //Implementamos un metodo para listar los registros y mostrar en el select
    Public function selectCategoria(){
        $sql = "SELECT * FROM categorias WHERE condicion = 1";
        return ejectuarConsulta($sql);
    }
}
?>