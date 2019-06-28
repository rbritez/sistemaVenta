<?php
    require "../config/conexion.php";
    Class Imagen
    {  
        Public function __construct()
        {

        }
        Public function insertar($descripcion,$producto_id)
        {
            $sql= "INSERT INTO imagenes (descripcion, producto_id) VALUES ('$descripcion','$producto_id')";
            return ejectuarConsulta($sql);
        }
        Public  function mostrar($producto_id)
        {
            $sql = "SELECT * FROM imagenes WHERE producto_id='$producto_id' ";
            return ejectuarConsulta($sql);
        }
        public function eliminar($idimagen){
            $sql= "DELETE FROM imagenes WHERE id_imagen = '$idimagen'";
            return ejectuarConsulta($sql);
        }
        public function nombreimagen($idimagen){
            $sql = "SELECT * FROM imagenes WHERE id_imagen = '$idimagen'";
            return ejectuarConsulta($sql);
        }
    }
?>