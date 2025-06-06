<?php
    //Iniciamos la sesión
    session_start();
    include 'conectar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/estilo-aadmin.css">
    <title>Panel de administración</title>
</head>
<?php
    //Empezamos el condicional que hará las primeras sesiones por si venimos del formulario de mostrar los tickets
    if($_POST){
        if (isset($_POST['tipoticket'])) {
            $_SESSION['tipoticket'] = $_POST['tipoticket'];
            $_SESSION['pag'] = 1;
        }
        $pag = $_SESSION['pag'];
        $tipoticket = $_SESSION['tipoticket'];

        //Arrays para las consultas sql
        $tipo = array('Cableado', 'Escritorio', 'Auxiliar', 'Otros');
        $meses = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

        //Elegimos la consulta según el tipo de filtrado que se haya seleccionado en el formulario
        if ($tipoticket == "todos") {
            $sql="SELECT * FROM tickets ORDER BY fecha DESC, hora DESC";
            echo "<h1 class='h1principal'>Todos los tickets</h1>";
        } elseif (in_array($tipoticket, $tipo)) {
            $sql="SELECT * FROM tickets WHERE tipo='$tipoticket' ORDER BY fecha DESC, hora DESC";
            echo "<h1 class='h1principal'>Todos los tickets de tipo ".$tipoticket."</h1>";
        } elseif (in_array($tipoticket, $meses)) {
            $sql="SELECT * FROM tickets WHERE MONTH(fecha)='$tipoticket' ORDER BY fecha DESC, hora DESC";
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
            echo "<h1 class='h1principal'>Todos los tickets del mes de ".$arraymesesp[$tipoticket]."</h1>";
        }

        $query = mysqli_query($conexion, $sql);
        
        //Declaramos el número de páginas que va a haber y lo redondeamos hacia arriba para que siempre hayan las páginas adecuadas
        $pags = ceil($query->num_rows/10);
        
        //Establecemos el valor a la sesión cuando cambiamos de página para saber en qué página estamos
        if($query->num_rows > 10){
            $pags = ceil($query->num_rows/10);
            if($_POST['atras'] AND $_SESSION['pag'] > 1){
                $_SESSION['pag']--;
            }
            if($_POST['delante'] AND $_SESSION['pag'] < $pags){
                $_SESSION['pag']++;
            }
            for($i=1;$i<=$pags;$i++){
                if($_POST[$i]){
                    $_SESSION['pag'] = $i;
                }
        }

        echo "<h3>Estás en la página ".$_SESSION['pag']." de tickets.</h3>";

        //Comienzo del div para mostrar los tickets
        echo "<div class='contenedor-tickets'>";

            //Contador para mostrar 10 tickets por página
            $cont = 1;
            $contInicio = $_SESSION['pag']*10-9;
            $contFin = $contInicio+9;
            while(($fila = mysqli_fetch_assoc($query)) && $cont <= $contFin){
                if($cont >= $contInicio){
                    echo "<div class='divticket'>";
                        echo "<h2 class='tituloticket'>Ticket Nº".$fila['ID']."</h2>";
                        echo "<h3 class='h3ticket'>✍️ Título: </h3><p>".$fila['titulo']."</p><br>";
                        echo "<h3 class='h3ticket'>📑 Tipo: </h3><p>".$fila['tipo']."</p><br>";
                        echo "<h3 class='h3ticket'>📝 Descripción: </h3><p>".$fila['descripcion']."</p><br>";
                        echo "<h3 class='h3ticket'>📅 Fecha: </h3><p>".$fila['fecha']."</p><br>";
                        echo "<h3 class='h3ticket'>🕐 Hora: </h3><p>".$fila['hora']."</p><br>";
                        echo "<h3 class='h3ticket'>👤 Solicitante: </h3><p>".$fila['solicitante']."</p><br>";
                    echo "</div>";
                    $contInicio++;
                }
                $cont++;
            }
            echo "</div>";
            //Si no llega a 10 tickets el filtro que le hayamos puesto no habrá contador y solo mostrará los tickets
            } else {
                echo "<div class='contenedor-tickets'>";
                while ($fila = mysqli_fetch_assoc($query)){
                        echo "<div class='divticket'>";
                            echo "<h2 class='tituloticket'>Ticket Nº".$fila['ID']."</h2>";
                            echo "<h3 class='h3ticket'>✍️ Título: </h3><p>".$fila['titulo']."</p><br>";
                            echo "<h3 class='h3ticket'>📑 Tipo: </h3><p>".$fila['tipo']."</p><br>";
                            echo "<h3 class='h3ticket'>📝 Descripción: </h3><p>".$fila['descripcion']."</p><br>";
                            echo "<h3 class='h3ticket'>📅 Fecha: </h3><p>".$fila['fecha']."</p><br>";
                            echo "<h3 class='h3ticket'>🕐 Hora: </h3><p>".$fila['hora']."</p><br>";
                            echo "<h3 class='h3ticket'>👤 Solicitante: </h3><p>".$fila['solicitante']."</p><br>";
                        echo "</div>";
                }
                echo "</div>";
            }

        //Botones que nos muestran las págianas totales y las flechas para movernos entre la paginación
        if($query->num_rows>10){
            echo "<br><form action='#' method='POST'>";
                if($_SESSION['pag'] > 1){
                    echo "<input class='botonespags' type='submit' name='atras' value='🡰'>";
                }
                for($x=1;$x<=$pags;$x++){
                    echo "<input class='botonespags' type='submit' name='".$x."' value='".$x."'>";
                }
                if($_SESSION['pag'] < $pags){
                    echo "<input class='botonespags' type='submit' name='delante' value='🡲'>";
                }
            echo "</form>";
        }

        //Tres botones finales para redirigirnos a otras páginas
        echo "<div class=divbotonfinal>";
            echo "<a href='destruir-sesiones.php?redirigir=analisisadmin'><input class='botonfinal' type='submit' name='panel' value='Volver al panel'></a>";
            echo "<a href='destruir-sesiones.php?redirigir=index'><input class='botonfinal' type='submit' name='inicio' value='Volver al inicio'></a>";
            echo "<a href='graficas.php'><input class='botonfinal' type='button' value='Gráficas'></a>";
        echo "</div>";

        mysqli_close($conexion);
        
        //Else para que si no viene por POST muestre el formulario
    } else {
?>
<!-- Formulario principal -->
<body>
    <div class="general">
        <h1 class="tituloprincipal">Panel de administración de tickets</h1>
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

    <?php } ?>

</body>
</html>