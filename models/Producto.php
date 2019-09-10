<?php
    require "../config/conexion.php";

    Class Producto
    {
        Public function __construct()
        {
        }
        Public function insertar($cod_producto,$descripcion,$stock,$precio,$material_id,$categoria_id)
        {
            $sql = "INSERT INTO productos (cod_producto,descripcion,stock,precio_venta,material_id,categoria_id) VALUES ('$cod_producto','$descripcion','$stock','$material_id','$categoria_id')";
            return ejectuarConsulta($sql);
        }
        Public function editar($idproducto,$cod_producto,$descripcion,$stock,$material_id,$categoria_id)
        {
            $sql= "UPDATE productos SET cod_producto='$cod_producto',descripcion='$descripcion',stock='$stock',material_id='$material_id',categoria_id='$categoria_id' WHERE id_producto='$idproducto' ";
            return ejectuarConsulta($sql);
        }
        Public function activar($idproducto)
        {
            $sql="UPDATE productos SET condicion='1' WHERE id_producto='$idproducto'";
            return ejectuarConsulta($sql);
        }
        Public function desactivar($idproducto)
        {
            $sql="UPDATE productos SET condicion='0' WHERE id_producto='$idproducto'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($idproducto)
        {
            $sql="SELECT `id_producto`, LPAD(`cod_producto`,4,'0') AS cod_producto,`descripcion`,`stock`,`material_id`,`categoria_id`,`condicion` FROM productos WHERE id_producto = '$idproducto'";
            return ejectuarConsultaSimpleFila($sql);
        }

  
        Public function listar()
        {
            $sql= "SELECT productos.`id_producto`,
            LPAD(productos.`cod_producto`,4,'0') AS cod_producto,
            productos.`descripcion`,
            productos.`stock`,
            materiales.`nombre` as material_id,
            categorias.`nombre_categoria` as categoria_id,
            productos.`condicion` FROM productos 
            JOIN materiales ON materiales.`id_material` = productos.`material_id`
            JOIN categorias ON categorias.`id_categoria` = productos.`categoria_id`
            ";
            return ejectuarConsulta($sql);
        }
        Public function listarActivos(){
            $sql="SELECT productos.`id_producto`,
            LPAD(productos.`cod_producto`,4,'0') AS cod_producto,
            productos.`descripcion`,
            productos.`stock`,
            materiales.`nombre` as material_id,
            categorias.`nombre_categoria` as categoria_id,
            productos.`condicion` FROM productos 
            JOIN materiales ON materiales.`id_material` = productos.`material_id`
            JOIN categorias ON categorias.`id_categoria` = productos.`categoria_id` WHERE productos.`condicion` = 1
            ";
            return ejectuarConsulta($sql);
        }
        public function listarActivosVenta(){
            $sql="SELECT p.`id_producto`, p.`categoria_id`,p.`material_id`,
            c.`nombre_categoria`, m.`nombre` AS nombre_material,
            LPAD(p.`cod_producto`,4,'0') AS cod_producto, p.`descripcion`,p.`stock`,
            (SELECT precio_venta FROM detalles_compra 
            WHERE producto_id = p.`id_producto` ORDER BY id_detallecompra DESC LIMIT 0,1 )AS precio_venta,
            (SELECT imagenes.`descripcion` FROM imagenes WHERE producto_id = p.`id_producto` ORDER BY id_imagen DESC LIMIT 0,1)AS imagen_producto
            FROM productos p 
            INNER JOIN categorias c ON p.`categoria_id` = c.`id_categoria`
            INNER JOIN materiales m ON p.`material_id` = m.`id_material`
            WHERE p.`condicion` = 1";
            return ejectuarConsulta($sql);
        }
        Public function AumentoProducto($idproducto){
            $sql="SELECT p.`id_producto`,p.`descripcion`, dc.`precio_compra`,DATE(c.`fecha_compra`)fecha_compra
            FROM compras c
            INNER JOIN detalles_compra dc ON dc.`compra_id` = c.`id_compra`
            INNER JOIN productos p ON p.`id_producto` = dc.`producto_id`
            WHERE p.`id_producto` = '$idproducto'
            ORDER BY DATE(c.fecha_compra) ASC";
            return ejectuarConsulta($sql);
        }
        Public function traerproducto(){
            $sql="SELECT id_producto ,descripcion FROM productos WHERE condicion = 1 ";
            return ejectuarConsulta($sql);
        }
    }
    
?>