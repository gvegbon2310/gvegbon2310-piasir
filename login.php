<?php
    include 'conectar.php';

    $usuario = $_POST['user'];
    $contrasenia = $_POST['password'];

    $consulta = "SELECT * FROM usuarios WHERE ID = '$usuario' AND contraseña = '$contrasenia'";
    $query = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($query) == 1){
        echo "Inicio de sesión exitoso.<br>";
        echo "Redireccionando...";
        if ($usuario = 'admin'){
            //redireccion
            header("refresh:3;url=analisisadmin.php");
        } else{
            //refresh es para que espere 3s antes de que 
            header("refresh:3;url=tickets.html");
            //header("Location: tickets.html");
        }
    } else {
        echo "Inicio de sesión erróneo. El nombre de usuario y/o contraseña no son válidos.<br>";
        echo "Redireccionando...";
        header("refresh:3;url=index.html");
        //header("Location: index.html");
    }

    mysqli_close($conexion);
?>