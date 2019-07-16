<?php
require_once "global.php";

$conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

// Si tenemos un posible error en la conexion lo mostramos
if(mysqli_connect_errno())
{
    printf("Fallo la conexion a la base de datos: %s\n", mysqli_connect_error());
    exit();
}

//preguntamos si existe alguna consulta realizandose, para evitar errores

if(!function_exists('ejectuarConsulta'))
{
    //funciones para hacer peticiones a la base de datos

    //para ejecutar codigo SQL solo se llamara a la funcion "ejectuarConsulta" con el parametro $sql, el cual se desea ejecutar 
    function ejectuarConsulta($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }


    //recibe codigo sql, solo devolvera la primer fila en un array, no devuelve todo el query
    function ejectuarConsultaSimpleFila($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }
    //recibe codigo sql, pero solo devolvera la PK(Primary Key) del registro insertado, mediante la sentencia "insert_id"
    function ejectuarConsulta_retornarID($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }
    //recibe la consulta, y limpia los caracteres especiales, para guardar en la base de datos, teniendo en cuenta el DB_ENCONDE que
    function limpiarCadena($str)
    {
        global $conexion;
        $str = mysqli_real_escape_string($conexion,trim($str));
        return htmlspecialchars($str);
    }
}
?>  