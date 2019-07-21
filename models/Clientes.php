<?php
    require "../config/conexion.php";

    Class Cliente
    {
        Public function __construct()
        {
        }
        Public function insertar($persona_id)
        {
            $sql = "INSERT INTO clientes (persona_id) VALUES ('$persona_id')";
            return ejectuarConsulta($sql);
        }
        Public function editar()
        {
        }
        Public function activar($id_cliente)
        {
            $sql="UPDATE clientes SET condicion='1' WHERE id_clientes='$id_cliente'";
            return ejectuarConsulta($sql);
        }
        Public function desactivar($id_cliente)
        {
            $sql="UPDATE clientes SET condicion='0' WHERE id_clientes='$id_cliente'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_cliente)
        {
            $sql="SELECT clientes.`id_clientes`,
            clientes.`persona_id`,
            personas.`nombres`,
            personas.`apellidos`,
            personas.`nro_doc`
            FROM clientes 
            JOIN personas ON personas.`id_persona` = clientes.`persona_id`
            WHERE clientes.`id_clientes` = '$id_cliente'";
            return ejectuarConsultaSimpleFila($sql);
        }

        Public function listar()
        {
            $sql= "SELECT clientes.`id_clientes`,
            clientes.`persona_id`,
            personas.`nombres`,
            personas.`apellidos`,
            personas.`nro_doc`,
            (SELECT COUNT(*) FROM contactos WHERE contactos.`persona_id` = clientes.`persona_id`) AS contactos,
            (SELECT COUNT(*) FROM direcciones WHERE direcciones.`persona_id` = clientes.`persona_id`) AS direcciones,
            clientes.`condicion` 
            FROM clientes 
            JOIN personas ON personas.`id_persona` = clientes.`persona_id`
            ";
            return ejectuarConsulta($sql);
        }
    }
    
?>