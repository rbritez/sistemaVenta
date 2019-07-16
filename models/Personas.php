<?php
    //conectamos con la base de datos
    require "../config/conexion.php";

    Class Persona
    {
        Public function __construct()
        {
        }
        Public function insertar($datos)
        {
            $nombres = $datos["nombres"] . PHP_EOL;
            $apellidos = $datos["apellidos"] . PHP_EOL;
            if(!empty($datos["fecha_nac"]) && !empty($datos["nro_doc"])){ //si existen los dos campos
                $fecha_nac = $datos["fecha_nac"] . PHP_EOL;
                 $nro_doc = $datos["nro_doc"] . PHP_EOL;
                $sql= "INSERT INTO personas (nombres, apellidos, nro_doc,fecha_nac) VALUES ('$nombres','$apellidos','$nro_doc','$fecha_nac')";
                return ejectuarConsulta_retornarID($sql);
            }else if(empty($datos["fecha_nac"]) && !empty($datos["nro_doc"])){ //si solo existe nro doc y no existe fecha nacimiento
                $nro_doc = $datos["nro_doc"] . PHP_EOL;
                $sql= "INSERT INTO personas (nombres, apellidos, nro_doc) VALUES ('$nombres','$apellidos','$nro_doc')";
                return ejectuarConsulta_retornarID($sql);
            }else if(empty($datos["fecha_nac"]) && empty($datos["nro_doc"])){ // si no existe ninguno
                $sql= "INSERT INTO personas (nombres, apellidos) VALUES ('$nombres','$apellidos','$nro_doc')";
                return ejectuarConsulta_retornarID($sql);
            }

        }
        Public function editar_sinFN($nombres,$apellidos,$nro_doc,$id_persona)
        {
            $sql= "UPDATE personas SET nombres = '$nombres',apellidos = '$apellidos',nro_doc = '$nro_doc' WHERE id_persona = '$id_persona'";
            return ejectuarConsulta($sql);
        }
        Public function editar($nombres,$apellidos,$nro_doc,$fecha_nac,$id_persona)
        {
            $sql= "UPDATE personas SET nombres = '$nombres',apellidos = '$apellidos',nro_doc = '$nro_doc',fecha_nac = '$fecha_nac' WHERE id_persona = '$id_persona'";
            return ejectuarConsulta($sql);
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