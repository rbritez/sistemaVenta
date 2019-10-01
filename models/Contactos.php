<?php
   require "../config/conexion.php";
    Class Contacto
    {
        Public function __construct()
        {
        }
        Public function insertar($telefono,$celular,$email,$fax,$persona_id)
        {
            $sql = "INSERT INTO contactos (telefono, celular, email, fax,fecha_carga, persona_id) VALUES ('$telefono','$celular','$email','$fax',curdate(),'$persona_id')";
            return ejectuarConsulta($sql);
        }
        Public function insertarContacto($telefono,$celular,$cliente_id)
        {
            $sqlCliente = "SELECT persona_id FROM clientes WHERE id_clientes = '$cliente_id'";
            $id_persona = ejectuarConsultaSimpleFila($sqlCliente);
            $id = $id_persona['persona_id'];
            $sql = "INSERT INTO contactos (telefono, celular,fecha_carga, persona_id) VALUES ('$telefono','$celular',curdate(),'$id')";
            return ejectuarConsulta($sql);
        }
        Public function editar($id_contacto,$telefono,$celular,$email,$fax)
        {
            $sql = "UPDATE contactos SET telefono = '$telefono', celular = '$celular', email = '$email', fax = '$fax' WHERE id_contacto = '$id_contacto'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_contacto)
        {
            $sql = "SELECT * FROM contactos  WHERE id_contacto = '$id_contacto'";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function listar($persona_id)
        {
            $sql = "SELECT contactos.`id_contacto`,
            contactos.`telefono`,
            contactos.`celular`,
            contactos.`email`,
            contactos.`fax`,
            personas.`id_persona` as 'persona_id',
            personas.`nombres`,
            personas.`apellidos` 
            FROM contactos 
            JOIN personas ON personas.`id_persona` = contactos.`persona_id`
            WHERE contactos.`persona_id`= '$persona_id'";
            return ejectuarConsulta($sql);
        }
        public function eliminar($id_contacto){
            $sql = "DELETE FROM contactos WHERE id_contacto = '$id_contacto'";
            return ejectuarConsulta($sql);
        }
    }
?>