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
        public function totalComprasHoy(){
            $sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM compras WHERE DATE(fecha_compra)=curdate() AND compras.`estado` = 'aceptado'";
            return ejectuarConsulta($sql);
        }
        public function totalVentasHoy(){
            $sql="SELECT IFNULL(SUM(monto_total),0) as monto_total FROM facturas WHERE DATE(fecha_venta)=curdate() AND facturas.`estado` = 'aceptado'";
            return ejectuarConsulta($sql);
        }
        Public function consultaCompras_10dias(){
            $sql="SELECT CONCAT(DAY(fecha_compra),'-',MONTH(fecha_compra)) AS fecha, SUM(total_compra) AS total 
            FROM compras 
            WHERE compras.`estado` = 'aceptado'
            GROUP BY fecha_compra 
            ORDER BY fecha_compra DESC LIMIT 0,10";
            return ejectuarConsulta($sql);
            /*obtengo los diez primeros registros , es decir de los primeros diez dias,
             si quiero obtener de mas dias o menos , hay que cambiar el desc limit 0,10
            */
        }
        Public function consultaVentas_10dias(){
            $sql="SELECT CONCAT(DAY(fecha_venta),'-',MONTH(fecha_venta)) AS fecha, SUM(monto_total) AS total 
            FROM facturas 
            WHERE facturas.`estado` = 'aceptado'
            GROUP BY fecha_venta 
            ORDER BY fecha_venta DESC LIMIT 0,10";
            return ejectuarConsulta($sql);
            /*obtengo los diez primeros registros , es decir de los primeros diez dias,
             si quiero obtener de mas dias o menos , hay que cambiar el desc limit 0,10
            */
        }
        Public function ventas12meses(){
           $sql="SELECT DATE_FORMAT(fecha_venta,'%M')AS fecha,SUM(monto_total)AS total 
           FROM facturas
           GROUP BY MONTH(fecha_venta)
           ORDER BY fecha_VENTA DESC LIMIT 0,10 ";
           return ejectuarConsulta($sql); 
        }
        Public function clientesMax(){//FUNCION AUN EN DESUSO
            //funcion para traer los 3 clientes mas frecuentes o que mas compras realizaron
            //obtengo CANTIDAD, NOMBRES,APELLIDO
            $sql= "SELECT COUNT(f.`cliente_id`)  AS cantidad , UPPER(pc.`nombres`) AS nombres, UPPER(pc.`apellidos`) AS apellidos FROM facturas f
            INNER JOIN clientes c ON c.`id_clientes` = f.`cliente_id`
            INNER JOIN personas pc ON pc.`id_persona` = c.`persona_id` 
            WHERE f.`cliente_id`<> '7'            
            GROUP BY f.`cliente_id`
            LIMIT 0,3";
            return  ejectuarConsulta($sql);
        }
        Public function GananciasDia(){
            // consulta para traer las ganancias del dia.
            /*en esta consulta obtenemos:
                id_factura
                codigo
                precio_compra
                precio_venta
                cantidad
                descuento
                interes
                ganancia_producto
            */
        $sql="SELECT  f.`id_factura`,f.`codigo`,
                (SELECT precio_compra FROM detalles_compra 
                WHERE `id_producto` = detalles_compra.`producto_id` 
                ORDER BY id_detallecompra DESC LIMIT 0,1) AS precio_compra,
            df.`precio_venta`,df.`cantidad`,df.`descuento`,df.`interes`,
                ((df.`precio_venta`*df.`cantidad`)-
                    (SELECT precio_compra*df.`cantidad` FROM detalles_compra 
                        WHERE `id_producto` = detalles_compra.`producto_id` 
                        ORDER BY id_detallecompra DESC LIMIT 0,1) 
                    + df.`interes` - df.`descuento`) AS ganancia_producto	
            FROM facturas f
            INNER JOIN detalle_factura df ON f.`id_factura` = df.`factura_id`
            INNER JOIN productos p ON p.`id_producto` = df.`producto_id`
            WHERE f.`fecha_venta` = CURDATE()
            ";
        return ejectuarConsulta($sql);
        }
    }
?>