<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
/*
INCIDENTES POR TIPO
*/

$sqlIncidentes = mysqli_query(
    $conexion,

    "SELECT tipo_incidente,
COUNT(*) AS total

FROM incidentes

GROUP BY tipo_incidente"
);

$tipos = [];
$totales = [];

while ($row = mysqli_fetch_assoc(
    $sqlIncidentes
)) {

    $tipos[] =
        $row['tipo_incidente'];

    $totales[] =
        $row['total'];
}

/*
CAMARAS POR ZONA
*/

$sqlZonas = mysqli_query(
    $conexion,

    "SELECT zonas.nombre_zona,
COUNT(camaras.id_camara)
AS total

FROM zonas

LEFT JOIN camaras

ON zonas.id_zona =
camaras.id_zona

GROUP BY zonas.nombre_zona"
);

$zonas = [];
$totalCamaras = [];

while ($row = mysqli_fetch_assoc(
    $sqlZonas
)) {

    $zonas[] =
        $row['nombre_zona'];

    $totalCamaras[] =
        $row['total'];
}

/*
ALERTAS POR PRIORIDAD
*/

$sqlAlertas = mysqli_query(
    $conexion,

    "SELECT nivel_prioridad,
COUNT(*) AS total

FROM alertas

GROUP BY nivel_prioridad"
);

$prioridades = [];
$totalPrioridades = [];

while ($row = mysqli_fetch_assoc(
    $sqlAlertas
)) {

    $prioridades[] =
        $row['nivel_prioridad'];

    $totalPrioridades[] =
        $row['total'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Reportes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>
                Reportes Estadísticos
            </h2>

            <a href="../dashboard.php"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <div class="row">

            <!-- INCIDENTES -->
            <div class="col-12 mb-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h4 class="mb-4">
                            Incidentes por Tipo
                        </h4>

                        <canvas id="graficoIncidentes"
                            style="max-height:400px;">
                        </canvas>

                    </div>

                </div>

            </div>

            <!-- CAMARAS -->
            <div class="col-12 mb-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h4 class="mb-4">
                            Cámaras por Zona
                        </h4>

                        <canvas id="graficoZonas"
                            style="max-height:400px;">
                        </canvas>

                    </div>

                </div>

            </div>

            <!-- ALERTAS -->
            <div class="col-12 mb-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h4 class="mb-4">
                            Alertas por Prioridad
                        </h4>

                        <canvas id="graficoAlertas"
                            style="max-height:400px;">
                        </canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        /*
INCIDENTES
*/

        new Chart(
            document.getElementById(
                "graficoIncidentes"
            ), {
                type: 'bar',

                data: {

                    labels: <?php echo json_encode(
                                $tipos
                            ); ?>,

                    datasets: [{

                        label: 'Cantidad',

                        data: <?php echo json_encode(
                                    $totales
                                ); ?>

                    }]
                }
            });

        /*
        ZONAS
        */

        new Chart(
            document.getElementById(
                "graficoZonas"
            ), {
                type: 'pie',

                data: {

                    labels: <?php echo json_encode(
                                $zonas
                            ); ?>,

                    datasets: [{

                        data: <?php echo json_encode(
                                    $totalCamaras
                                ); ?>

                    }]
                }
            });

        /*
        ALERTAS
        */

        new Chart(
            document.getElementById(
                "graficoAlertas"
            ), {
                type: 'doughnut',

                data: {

                    labels: <?php echo json_encode(
                                $prioridades
                            ); ?>,

                    datasets: [{

                        data: <?php echo json_encode(
                                    $totalPrioridades
                                ); ?>

                    }]
                }
            });
    </script>

</body>

</html>