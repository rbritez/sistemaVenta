<?php
    require "../config/conexion.php";
    Class Cuenta
    {
        Public function __construct()
        {
        }
        Public function insertar($id_cuota)
        {
            $sql ="UPDATE cuotas SET estado = 'pagado', fecha_pago = CURDATE() WHERE id_cuota = '$id_cuota' ";
            $respuesta = ejectuarConsulta($sql);
            $sql2 = "SELECT id_cuenta ,total_cuotas FROM cuotas INNER JOIN cuenta ON cuenta.`id_cuenta` = cuotas.`cuenta_id` WHERE id_cuota = '$id_cuota'";
            $totalcuotas= ejectuarConsultaSimpleFila($sql2);
            $sql3 ="SELECT nro_cuota FROM cuotas WHERE id_cuota = '$id_cuota'";
            $nro_cuota = ejectuarConsultaSimpleFila($sql3);
            $newtotalcuota = $totalcuotas['total_cuotas'];
            $newnro_cuota = $nro_cuota['nro_cuota'];
            $id_cuenta = $totalcuotas['id_cuenta'];
            if($newnro_cuota == $newtotalcuota){
                $sql4= "UPDATE cuenta SET estado = '0' WHERE id_cuenta = '$id_cuenta' ";
                ejectuarConsulta($sql4);
            }
            
        return $respuesta;
        }
        Public function editar()
        {
        
        }
        Public function mostrarProducto($cuenta_id){
            $sql = "SELECT pr.`descripcion`, ma.`nombre`  FROM cuenta cu
            INNER JOIN facturas fa ON fa.`id_factura` = cu.`factura_id`
            INNER JOIN detalle_factura def ON def.`factura_id` = fa.`id_factura`
            INNER JOIN productos pr ON pr.`id_producto` = def.`producto_id`
            INNER JOIN materiales ma ON ma.`id_material` = pr.`material_id`
            WHERE cu.`id_cuenta` = '$cuenta_id'";
            return ejectuarConsulta($sql);
        }
        Public function mostrarProductoTotal($cuenta_id){
            $sql = "SELECT fa.`monto_total`  FROM cuenta cu
            INNER JOIN facturas fa ON fa.`id_factura` = cu.`factura_id`
            INNER JOIN detalle_factura def ON def.`factura_id` = fa.`id_factura`
            INNER JOIN productos pr ON pr.`id_producto` = def.`producto_id`
            INNER JOIN materiales ma ON ma.`id_material` = pr.`material_id`
            WHERE cu.`id_cuenta` = '$cuenta_id' LIMIT 1";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($cuenta_id)
        {
            $sql="SELECT * FROM cuotas WHERE cuenta_id = '$cuenta_id' ORDER BY nro_cuota ASC";
            return ejectuarConsulta($sql);
        }
        Public function listar()
        {
            $sql = "SELECT cu.`id_cuenta`,cu.`fecha_cuenta`,pe.`nombres`,
            pe.`apellidos`,
            pe.`nro_doc`,
            us.`nombre_usuario`,
            cu.`total_cuotas`, cu.`estado` FROM cuenta cu
            INNER JOIN usuarios us ON us.`id_usuario` = cu.`usuario_id`
            INNER JOIN clientes cl ON cl.`id_clientes` = cu.`cliente_id`
            INNER JOIN personas pe ON pe.`id_persona` = cl.`persona_id` ORDER BY cu.`fecha_cuenta` DESC";
            return ejectuarConsulta($sql);
        }
        Public function selectClientes(){
            $sql="SELECT cl.`id_clientes`, pe.`nombres`, pe.`apellidos`, pe.`nro_doc` FROM clientes cl
            INNER JOIN personas pe ON pe.`id_persona` = cl.`persona_id` WHERE cl.`id_clientes` <> '7' ORDER BY pe.`apellidos` ASC";
            return ejectuarConsulta($sql);
        }
        Public function selectCuenta($cliente_id){
            $sql="SELECT id_cuenta,fecha_cuenta,total_cuotas, estado FROM cuenta WHERE estado = '1' AND cliente_id = '$cliente_id'";
            return ejectuarConsulta($sql);
        }
        Public function selectCuota($cuenta_id){
            $sql = "SELECT id_cuota,nro_cuota,fecha_v,interes,monto,estado,cuenta_id FROM  cuotas WHERE estado <> 'pagado' AND cuenta_id = '$cuenta_id'";
            return ejectuarConsulta($sql);
        }
        Public function detallarCuota($id_cuota){
            $sql="SELECT c.`id_cuota`,c.`nro_cuota`,c.`fecha_v`,c.`interes`,c.`monto`, cu.total_cuotas  FROM cuotas c 
            INNER JOIN cuenta cu ON cu.`id_cuenta` = c.`cuenta_id` 
            WHERE c.id_cuota = '$id_cuota'";
            return ejectuarConsultaSimpleFila($sql);
        }
       
        Public function encabezadoFacturaCuota($id_cuenta){
            $sql="SELECT LPAD(c.`id_cuenta`,4,'0') AS id_cuenta,LPAD(cl.`id_clientes`,4,'0') AS id_cliente, c.`fecha_cuenta`,curdate() as fecha,pe.`nombres` AS nombre_cliente ,pe.`apellidos` AS apellido_cliente,pe.`nro_doc` AS documento_cliente,
            pu.`nombres` AS nombre_usuario, pu.`apellidos` AS apellido_usuario 
            FROM cuenta c
            INNER JOIN clientes cl ON cl.`id_clientes` = c.`cliente_id`
            INNER JOIN personas pe ON pe.`id_persona` = cl.`persona_id`
            INNER JOIN usuarios us ON us.`id_usuario` = c.`usuario_id`
            INNER JOIN personas pu ON pu.`id_persona` = us.`persona_id`
            WHERE c.`id_cuenta` = '$id_cuenta'";
            return ejectuarConsulta($sql);
        }
        Public function mostrardetalleProducto($id_cuenta){
            $sql="SELECT LPAD(pr.`cod_producto`,4,'0') AS cod_producto,df.`cantidad`,pr.`descripcion` FROM cuenta c
            INNER JOIN facturas f ON f.`id_factura` = c.`factura_id`
            INNER JOIN detalle_factura df ON df.`factura_id` = f.`id_factura`
            INNER JOIN productos pr ON pr.`id_producto` = df.`producto_id`
            WHERE c.`id_cuenta` = '$id_cuenta'";
            return ejectuarConsulta($sql);
        }
        Public function mostrardetalleCuota($id_cuenta){
            $sql="SELECT c.`id_cuota`,c.`nro_cuota`,c.`fecha_v`,c.`fecha_pago`,c.`interes`,c.`monto`, cu.total_cuotas,(c.`monto` + c.`interes`) AS subtotal  FROM cuotas c 
            INNER JOIN cuenta cu ON cu.`id_cuenta` = c.`cuenta_id` 
            WHERE cu.`id_cuenta` = '$id_cuenta' AND c.`fecha_pago` = CURDATE();";
            return ejectuarConsulta($sql);
        }
        Public function cuentasPendientes(){
            $sql="SELECT cl.`id_clientes`,pe.`nombres`,pe.`apellidos`, (SELECT COUNT(*) FROM cuenta WHERE cuenta.`estado` = '1' AND cuenta.`cliente_id` = cl.`id_clientes` ) AS cuentas_abiertas,
            (SELECT COUNT(*) FROM cuotas INNER JOIN cuenta ce ON ce.id_cuenta = cuotas.`cuenta_id` WHERE ce.`cliente_id` = cl.`id_clientes` AND cuotas.`estado` = 'pendiente' ) AS Cuentas_Pendientes,
            (SELECT COUNT(*) FROM cuotas INNER JOIN cuenta ce ON ce.id_cuenta = cuotas.`cuenta_id` WHERE ce.`cliente_id` = cl.`id_clientes` AND cuotas.`estado` = 'mora' ) AS Cuentas_Mora FROM clientes cl
            INNER JOIN cuenta cu ON cu.`cliente_id` = cl.`id_clientes`
            INNER JOIN personas pe ON pe.`id_persona` = cl.`persona_id`
            WHERE cu.`estado` = '1'
            GROUP BY cl.`id_clientes`";
            return ejectuarConsulta($sql);
        }
    }
?>