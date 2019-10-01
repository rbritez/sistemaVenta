<?php
//conectamos a la base de datos
require "../config/conexion.php";
//campos de la tabla direcciones
/* 
    id_direccion
    provincia
    localidad
    barrio
    calle
    manzana
    altura
    nro_piso
    nro_dpto
    info_add
    persona_id

*/
    Class Direccion 
    {
        Public function __construct()
        {
        }
        Public function insertar($provincia,$localidad,$barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto,$info_add,$persona_id)
        {   
                $sql= "INSERT INTO direcciones (provincia, localidad, barrio,calle,manzana,altura,nro_piso,nro_dpto,info_add,fecha_carga, persona_id) VALUES ('$provincia','$localidad','$barrio','$calle','$manzana','$altura','$nro_piso','$nro_dpto','$info_add',curdate(),'$persona_id')";
                return ejectuarConsulta($sql);
        }
        Public function insertarDireccion($provincia,$localidad,$barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto,$info_add,$cliente_id)
        {   
            $sqlCliente = "SELECT persona_id FROM clientes WHERE id_clientes = '$cliente_id'";
            $id_persona = ejectuarConsultaSimpleFila($sqlCliente);
            $id = $id_persona['persona_id'];
                $sql= "INSERT INTO direcciones (provincia, localidad, barrio,calle,manzana,altura,nro_piso,nro_dpto,info_add,fecha_carga, persona_id) VALUES ('$provincia','$localidad','$barrio','$calle','$manzana','$altura','$nro_piso','$nro_dpto','$info_add',curdate(),'$id')";
                return ejectuarConsulta($sql);
        }
        Public function editar($id_direccion,$provincia,$localidad,$barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto,$info_add)
        {
            $sql= "UPDATE direcciones SET provincia = '$provincia', localidad = '$localidad', barrio = '$barrio', calle = '$calle', manzana = '$manzana', altura = '$altura', nro_piso = '$nro_piso', nro_dpto ='$nro_dpto', info_add = '$info_add' WHERE id_direccion = '$id_direccion'";
            return  ejectuarConsulta($sql);
        }
        Public function eliminar($id_direccion){
            $sql = "DELETE FROM direcciones WHERE id_direccion = '$id_direccion'";
            return ejectuarConsulta($sql);
        }
        Public function activar()
        {
        
        }
        Public function desactivar()
        {
        
        }
        Public function mostrar($id_direccion)
        {
            $sql = "SELECT * FROM direcciones WHERE id_direccion = '$id_direccion'";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function listar($persona_id)
        {
            $sql = "SELECT direcciones.`id_direccion`,
            direcciones.`provincia`,
            direcciones.`localidad`,
            direcciones.`barrio`, 
            direcciones.`calle`,
            direcciones.`manzana`,
            direcciones.`altura`,
            direcciones.`nro_piso`,
            direcciones.`nro_dpto`,
            direcciones.`info_add`,
            direcciones.`persona_id`,
            personas.`nombres`,
            personas.`apellidos` FROM direcciones 
            JOIN personas ON personas.`id_persona` = direcciones.`persona_id`
            WHERE direcciones.`persona_id`= '$persona_id'";
            return ejectuarConsulta($sql);
        }
    }
?>