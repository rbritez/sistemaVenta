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
        Public function ventasFecha($fechaInicio,$fechaFin)
        {
            $sql= "SELECT DATE(facturas.`fecha_venta`) AS `fecha`,pp.`nombres` AS `nombre_cliente`,pp.`apellidos` AS `apellido_cliente`,
            usuarios.`nombre_usuario`,
            facturas.`tipo_comprobante`,facturas.`serie`,
            facturas.`codigo`,facturas.`monto_total`,
            facturas.`estado` FROM facturas 
            INNER JOIN clientes ON clientes.`id_clientes` = facturas.`cliente_id`
            INNER JOIN personas pp ON pp.`id_persona` = clientes.`persona_id`
            INNER JOIN usuarios ON usuarios.`id_usuario` = facturas.`usuario_id`
            INNER JOIN personas pu ON pu.`id_persona` = usuarios.`persona_id` 
	        WHERE DATE(facturas.`fecha_venta`) BETWEEN '$fechaInicio' AND '$fechaFin'
	        ORDER BY facturas.`id_factura`;";
            return ejectuarConsulta($sql);

        }
    }
?>