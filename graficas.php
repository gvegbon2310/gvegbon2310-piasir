<?php
include 'conectar.php';

$mostrarform = !isset($_POST['tipoticket']);
$datos = [];

if (!$mostrarform && isset($_POST['tipoticket'])) {
    // Dato que viene del formulario
    $tipoticket = $_POST['tipoticket'];

    // Array para consulta SQL
    $meses = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

    // Consulta SQL para contar cuantos registros hay y así representarlos en una gráfica
    if ($tipoticket == "todos") {
        $sql = "SELECT tipo, COUNT(*) AS total FROM tickets GROUP BY tipo";
        echo "<h1 class='h1principal'>Todos los tickets</h1>";
    } elseif (in_array($tipoticket, $meses)) {
        $sql = "SELECT tipo, COUNT(*) AS total FROM tickets WHERE MONTH(fecha) = '$tipoticket' GROUP BY tipo";
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
        echo "<h1 class='h1principal'>Todos los tickets del mes de " . $arraymesesp[$tipoticket] . "</h1>";
    }

    $query = mysqli_query($conexion, $sql);

    if ($query) {
        $datos[] = ['Tipo de Ticket', 'Cantidad'];
        while ($fila = mysqli_fetch_assoc($query)) {
            $datos[] = [$fila['tipo'], (int)$fila['total']];
        }
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./styles/estilo-graficas.css" />
    <title>Visualizando gráficas...</title>
    <style>
        /* PONER EN estilo-graficas.css???????????*/
        #contenedor_graficas {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 30px auto;
            max-width: 1000px;
        }
        .grafica {
            width: 450px;
            height: 450px;
        }
    </style>
</head>
<body>
<?php if($mostrarform){ ?>
        <!-- Formulario que se mostrará al administrador para elegir el filtro de las gráficas -->
        <div class="general">
        <h1 class="tituloprincipal">Panel de administración de tickets (gráficas)</h1>
        <form action="#" method="post">
            <label>Elige el filtrado para las gráficas: </label><br>
            <select name="tipoticket" required>
                <option value="" disabled selected>-- Escoge una opción --</option>
                <option value="todos">Todos los tickets</option>
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

<?php if (isset($datos) && count($datos) > 1) { ?>
    <div id="contenedor_graficas">
        <div id="grafica_donut" class="grafica"></div>
        <div id="grafica_barras" class="grafica"></div>
    </div>

    <!-- Scripts necesarios para linkear el javascript necesario para representar las gráficas -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(dibujarGraficas);

        // Función que dibjua las gráficas y las adapta con estilo
        function dibujarGraficas() {
            var datos = google.visualization.arrayToDataTable(<?php echo json_encode($datos); ?>);

            // Gráfica circular
            var opcionesDonut = {
                title: 'Cantidad de tickets por tipo',
                pieHole: 0.4,
                width: 450,
                height: 450,
                titleTextStyle: {
                    fontSize: 18,
                    bold: true
                }
            };
            var graficaDonut = new google.visualization.PieChart(document.getElementById('grafica_donut'));
            graficaDonut.draw(datos, opcionesDonut);

            // Gráfica de barras
            var opcionesBarras = {
                title: 'Cantidad de tickets por tipo',
                width: 450,
                height: 450,
                titleTextStyle: {
                    fontSize: 18,
                    bold: true
                },
                legend: { position: 'none' },
                hAxis: {
                    title: 'Tipo de Ticket'
                },
                vAxis: {
                    title: 'Cantidad'
                },
                bars: 'vertical'
            };
            var graficaBarras = new google.visualization.ColumnChart(document.getElementById('grafica_barras'));
            graficaBarras.draw(datos, opcionesBarras);
        }
    </script>

    <?php
    // Botones para volver iguales al panel de administración de tickets
    echo "<a href='graficas.php'><input class='botonfinal' type='button' name='Volver atrás' value='Volver al panel'></a>";
    echo "<a href='index.html'><input class='botonfinal' type='button' value='Volver al inicio'></a>";
    echo "<a href='analisisadmin.php'><input class='botonfinal' type='button' value='Tickets'></a>";
    }
    ?>
</body>
</html>