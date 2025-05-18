<?php
//conexion base de datos
    $servidor = 'localhost'; //poner tu ip si no funciona
    $usuario = 'gvegbon_tickets';
    $password = 'zxASqw12';
    $basedatos = 'gvegbon_tickets';
    $conexion = mysqli_connect($servidor, $usuario, $password, $basedatos);

    if (!$conexion){
        die("Error de conexión: " .mysqli_connect_error());
    }
?>