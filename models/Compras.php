<?php
    require "../config/conexion.php";
    Class Compra {
        Public function __construct(){

        }
        Public function insertar($proveedor_id,$usuario_id,$tipocomprobante,$serie,$numcomprobante,$fecha_compra,$impuesto,$total_compra,$producto_id,$cantidad,$precio_compra,$precio_venta){
            $sql= "INSERT INTO compras (proveedor_id, usuario_id,tipocomprobante,serie,numcomprobante,fecha_compra,impuesto,total_compra) VALUES ('$proveedor_id','$usuario_id','$tipocomprobante','$serie','$numcomprobante','$fecha_compra','$impuesto','$total_compra') ";
            $compra_id =  ejectuarConsulta_retornarID($sql);
            $num_elementos = 0;
            $sw = true;
            while ($num_elementos < count($producto_id)){
                $sql_detalle = "INSERT INTO detalles_compra (compra_id, producto_id,cantidad,precio_compra,precio_venta) VALUES ('$compra_id','$producto_id[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
                ejectuarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            return $sw;
        }
        Public function anular($id_compra){
            $sql = "UPDATE compras SET estado = 'anulado' WHERE id_compra = '$id_compra'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_compra){
            $sql = "SELECT compras.`id_compra`,DATE(compras.`fecha_compra`) as `fecha`,proveedores.`id_proveedor`,pp.`nombres` as `nombre_proveedor`,pp.`apellidos` as `apellido_proveedor`,usuarios.`id_usuario`,usuarios.`nombre_usuario`,
            compras.`impuesto`,
            compras.`tipocomprobante`,compras.`serie`,compras.`numcomprobante`,compras.`total_compra`,compras.`estado` FROM compras 
            INNER JOIN proveedores ON proveedores.`id_proveedor` = compras.`proveedor_id`
            INNER JOIN personas pp ON pp.`id_persona` = proveedores.`persona_id`
            INNER JOIN usuarios ON usuarios.`id_usuario` = compras.`usuario_id`
            INNER JOIN personas pu ON pu.`id_persona` = usuarios.`persona_id`
            WHERE compras.`id_compra`= '$id_compra'";
            return ejectuarConsultaSimpleFila($sql);
        }
        public function listarDetalles($id_compra){
            $sql="SELECT detalles_compra.`compra_id`,
            detalles_compra.`id_detallecompra`,
            productos.`descripcion`,
            detalles_compra.`cantidad`,
            detalles_compra.`precio_compra`,
            detalles_compra.`precio_venta` FROM detalles_compra 
           INNER JOIN productos ON productos.`id_producto` = detalles_compra.`producto_id`
           WHERE detalles_compra.`compra_id` = '$id_compra';";
           return ejectuarConsulta($sql);
        }
        Public function listar(){
            $sql = "SELECT compras.`id_compra`,DATE(compras.`fecha_compra`) as `fecha`,proveedores.`id_proveedor`,pp.`nombres` as `nombre_proveedor`,pp.`apellidos` as `apellido_proveedor`,usuarios.`id_usuario`,usuarios.`nombre_usuario`,compras.`tipocomprobante`,compras.`serie`,compras.`numcomprobante`,compras.`total_compra`,compras.`estado` FROM compras 
            INNER JOIN proveedores ON proveedores.`id_proveedor` = compras.`proveedor_id`
            INNER JOIN personas pp ON pp.`id_persona` = proveedores.`persona_id`
            INNER JOIN usuarios ON usuarios.`id_usuario` = compras.`usuario_id`
            INNER JOIN personas pu ON pu.`id_persona` = usuarios.`persona_id` ORDER BY compras.`id_compra`";
            return ejectuarConsulta($sql);
        }
    }
?>