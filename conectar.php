<?php
//conexion base de datos
    $servidor = 'localhost';
    $usuario = 'gvegbon2310_tickets';
    $password = 'zxASqw12';
    $basedatos = 'gvegbon2310_tickets';
    $conexion = mysqli_connect($servidor, $usuario, $password, $basedatos);

    if (!$conexion){
        die("Error de conexión: " .mysqli_connect_error());
    }
?>