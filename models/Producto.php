<?php
    require "../config/conexion.php";

    Class Producto
    {
        Public function __construct()
        {
        }
        Public function insertar($cod_producto,$descripcion,$stock,$material_id,$categoria_id)
        {
            $sql = "INSERT INTO productos (cod_producto,descripcion,stock,material_id,categoria_id) VALUES ('$cod_producto','$descripcion','$stock','$material_id','$categoria_id')";
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
            $sql="SELECT * FROM productos WHERE id_producto = '$idproducto'";
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
    }
    
?>