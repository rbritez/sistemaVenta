<?php
//conectamos a la base de datos
require "../config/conexion.php";
    Class Proveedor
    {
        Public function __construct()
        {
        }
        Public function insertar($razonsocial,$persona_id)
        {
            $sql = "INSERT INTO proveedores (razon_social, persona_id) VALUES ('$razonsocial','$persona_id')";
            return ejectuarConsulta($sql);
        }
        Public function editar($id_proveedor,$razonsocial)
        {
            $sql= "UPDATE proveedores SET razon_social = '$razonsocial' WHERE id_proveedor = '$id_proveedor'";
            return ejectuarConsulta($sql);
        }
        Public function activar($id_proveedor)
        {
            $sql = "UPDATE proveedores SET condicion = '1' WHERE id_proveedor = '$id_proveedor'";
            return ejectuarConsulta($sql);
        }
        Public function desactivar($id_proveedor)
        {
            $sql = "UPDATE proveedores SET condicion = '0' WHERE id_proveedor = '$id_proveedor'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_proveedor)
        {
            $sql = "SELECT proveedores.`id_proveedor`,
            personas.`id_persona`,
            proveedores.`razon_social`,
            personas.`nombres`,
            personas.`apellidos`,
            personas.`nro_doc`,
            personas.`fecha_nac`,
            FROM proveedores
            JOIN personas ON personas.`id_persona` = proveedores.`persona_id`
            WHERE proveedores.`id_proveedor` = '$id_proveedor' 
            ";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function listar()
        {
            $sql = "SELECT proveedores.`id_proveedor`,
            personas.`id_persona`,
            proveedores.`razon_social`,
            personas.`nombres`,
            personas.`apellidos`,
	        (SELECT COUNT(*) FROM contactos WHERE contactos.`persona_id` = proveedores.`persona_id`) AS contactos,
	        (SELECT COUNT(*) FROM direcciones WHERE direcciones.`persona_id` = proveedores.`persona_id`) AS direcciones,
            proveedores.`condicion`
            FROM proveedores
            JOIN personas ON personas.`id_persona` = proveedores.`persona_id`
            LEFT JOIN contactos ON contactos.`persona_id` = personas.`id_persona`
            LEFT JOIN direcciones ON direcciones.`persona_id` = personas.`id_persona`
            ";
            return ejectuarConsulta($sql);
        }
    }
?>