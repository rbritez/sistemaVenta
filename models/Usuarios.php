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
        Public function insertar($persona_id,$nombre_usuario,$clave,$cargo,$imagen_usuario,$permisos)
        {
            $sql = "INSERT INTO usuarios (persona_id,nombre_usuario,clave,cargo,imagen_usuario) VALUES ('$persona_id','$nombre_usuario','$clave','$cargo','$imagen_usuario')";
            $usuarioNew = ejectuarConsulta_retornarID($sql);
            $num_elementos=0;
            $resp=1;
            while($num_elementos < count($permisos)){
                $sql_detalle="INSERT INTO permisosxusuario (permiso_id, usuario_id) VALUES('$permisos[$num_elementos]','$usuarioNew')";
                $num_elementos=$num_elementos+1;
                ejectuarConsulta($sql_detalle) or $resp=0;
            }
            return $resp;
        }
        Public function editar($id_usuario,$nombre_usuario,$cargo,$imagen_usuario,$permisos)
        {
            $sql= "UPDATE usuarios SET  nombre_usuario = '$nombre_usuario',cargo = '$cargo', imagen_usuario = '$imagen_usuario' WHERE id_usuario = '$id_usuario'";
            ejectuarConsulta($sql);
            //eliminamos los permisos para volver a cargarlos
            $eliminar = "DELETE FROM permisosxusuario WHERE usuario_id = '$id_usuario'";
            ejectuarConsulta($eliminar);
            //cargamos los nuevos permisos
            $num_elementos=0;
            $resp=1;
            while($num_elementos < count($permisos)){
                $sql_detalle="INSERT INTO permisosxusuario (permiso_id, usuario_id) VALUES('$permisos[$num_elementos]','$id_usuario')";
                $num_elementos=$num_elementos+1;
                ejectuarConsulta($sql_detalle) or $resp=0;
            }
            return $resp;
        }
        Public function editar_sinpermisos($id_usuario,$nombre_usuario,$cargo,$imagen_usuario)
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
        Public function mostrarPermisos($id_usuario){
            $sql= "SELECT * FROM permisosxusuario WHERE usuario_id = '$id_usuario'";
            return ejectuarConsulta($sql);
        }
        Public function mostrarPermisosJS($id_usuario){
            $sql="SELECT * FROM permisosxusuario WHERE usuario_id = '$id_usuario' ORDER BY permiso_id ASC LIMIT 1";
            return ejectuarConsulta($sql);
        }
        Public function verificaruser($login){
            $sql="SELECT id_usuario, nombre_usuario FROM usuarios WHERE nombre_usuario = '$login'";
            return ejectuarConsultaSimpleFila($sql);
        }
        Public function verificarLogin($id_usuario,$login){
            $sql= "SELECT usuarios.`id_usuario`,personas.`id_persona`, personas.`nombres`,personas.`apellidos`,personas.`nro_doc`,usuarios.`nombre_usuario`, usuarios.`imagen_usuario`,usuarios.`login_usuario`,usuarios.`condicion`
            FROM usuarios 
            JOIN personas ON personas.`id_persona` = usuarios.`persona_id`
            WHERE usuarios.`id_usuario`='$id_usuario' AND  usuarios.`nombre_usuario` = '$login' AND usuarios.`condicion`=1;";
            
            $sql1= "UPDATE usuarios SET login_usuario = 1 WHERE `id_usuario` = '$id_usuario'";
            ejectuarConsulta($sql1);
            return ejectuarConsulta($sql);
        }
        Public function salir($id_usuario){
            $sql= "UPDATE usuarios SET login_usuario = 0 WHERE `id_usuario` = '$id_usuario'";
            ejectuarConsulta($sql);
        }
    }
?>