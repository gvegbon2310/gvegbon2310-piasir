<?php
//falta insertar el formulario html a este que esta en otro archivo
    include 'conectar.php';

    $mostrarform = !isset($_POST['tipoticket']);
    if (!$mostrarform && isset($_POST['tipoticket'])) {
    //Datos que pasamos por el formulario HTML
    $tipoticket = $_POST['tipoticket'];

    //Arrays para las consultas sql
    $tipo = array('Cableado', 'Escritorio', 'Auxiliar', 'Otros');
    $meses = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
    
    //Elegimos la consulta según el tipo de filtrado que se haya seleccionado en el formulario
    if ($tipoticket == "todos") {
        $sql = "SELECT * FROM tickets ORDER BY fecha DESC, hora DESC";
        echo "<h2>Todos los tickets</h2>";
    } elseif (in_array($tipoticket, $tipo)) {
        $sql = "SELECT * FROM tickets WHERE tipo = '$tipoticket' ORDER BY fecha DESC, hora DESC";
        echo "<h2>Todos los tickets de tipo ".$tipoticket."</h2>";
    } elseif (in_array($tipoticket, $meses)) {
        $sql = "SELECT * FROM tickets WHERE MONTH(fecha) = '$tipoticket' ORDER BY fecha DESC, hora DESC";
        //Array para mostrar los meses en español con un echo
        $arraymesesp = array(
            "01" => "Enero",
            "02" => "Febrero",
            "03" => "Marzo",
            "04" => "Abril",
            "05" => "Mayo",
            "06" => "Junio",
            "07" => "Julio",
            "08" => "Agosto",
            "09" => "Septiembre",
            "10" => "Octubre",
            "11" => "Noviembre",
            "12" => "Diciembre"
        );
        echo "<h2>Todos los tickets del mes de ".$arraymesesp[$tipoticket]."</h2>";
    }
    $query = mysqli_query($conexion, $sql);

    echo "<div class='contenedor-tickets'>";
    if($query){
        while($fila = mysqli_fetch_assoc($query)){
            echo "<div class='divticket'>";
            echo "<h2 class='tituloticket'>Ticket Nº".$fila['ID']."</h2>";
            echo "<h3 class='h3ticket'>Título: </h3><p>".$fila['titulo']."</p><br>";
            echo "<h3 class='h3ticket'>Tipo: </h3><p>".$fila['tipo']."</p><br>";
            echo "<h3 class='h3ticket'>Descripción: </h3><p>".$fila['descripcion']."</p><br>";
            echo "<h3 class='h3ticket'>Fecha: </h3><p>".$fila['fecha']."</p><br>";
            echo "<h3 class='h3ticket'>Hora: </h3><p>".$fila['hora']."</p><br>";
            echo "<h3 class='h3ticket'>Solicitante: </h3><p>".$fila['solicitante']."</p><br>";
            echo "</div>";
        }
    }
    echo "</div>";

    echo "<a href='analisisadmin.php'><input class='botonfinal' type='button' name='Volver atrás' value='Volver al panel'></a>";
    echo "<a href='index.html'><input class='botonfinal' type='button' value='Volver al inicio'></a>";

    mysqli_close($conexion);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo-aadminsss.css">
    <title>Panel de administración de tickets</title>
</head>
<body>
    <?php if($mostrarform){ ?>

    

    <div class="general">
        <h1>Panel de administración de tickets</h1>
        <form action="#" method="post">
            <label>Elige el filtrado para los tickets: </label><br>
            <select name="tipoticket" required>
                <option value="" disabled selected>-- Escoge una opción --</option>
                <option value="todos">Todos los tickets</option>
                <optgroup label="Tipo">
                    <option value="Cableado">Cableado</option>
                    <option value="Escritorio">Escritorio</option>
                    <option value="Auxiliar">Auxiliar</option>
                    <option value="Otros">Otros</option>
                </optgroup>
                <optgroup label="Mes">
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </optgroup>
            </select>
            <div class="boton">
                <input class="Entrar" type="submit" name="Entrar" id="Entrar" value="Seleccionar">
            </div>
        </form>
    </div>

    <?php }?>

</body>
</html>