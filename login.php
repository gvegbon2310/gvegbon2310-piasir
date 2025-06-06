<?php
    include 'conectar.php';

    //Incluimos el css externo
    header("Content-Type: text/html");
    echo "<style>";
    include "./styles/estilo-login.css";
    echo "</style>";

    //Recogemos los datos que nos llegan del formulario de login (index.html)
    $usuario = $_POST['user'];
    $contrasenia = $_POST['password'];

    //Realizamos la query para ver si "existe" el usuario y contraseña que pusimos previamente
    $consulta = "SELECT * FROM usuarios WHERE ID = '$usuario' AND contraseña = '$contrasenia'";
    $query = mysqli_query($conexion, $consulta);

    //Hacemos un condicional que si la query en la base de datos sale una coincidencia es que efectivamente nuestro usuario y contraseñas son correctos 
    if (mysqli_num_rows($query) == 1){
        echo "<h2 class='correcto'>✅ Inicio de sesión exitoso. ✅</h2><br>";
        echo "<h3>Redireccionando... 🔄</h3>";
        echo "<img src='./img/nubeserver.gif' alt='gifnube' name='gifnube'>";
        //Condicional en el caso positivo para ver si es admin o un usuario normal, si es el administrador te envia al panel para ver los tickets, si no te envía al formulario para poder enviar un ticket
        if ($usuario == 'admin'){
            //refresh es para que espere 3s antes de que te redirija
            header("refresh:3;url=analisisadmin.php");
        } else{
            header("refresh:3;url=tickets.html");
        }
    } else {
        echo "<h2 class='erroneo'>❌ Inicio de sesión erróneo. ❌</h2><br>";
        echo "<h3>Redireccionando... 🔄</h3>";
        echo "<img src='./img/cloud-error.gif' alt='gifnubeerror' name='gifnubeerror'>";
        header("refresh:2;url=index.html");
    }

    mysqli_close($conexion);
?>