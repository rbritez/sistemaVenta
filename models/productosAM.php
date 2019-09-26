<?php
//conectamos a la base de datos
require "../config/conexion.php";

Class ProductoAM
{
    //Impementamos nuestro constructor
    Public function __construct(){

    }
    //Implementamos un metodo para insertar registros
    Public function insertar($alto,$ancho,$prof,$fecha_p,$info_add,$cliente_id,$material_id,$categoria_id){
        $sql = "INSERT INTO productomedida (alto,ancho,profundidad,fecha_pedido,info_add,cliente_id,material_id,categoria_id) VALUES ('$alto','$ancho','$prof','$fecha_p','$info_add','$cliente_id','$material_id','$categoria_id')";
        return ejectuarConsulta($sql);

    }
    //Implementamos un metodo para editar registros
    Public function editar($id_productomedida,$alto,$ancho,$prof,$fecha_p,$info_add,$cliente_id,$material_id,$categoria_id){
        $sql = "UPDATE productomedida SET alto = '$alto',ancho = '$ancho',profundidad = '$profundidad',fecha_pedido = '$fecha_p',info_add = '$info_add',cliente_id = '$cliente_id',material_id = '$material_id',categoria_id = '$categoria_id' WHERE id_productomedida = '$id_productomedida'";
        return ejectuarConsulta($sql);

    }

    //Implementamos un metood para eliminar/ocultar/deshabilitar registros
    Public function activar($id_productomedida){
        $sql = "UPDATE productomedida SET estado = '1' WHERE id_productomedida= '$id_productomedida' ";
        return ejectuarConsulta($sql);
    }
    Public function desactivar($id_productomedida){
        $sql = "UPDATE productomedida SET estado = '0' WHERE id_productomedida= '$id_productomedida' ";
        return ejectuarConsulta($sql);
    }
    //Implementamos un metodo para mostrar los datos de un registro a modificar
    Public function mostrar($id_productomedida){
        $sql = "SELECT * FROM productomedida WHERE id_productomedida = '$id_productomedida'";
        return ejectuarConsultaSimpleFila($sql);
    }
    //Implementamos un metodo para listar los registros
    Public function listar(){
        $sql = "SELECT * FROM productomedida";
        return ejectuarConsulta($sql);
    }
}
?>