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
                $sql= "INSERT INTO direcciones (provincia, localidad, barrio,calle,manzana,altura,nro_piso,nro_dpto,info_add, persona_id) VALUES ('$provincia','$localidad','$barrio','$calle','$manzana','$altura','$nro_piso','$nro_dpto','$info_add','$persona_id')";
                return ejectuarConsulta($sql);
        }
        Public function editar($id_direccion,$barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto)
        {
            $sql= "UPDATE direcciones SET barrio = '$barrio', calle = '$calle', manzana = '$manzana', altura = '$altura', nro_piso = '$nro_piso', nro_dpo ='$nro_dpto' WHERE id_direccion = '$id_direccion'";
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