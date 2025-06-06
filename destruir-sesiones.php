<?php
    #Destruimos la sesión actual que proviene de la página de análisisadmin.php
    session_destroy();

    $destino = $_GET['redirigir'];

    #Dependiendo a qué botón le demos nos redirigirá a un sitio u otro
    if ($destino == "analisisadmin") {
        header("Location: analisisadmin.php");
    } else {
        header("Location: index.html");
    }
?>