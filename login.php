<?php
    include 'conectar.php';

    //Recogemos los datos que nos llegan del formulario de login (index.html)
    $usuario = $_POST['user'];
    $contrasenia = $_POST['password'];

    //Realizamos la query para ver si "existe" el usuario y contraseña que pusimos previamente
    $consulta = "SELECT * FROM usuarios WHERE ID = '$usuario' AND contraseña = '$contrasenia'";
    $query = mysqli_query($conexion, $consulta);

    //Hacemos un condicional que si la query en la base de datos sale una coincidencia es que efectivamente nuestro usuario y contraseñas son correctos 
    if (mysqli_num_rows($query) == 1){
        echo "Inicio de sesión exitoso.<br>";
        echo "Redireccionando...";
        //Condicional en el caso positivo para ver si es admin o un usuario normal, si es el administrador te envia al panel para ver los tickets, si no te envía al formulario para poder enviar un ticket
        if ($usuario == 'admin'){
            //redireccion
            header("refresh:2;url=analisisadmin.php");
        } else{
            //refresh es para que espere 3s antes de que 
            header("refresh:2;url=tickets.html");
        }
    } else {
        echo "Inicio de sesión erróneo. El nombre de usuario y/o contraseña no son válidos.<br>";
        echo "Redireccionando...";
        header("refresh:2;url=index.html");
    }

    mysqli_close($conexion);




    //chatgpt dice que puede dar errores el echo con el header refresh, asi que propone esto:
    /* if (mysqli_num_rows($result) == 1) {
    // Mostrar mensaje y redireccionar con HTML
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="refresh" content="3;url=pagina_bienvenida.php">
        <title>Iniciando sesión</title>
    </head>
    <body>
        <h2>Inicio de sesión exitoso. Serás redirigido en 3 segundos...</h2>
    </body>
    </html>';
} else {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="refresh" content="3;url=login.html">
        <title>Error</title>
    </head>
    <body>
        <h2>Usuario o contraseña incorrectos. Volviendo al login en 3 segundos...</h2>
    </body>
    </html>';
}*/
?>