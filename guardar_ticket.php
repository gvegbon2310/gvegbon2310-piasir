<?php
    include 'conectar.php';

    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $solicitante = $_POST['solicitante'];

    //Añadido de segundos a la hora para que encaje en el campo de la tabla de mysql
    $segundos_hora = $hora.":00";

    $sql = "INSERT INTO tickets(ID, titulo, tipo, descripcion, fecha, hora, solicitante) VALUES ('', '$titulo', '$tipo', '$descripcion', '$fecha', '$segundos_hora', '$solicitante')";

    if (mysqli_query($conexion, $sql)){
        //header("Location: index.php");
        echo "<h2>Registros añadidos correctamente.</h2><br>";
        echo "<a href='tickets.html'>Volver</a>";
    } else {
        echo "<h2>Los registros no han podido ser añadidos correctamente.</h2><br>";
        echo "<a href='tickets.html'>Volver</a>";
    }

    mysqli_close($conexion);
?>