<?php
    include 'conectar.php';

    //Recogemos todos los datos que nos llegan del formulario tickets.html
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $solicitante = $_POST['solicitante'];

    //Añadido de segundos a la hora para que encaje en el campo de la tabla de mysql
    $segundos_hora = $hora.":00";

    //Consulta sql para poder añadir el ticket correctamente a la base de datos
    $sql = "INSERT INTO tickets(titulo, tipo, descripcion, fecha, hora, solicitante) VALUES ('$titulo', '$tipo', '$descripcion', '$fecha', '$segundos_hora', '$solicitante')";

    //Hacemos una query para que nos muestre si los registros (query) se ha ejecutado correctamente o no
    if (mysqli_query($conexion, $sql)){
        //header("Location: index.php");
        echo "<h2>Registros añadidos correctamente.</h2><br>";
        echo "<a href='tickets.html'>Volver al formulario</a>";
        echo "<a href='index.html'>Volver al inicio</a>";
    } else {
        echo "<h2>Los registros no han podido ser añadidos correctamente.</h2><br>";
        echo "<a href='tickets.html'>Volver al formulario</a>";
        echo "<a href='index.html'>Volver al inicio</a>";
    }

    mysqli_close($conexion);
?>