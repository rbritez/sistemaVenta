<?php
  require "../config/conexion.php";
    Class Consultas
    {
        Public function __construct()
        {
        }
        
        Public function comprasFecha($fechaInicio,$fechaFin)
        {
            $sql= "SELECT DATE(compras.`fecha_compra`) AS `fecha`,pp.`nombres` AS `nombre_proveedor`,pp.`apellidos` AS `apellido_proveedor`,
            usuarios.`nombre_usuario`,
            compras.`tipocomprobante`,compras.`serie`,
            compras.`numcomprobante`,compras.`total_compra`,
            compras.`estado` FROM compras 
            INNER JOIN proveedores ON proveedores.`id_proveedor` = compras.`proveedor_id`
            INNER JOIN personas pp ON pp.`id_persona` = proveedores.`persona_id`
            INNER JOIN usuarios ON usuarios.`id_usuario` = compras.`usuario_id`
            INNER JOIN personas pu ON pu.`id_persona` = usuarios.`persona_id` 
	        WHERE DATE(compras.`fecha_compra`) BETWEEN '$fechaInicio' AND '$fechaFin'
	        ORDER BY compras.`id_compra`;";
            return ejectuarConsulta($sql);

        }
    }
?>