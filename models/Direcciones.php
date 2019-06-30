<?php
    Class Direccion 
    {
        Public function __construct()
        {
        }
        Public function insertar($barrio,$calle,$manzana,$altura,$nro_piso,$nro_dpto,$persona_id)
        {
            $sql= "INSERT INTO direcciones (barrio,calle, manzana, altura, nro_piso, nro_dpto,persona_id) VALUES ('$barrio','$calle','$manzana','$altura','$nro_piso','$nro_dpto','$persona_id')";
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
        Public function mostrar()
        {
        
        }
        Public function listar()
        {
        
        }
    }
?>