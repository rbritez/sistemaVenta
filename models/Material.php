<?php
    //conectamos con la base de datos
    require "../config/conexion.php";

    class Material
    {
        //implementamos nuestro constructor
        Public function __constructor(){

        }
        Public function insertar($nombre)
        {
            $sql = "INSERT INTO materiales (nombre) VALUES ('$nombre')";
            return ejectuarConsulta($sql);
        }
        Public function editar($id_material,$nombre){
            $sql= "UPDATE materiales SET nombre = '$nombre' WHERE id_material = '$id_material'";
            return ejectuarConsulta($sql);
        }
        Public function activar($id_material){
            $sql = "UPDATE materiales SET condicion = '1' WHERE id_material = '$id_material'";
            return ejectuarConsulta($sql);
        }
        Public function desactivar($id_material){
            $sql = "UPDATE materiales SET condicion = '0' WHERE id_material = '$id_material'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_material){
            $sql= "SELECT * FROM  materiales WHERE  id_material = '$id_material'";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function listar(){
            $sql = "SELECT * FROM materiales";
            return ejectuarConsulta($sql);
        }

        Public function selectMaterial(){
            $sql = "SELECT * FROM materiales WHERE condicion = 1";
            return ejectuarConsulta($sql);
        }
        

    }

?>