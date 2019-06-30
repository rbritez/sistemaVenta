<?php
    Class Persona
    {
        Public function __construct()
        {
        }
        Public function insertar($nombres,$apelidos,$nro_doc,$fecha_nac)
        {
            $sql= "INSERT INTO personas (nombres,apellidos, nro_doc,fecha_nac) VALUES ('$nombres','$apellidos','$nro_doc','$fecha_nac')";
            return ejectuarConsulta_retornarID($sql);
        }
        Public function editar($id_persona,$nombres,$apellidos,$nro_doc,$fecha_nac)
        {
            $sql= "UPDATE personas SET nombres = '$nombres',apellidos = '$apellidos',nro_doc = '$nro_doc',fecha_nac = '$fecha_nac' WHERE id_persona = '$id_persona'";
            return ejectuarConsulta_retornarID($sql);
        }
        Public function activar()
        {
        
        }
        Public function desactivar()
        {
        
        }
        Public function mostrar()
        {
        
        }
        Public function listar()
        {
        
        }
    }   
?>