<?php
    //Activamos errores
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'conectar.php';

    //Activamos los errores como excepciones para que no de fatal error y no muestre nada
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    //Incluimos el estilo que se verá
    header("Content-Type: text/html");
    echo "<style>";
    include "./styles/estilo-guardar_ticket.css";
    echo "</style>";

    //Recogemos todos los datos que nos llegan del formulario tickets.html
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $solicitante = $_POST['solicitante'];

    //Añadido de segundos a la hora para que encaje en el campo de la tabla de mysql
    $segundos_hora = $hora.":00";

    //Hacemos un condicional para que nos muestre si los registros (query) se ha ejecutado correctamente o no
    try {
        //Consulta sql para poder añadir el ticket correctamente a la base de datos
        $sql = "INSERT INTO tickets(titulo, tipo, descripcion, fecha, hora, solicitante) VALUES ('$titulo', '$tipo', '$descripcion', '$fecha', '$segundos_hora', '$solicitante')";

        $query = mysqli_query($conexion, $sql);

        echo "<h2>Registros añadidos correctamente.</h2><br>";
        echo "<div class='div-botones'>";
        echo "<a class='botones' href='tickets.html'>Volver al formulario</a>";
        echo "<a class='botones' href='index.html'>Volver al inicio</a>";
        echo "</div>";
        echo "<img src='./img/mailenviado.gif' class='gif' alt='correcto-envio'>";
    } catch (Exception $e) {
        //Si no consigue añadir el registro en la base de datos no da fatal error y muestra nuestro código correctamente poniendo el error de mysql
        echo "<h2>Los registros no han podido ser añadidos correctamente.</h2><br>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
        echo "<div class='div-botones'>";
        echo "<a class='botones' href='tickets.html'>Volver al formulario</a>";
        echo "<a class='botones' href='index.html'>Volver al inicio</a>";
        echo "</div>";
        echo "<img src='./img/mailerror.gif' class='gif' alt='error-envio'>";
    }

    mysqli_close($conexion);
?>