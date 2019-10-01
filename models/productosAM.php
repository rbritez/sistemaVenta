<?php
//conectamos a la base de datos
require "../config/conexion.php";

Class ProductoAM
{
    //Impementamos nuestro constructor
    Public function __construct(){

    }
    //Implementamos un metodo para insertar registros
    Public function insertar($cliente_id,$fecha_p,$cantidad,$alto,$ancho,$prof,$info_add,$material_id,$categoria_id){
        $sql = "INSERT INTO prod_medida (cliente_id,fecha_pedido) VALUES ('$cliente_id','$fecha_p')";
        $prod_medida_id =  ejectuarConsulta_retornarID($sql);
        //cargamos el detalle
            $i=0;
            $sw = true;
            $profu=0;
            while ($i < count($cantidad)){
                if($prof[$i] = ""){
                    $profu = 0;
                }
                $sql_detalle = "INSERT INTO detalle_prodmedida (prod_medida_id,cantidad, alto, ancho, profundidad, info_add, material_id, categoria_id) VALUES ('$prod_medida_id','$cantidad[$i]',
                '$alto[$i]','$ancho[$i]','$profu','$info_add[$i]','$material_id[$i]','$categoria_id[$i]')";
                ejectuarConsulta($sql_detalle) or $sw = false;
                $i = $i +1;  
            }
            return $sw;
    }
    //Implementamos un metodo para editar registros
    Public function editar($id_productomedida,$cantidad,$alto,$ancho,$prof,$fecha_p,$info_add,$cliente_id,$material_id,$categoria_id){
        $sql = "UPDATE prod_medida SET cantidad = '$cantidad',alto = '$alto',ancho = '$ancho',profundidad = '$profundidad',fecha_pedido = '$fecha_p',info_add = '$info_add',cliente_id = '$cliente_id',material_id = '$material_id',categoria_id = '$categoria_id' WHERE id_productomedida = '$id_productomedida'";
        return ejectuarConsulta($sql);

    }

    //Implementamos un metood para eliminar/ocultar/deshabilitar registros
    Public function activar($id_productomedida){
        $sql = "UPDATE prod_medida SET fecha_aviso = curdate(),condicion= '2',estado = '0' WHERE id_prod_medida= '$id_productomedida' ";
        return ejectuarConsulta($sql);
    }
    Public function desactivar($id_productomedida){
        $sql = "DELETE FROM detalle_prodmedida WHERE prod_medida_id = '$id_productomedida' ";
        ejectuarConsulta($sql);

        $sql1 = "DELETE FROM prod_medida WHERE id_prod_medida= '$id_productomedida' ";
        
        return ejectuarConsulta($sql1);
    }
    //Implementamos un metodo para mostrar los datos de un registro a modificar
    Public function mostrar($id_productomedida){
        // $sql = "SELECT id_dpmedida, cantidad,alto,ancho,profundidad,info_add,material_id,categoria_id,cliente_id,fecha_pedido FROM detalle_prodmedida dpm
        // INNER JOIN prod_medida pm ON pm.`id_prod_medida` = dpm.`prod_medida_id`
        //  WHERE prod_medida_id = '$id_productomedida'";
         $sql="SELECT * FROM prod_medida WHERE id_prod_medida = '$id_productomedida'";
        return ejectuarConsultaSimpleFila($sql);
    }
    //Implementamos un metodo para listar los registros
    Public function listar(){
        $sql="SELECT id_prod_medida,p.`apellidos`,p.`nombres`,pm.`fecha_pedido`,(SELECT telefono FROM contactos WHERE contactos.`persona_id` = c.`persona_id` ORDER BY contactos.`id_contacto` DESC LIMIT 1 ) AS telefono,pm.`fecha_aviso`,pm.`condicion`,pm.`estado` FROM prod_medida pm
        INNER JOIN clientes c ON c.`id_clientes` = pm.`cliente_id`
        INNER JOIN personas p ON p.`id_persona` = c.`persona_id`";
        return ejectuarConsulta($sql);
    }
    Public function listarDetalles($id){
        $sql="SELECT id_dpmedida, cantidad,alto,ancho,profundidad,info_add,m.`nombre` AS nombre_material,c.`nombre_categoria` FROM detalle_prodmedida dpm
        INNER JOIN materiales m ON m.`id_material` = dpm.`material_id`
        INNER JOIN categorias c ON c.`id_categoria` = dpm.`categoria_id`
        WHERE prod_medida_id = '$id'";
       return ejectuarConsulta($sql);
    }
}
?>