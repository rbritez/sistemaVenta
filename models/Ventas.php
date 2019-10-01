<?php
    require "../config/conexion.php";
    Class Venta {
        Public function __construct(){

        }
        /* TABLA FACTURAS
            id_factura
            tipo_comprobante
            serie
            codigo
            cliente_id
            usuario_id
            fecha_venta
            impuesto
            tipo_pago
            monto_total
            estado

            TABLA DETALLE_FACTURA
            id_detallefactura
            factura_id
            producto_id
            cantidad
            precio_venta
            descuento
            interes

            TABLA CUENTA
            id_cuenta
            cliente_id
            usuario_id
            total_cuotas
            estado abierto/cerrado

            TABLA CUOTAS
            id_cuota
            nro_cuota
            fecha_v
            fecha_pago
            monto
            descuento
            interes
            cuenta_id
            estado  pendiente/pagado/retrazado/mora
        */
        Public function insertar($tipo_comprobante,$serie,$codigo,$cliente_id,$usuario_id,$fecha_venta,$impuesto,$tipo_pago,$cantidadCuotas,$monto_total,
        $producto_id,$cantidad,$precio_venta,$descuento,$interes){
            $sql= "INSERT INTO facturas (tipo_comprobante,serie,codigo,cliente_id,usuario_id,fecha_venta,impuesto,tipo_pago,monto_total) VALUES ('$tipo_comprobante','$serie','$codigo','$cliente_id','$usuario_id','$fecha_venta','$impuesto','$tipo_pago','$monto_total') ";
            $venta_id =  ejectuarConsulta_retornarID($sql);
            $num_elementos = 0;
            $sw = true;
            while ($num_elementos < count($producto_id)){
                $sql_detalle = "INSERT INTO detalle_factura (factura_id, producto_id, cantidad,precio_venta,descuento, interes) VALUES ('$venta_id','$producto_id[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','$interes[$num_elementos]')";
                ejectuarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            if($tipo_pago == 'cred_personal'){
                $sqlCuenta= "INSERT INTO cuenta (cliente_id,usuario_id,factura_id,fecha_cuenta,total_cuotas)VALUES('$cliente_id','$usuario_id','$venta_id','$fecha_venta','$cantidadCuotas')";
                $cuenta_id = ejectuarConsulta_retornarID($sqlCuenta);
                $montoCuota = $monto_total / $cantidadCuotas;
                $cantidadCuotas = $cantidadCuotas+1;
                for ($i=1; $i < $cantidadCuotas; $i++) 
                { 
                    $newfecha = date("Y-m-d", strtotime($fecha_venta."+ $i month"));
                    $sqlCuota = "INSERT INTO cuotas (nro_cuota,fecha_v,interes,monto,cuenta_id)VALUES('$i','$newfecha',0,'$montoCuota',$cuenta_id)";
                    ejectuarConsulta($sqlCuota);                    
                }
            }
            
            return $sw;
        }
        Public function insertarConEnvio($tipo_comprobante,$serie,$codigo,$cliente_id,$usuario_id,$fecha_venta,$impuesto,$tipo_pago,$cantidadCuotas,$monto_total,
        $producto_id,$cantidad,$precio_venta,$descuento,$interes,$fecha_envio,$hora_envio,$monto_envio,$pago_envio,$id_contacto,$id_direccion){
            $sql= "INSERT INTO facturas (tipo_comprobante,serie,codigo,cliente_id,usuario_id,fecha_venta,impuesto,tipo_pago,monto_total) VALUES ('$tipo_comprobante','$serie','$codigo','$cliente_id','$usuario_id','$fecha_venta','$impuesto','$tipo_pago','$monto_total') ";
            $venta_id =  ejectuarConsulta_retornarID($sql);
            $num_elementos = 0;
            $sw = true;
            while ($num_elementos < count($producto_id)){
                $sql_detalle = "INSERT INTO detalle_factura (factura_id, producto_id, cantidad,precio_venta,descuento, interes) VALUES ('$venta_id','$producto_id[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','$interes[$num_elementos]')";
                ejectuarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos +1;
            }
            if($tipo_pago == 'cred_personal'){
                $sqlCuenta= "INSERT INTO cuenta (cliente_id,usuario_id,factura_id,fecha_cuenta,total_cuotas)VALUES('$cliente_id','$usuario_id','$venta_id','$fecha_venta','$cantidadCuotas')";
                $cuenta_id = ejectuarConsulta_retornarID($sqlCuenta);
                $montoCuota = $monto_total / $cantidadCuotas;
                $cantidadCuotas = $cantidadCuotas+1;
                for ($i=1; $i < $cantidadCuotas; $i++) 
                { 
                    $newfecha = date("Y-m-d", strtotime($fecha_venta."+ $i month"));
                    $sqlCuota = "INSERT INTO cuotas (nro_cuota,fecha_v,interes,monto,cuenta_id)VALUES('$i','$newfecha',0,'$montoCuota',$cuenta_id)";
                    ejectuarConsulta($sqlCuota);                    
                }
            }
            $sqlEnvio="INSERT INTO envios (fecha_envio,hora_envio,precio_envio,condicion_pago,factura_id,contacto_id,direccion_id)VALUES('$fecha_envio','$hora_envio','$monto_envio','$pago_envio','$venta_id','$id_contacto','$id_direccion')";
            return ejectuarConsulta($sqlEnvio);
        }
        Public function anular($id_factura){
            $sql = "UPDATE facturas SET estado = 'anulado' WHERE id_factura = '$id_factura'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_factura){
        $sql = "SELECT f.`id_factura`, DATE(f.`fecha_venta`)AS fecha_venta,
        f.`cliente_id`,p.`nombres` AS nombre_cliente,
        p.`apellidos` AS apellido_cliente,f.`usuario_id`,
        u.`nombre_usuario`,tipo_comprobante,serie,codigo,
        impuesto,tipo_pago,monto_total,estado
        FROM facturas f
        INNER JOIN clientes c ON c.`id_clientes` = f.`cliente_id`
        INNER JOIN personas p ON p.`id_persona` = c.`persona_id`
        INNER JOIN usuarios u ON u.`id_usuario` = f.`usuario_id`
        WHERE f.`id_factura` = '$id_factura'";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function mandarUltCodySerie(){
            //numero de serie y numero para la factura de venta de manera automatica
            $sql= "SELECT f.serie AS serie, LPAD(f.codigo+1,4,0) AS codigo,
            (SELECT COUNT(fa.id_factura) FROM facturas fa WHERE fa.serie = f.`serie`) AS cantidad
            FROM facturas f ORDER BY f.codigo DESC LIMIT 0,1";
            return ejectuarConsultaSimpleFila($sql);
        }
        public function listarDetalles($id_factura){
            $sql="SELECT detalle_factura.`factura_id`,
            detalle_factura.`id_detallefactura`,
            productos.`descripcion`,
            detalle_factura.`cantidad`,
            detalle_factura.`precio_venta`,
            detalle_factura.`descuento`,
            detalle_factura.`interes` FROM detalle_factura 
           INNER JOIN productos ON productos.`id_producto` = detalle_factura.`producto_id`
           WHERE detalle_factura.`factura_id` = '$id_factura';";
           return ejectuarConsulta($sql);
        }
        Public function listar(){
            $sql = "SELECT f.`id_factura`, DATE(f.`fecha_venta`)AS fecha_venta,
            f.`cliente_id`,p.`nombres` AS nombre_cliente,
            p.`apellidos` AS apellido_cliente,f.`usuario_id`,
            u.`nombre_usuario`,tipo_comprobante,serie,codigo,
            impuesto,tipo_pago,monto_total,estado
            FROM facturas f
            INNER JOIN clientes c ON c.`id_clientes` = f.`cliente_id`
            INNER JOIN personas p ON p.`id_persona` = c.`persona_id`
            INNER JOIN usuarios u ON u.`id_usuario` = f.`usuario_id` 
            ORDER BY f.`fecha_venta` DESC";
            return ejectuarConsulta($sql);
        }
        Public function ventaCabecera($id_factura){
             /*
            Obtengo:
            id_factura,nombre_cliente, apellido_cliente,nro_doc,telefono,email,nombre_usuario,apellido_usuario,tipo_comprobante,serie,codigo,fecha,impuesto,monto_total
            */
            $sql="SELECT facturas.`id_factura`,pc.`nombres` AS nombre_cliente,
            pc.`apellidos` AS apellido_cliente,pc.`nro_doc`,
            (SELECT contactos.`telefono` FROM contactos WHERE contactos.`persona_id` = pc.`id_persona` 
            ORDER BY contactos.`persona_id` DESC LIMIT 0,1)AS telefono,
            (SELECT contactos.`email` FROM contactos WHERE contactos.`persona_id` = pc.`id_persona` 
            ORDER BY contactos.`persona_id` DESC LIMIT 0,1)AS email, 
            pu.`nombres` AS nombre_usuario, pu.`apellidos` AS apellidos_usuario,
            facturas.`tipo_comprobante`,facturas.`serie`,facturas.`codigo`,
            DATE(facturas.`fecha_venta`) AS fecha,facturas.`impuesto`, facturas.`monto_total` AS `total_venta`
            FROM facturas 
            INNER JOIN clientes c ON c.`id_clientes` = facturas.`cliente_id`
            INNER JOIN personas pc ON pc.`id_persona` = c.`persona_id`
            INNER JOIN usuarios u ON u.`id_usuario` = facturas.`usuario_id`
            INNER JOIN personas pu ON pu.`id_persona` = u.`persona_id`
            WHERE facturas.`id_factura` = '$id_factura';
            ";
            return ejectuarConsulta($sql);
        }
        Public function ventadetalle($id_factura){
            /*
            Obtengo:
            descripcion, cantidad, precio_venta,descuento,interes,subtotal
            */
            $sql="SELECT productos.`descripcion`,LPAD(productos.`cod_producto`,4,'0') AS cod_producto,
            detalle_factura.`cantidad`, detalle_factura.`precio_venta`,
            detalle_factura.`descuento`,detalle_factura.`interes`,(detalle_factura.`cantidad`*detalle_factura.`precio_venta`-detalle_factura.`descuento` + detalle_factura.`interes`)AS subtotal
            FROM detalle_factura
            INNER JOIN productos ON productos.`id_producto` = detalle_factura.`producto_id`
            WHERE detalle_factura.`factura_id` = '$id_factura'";
            return ejectuarConsulta($sql);
        }
        Public function ultimaFacturaUser($usuario_id){
            $sql="SELECT id_factura,tipo_pago FROM facturas 
            WHERE usuario_id = '$usuario_id'
            ORDER BY codigo DESC LIMIT 0,1";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function consultaDirTel($id_cliente){
            $sql="SELECT c.`id_clientes`,pe.`id_persona`, 
                    (SELECT telefono FROM contactos WHERE contactos.`persona_id` = pe.`id_persona` ORDER BY contactos.`id_contacto` DESC LIMIT 1 ) AS telefono,
                    (SELECT celular FROM contactos WHERE contactos.`persona_id` = pe.`id_persona` ORDER BY contactos.`id_contacto` DESC LIMIT 1 ) AS celular,
                    (SELECT persona_id FROM direcciones WHERE direcciones.`persona_id` = pe.`id_persona` ORDER BY direcciones.`id_direccion` DESC LIMIT 1)AS dir_existente 
                FROM clientes c 
                INNER JOIN personas pe ON pe.`id_persona` = c.`persona_id`
                WHERE c.`id_clientes` = '$id_cliente'";
                return ejectuarConsultaSimpleFila($sql);

        }
        Public function selectContactoEnvio($id_persona){
            $sql= "SELECT id_contacto, telefono,celular FROM contactos 
                    INNER JOIN personas ON personas.`id_persona` = contactos.`persona_id` 
                    INNER JOIN  clientes ON clientes.`persona_id` = personas.`id_persona` 
                    WHERE clientes.`id_clientes` = '$id_persona'";
            return ejectuarConsulta($sql);
        }
        Public function selectDireccionEnvio($id_persona){
            $sql= "SELECT * FROM direcciones 
                    INNER JOIN personas ON personas.`id_persona` = direcciones.`persona_id` 
                    INNER JOIN  clientes ON clientes.`persona_id` = personas.`id_persona` 
                    WHERE clientes.`id_clientes` = '$id_persona'";
            return ejectuarConsulta($sql);
        }
    }
?>