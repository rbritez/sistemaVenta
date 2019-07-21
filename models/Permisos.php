<?php
       //conectamos con la base de datos
       require "../config/conexion.php";
      Class Permiso
      {
          Public function __construct()
          {
          }
          Public function listar()
          {
          $sql = "SELECT * FROM permisos";
          return ejectuarConsulta($sql);
          }
      }
?>