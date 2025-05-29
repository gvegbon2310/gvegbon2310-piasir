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
        echo "<h2>✅ Inicio de sesión exitoso. ✅</h2><br>";
        echo "<h3>Redireccionando... 🔄</h3>";
        echo "<img src='./img/nubeserver.gif' alt='gifnube' name='gifnube'>";
        //Condicional en el caso positivo para ver si es admin o un usuario normal, si es el administrador te envia al panel para ver los tickets, si no te envía al formulario para poder enviar un ticket
        if ($usuario == 'admin'){
            //redireccion
            header("refresh:3;url=analisisadmin.php");
        } else{
            //refresh es para que espere 3s antes de que 
            header("refresh:3;url=tickets.html");
        }
    } else {
        echo "<h2>❌ Inicio de sesión erróneo. ❌</h2><br>";
        echo "<h3>Redireccionando... 🔄</h3>";
        echo "<img src='./img/cloud-error.gif' alt='gifnubeerror' name='gifnubeerror'>";
        header("refresh:2;url=index.html");
    }

    mysqli_close($conexion);
?>