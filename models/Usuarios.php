<?php
/* 
    Tabla Usuarios
    id_usuario
    persona_id
    nombre_usuario
    clave
    cargo
    login_usuario
    imagen_usuario
    condicion

*/
    //conectamos con la base de datos
    require "../config/conexion.php";
    Class Usuario
    {
        Public function __construct()
        {
        }
        Public function insertar($persona_id,$nombre_usuario,$clave,$cargo,$imagen_usuario)
        {
            $sql = "INSERT INTO usuarios (persona_id,nombre_usuario,clave,cargo,imagen_usuario) VALUES ('$persona_id','$nombre_usuario','$clave','$cargo','$imagen_usuario')";
            return ejectuarConsulta($sql);
        }
        Public function editar($id_usuario,$nombre_usuario,$cargo,$imagen_usuario)
        {
            $sql= "UPDATE usuarios SET  nombre_usuario = '$nombre_usuario',cargo = '$cargo', imagen_usuario = '$imagen_usuario' WHERE id_usuario = '$id_usuario'";
            return ejectuarConsulta($sql);
        }
        Public function logeado($id_usuario,$login){
            $sql= "UPDATE usuarios SET login_usuario = '$login' WHERE id_usuario = '$id_usuario'";
            return ejectuarConsulta($sql);
        }
        public function traerPass($id_usuario){
            $sql="SELECT clave FROM usuarios WHERE id_usuario = '$id_usuario'";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function cambiarPass($id_usuario,$clave){
            $sql= "UPDATE usuarios SET clave = '$clave' WHERE id_usuario = '$id_usuario'";
            return ejectuarConsulta($sql);
        }
        Public function activar($id_usuario)
        {
            $sql = "UPDATE usuarios SET condicion = '1' WHERE id_usuario = '$id_usuario'";
            return ejectuarConsulta($sql);
        }
        Public function desactivar($id_usuario)
        {
            $sql = "UPDATE usuarios SET condicion = '0' WHERE id_usuario = '$id_usuario'";
            return ejectuarConsulta($sql);
        }
        Public function mostrar($id_usuario)
        {
            $sql = "SELECT usuarios.`id_usuario`,
            personas.`id_persona`,
            personas.`nombres`,
            personas.`apellidos`,
            personas.`nro_doc`,
            personas.`fecha_nac`,
            usuarios.`nombre_usuario`,
            usuarios.`cargo`,
            usuarios.`imagen_usuario`
            FROM usuarios
            JOIN personas ON personas.`id_persona` = usuarios.`persona_id`
            WHERE usuarios.`id_usuario` = '$id_usuario' 
            ";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function listar()
        {
            $sql = "SELECT usuarios.`id_usuario`,
            personas.`id_persona`,
            personas.`nombres`,
            personas.`apellidos`,
            personas.`nro_doc`,
            usuarios.`nombre_usuario`,
            usuarios.`cargo`,
            usuarios.`imagen_usuario`,
	        (SELECT COUNT(*) FROM contactos WHERE contactos.`persona_id` = usuarios.`persona_id`) AS contactos,
	        (SELECT COUNT(*) FROM direcciones WHERE direcciones.`persona_id` = usuarios.`persona_id`) AS direcciones,
            usuarios.`login_usuario`,
            usuarios.`condicion`
            FROM usuarios
            JOIN personas ON personas.`id_persona` = usuarios.`persona_id`
            ";
            return ejectuarConsulta($sql);
        }
    }
?>