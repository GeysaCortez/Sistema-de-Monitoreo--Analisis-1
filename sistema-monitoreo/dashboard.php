<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

require_once("config/conexion.php");

$totalUsuarios = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT * FROM usuarios"
    )
);

$totalCamaras = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT * FROM camaras"
    )
);

$totalIncidentes = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT * FROM incidentes"
    )
);

$totalAlertas = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT * FROM alertas
    WHERE estado='Pendiente'"
    )
);

$camarasActivas = mysqli_num_rows(
    mysqli_query(
        $conexion,
        "SELECT * FROM camaras
    WHERE estado='Activa'"
    )
);

$incidentesRecientes = mysqli_query(
    $conexion,

    "SELECT incidentes.*,
camaras.nombre AS camara_nombre

FROM incidentes

LEFT JOIN camaras
ON incidentes.id_camara =
camaras.id_camara

ORDER BY id_incidente DESC
LIMIT 5"
);

$alertasRecientes = mysqli_query(
    $conexion,

    "SELECT *
FROM alertas
ORDER BY id_alerta DESC
LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="assets/css/estilos.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <div class="sidebar">

        <div class="logo-sistema">

            <h3>
                <i class="bi bi-shield-lock-fill"></i>
                Monitoreo Urbano
            </h3>

            <p>
                Sistema de Seguridad
            </p>

        </div>

        <a class="active"
            href="dashboard.php">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </a>

        <a href="usuarios/listar.php">

            <i class="bi bi-people-fill"></i>

            Usuarios

        </a>

        <a href="zonas/listar.php">

            <i class="bi bi-geo-alt-fill"></i>

            Zonas

        </a>

        <a href="camaras/listar.php">

            <i class="bi bi-camera-video-fill"></i>

            Cámaras

        </a>

        <a href="incidentes/listar.php">

            <i class="bi bi-exclamation-triangle-fill"></i>

            Incidentes

        </a>

        <a href="alertas/listar.php">

            <i class="bi bi-bell-fill"></i>

            Alertas

        </a>

        <a href="reportes/reportes.php">

            <i class="bi bi-bar-chart-fill"></i>

            Reportes

        </a>

        <a href="logout.php">

            <i class="bi bi-box-arrow-right"></i>

            Cerrar sesión

        </a>

    </div>

    <div class="main-content">

        <div class="d-flex justify-content-between mb-4">

            <h2>
                Panel de Monitoreo Urbano
            </h2>

            <h5>
                Bienvenido,
                <?php echo $_SESSION['nombre']; ?>
            </h5>

        </div>

        <div class="row">

            <div class="col-md-3 mb-4">

                <div class="card text-white bg-primary card-dashboard">

                    <div class="card-body text-center">

                        <h1>
                            <?php echo $totalUsuarios; ?>
                        </h1>

                        <h5>Usuarios</h5>

                    </div>

                </div>

            </div>

            <div class="col-md-3 mb-4">

                <div class="card text-white bg-success card-dashboard">

                    <div class="card-body text-center">

                        <h1>
                            <?php echo $camarasActivas; ?>
                        </h1>

                        <h5>Cámaras Activas</h5>

                    </div>

                </div>

            </div>

            <div class="col-md-3 mb-4">

                <div class="card text-white bg-warning card-dashboard">

                    <div class="card-body text-center">

                        <h1>
                            <?php echo $totalIncidentes; ?>
                        </h1>

                        <h5>Incidentes</h5>

                    </div>

                </div>

            </div>

            <div class="col-md-3 mb-4">

                <div class="card text-white bg-danger card-dashboard">

                    <div class="card-body text-center">

                        <h1>
                            <?php echo $totalAlertas; ?>
                        </h1>

                        <h5>Alertas Pendientes</h5>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-7">

                <div class="card shadow mb-4">

                    <div class="card-header bg-dark text-white">
                        Incidentes Recientes
                    </div>

                    <div class="card-body">

                        <table class="table table-hover">

                            <thead>

                                <tr>
                                    <th>Tipo</th>
                                    <th>Cámara</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php while ($incidente =
                                    mysqli_fetch_assoc(
                                        $incidentesRecientes
                                    )
                                ) { ?>

                                    <tr>

                                        <td>
                                            <?php echo $incidente['tipo_incidente']; ?>
                                        </td>

                                        <td>
                                            <?php echo $incidente['camara_nombre']; ?>
                                        </td>

                                        <td>
                                            <?php echo $incidente['estado']; ?>
                                        </td>

                                        <td>
                                            <?php echo $incidente['fecha']; ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="col-md-5">

                <div class="card shadow">

                    <div class="card-header bg-danger text-white">
                        Alertas Recientes
                    </div>

                    <div class="card-body">

                        <ul class="list-group">

                            <?php while ($alerta =
                                mysqli_fetch_assoc(
                                    $alertasRecientes
                                )
                            ) { ?>

                                <li class="list-group-item">

                                    <strong>
                                        <?php echo $alerta['tipo_alerta']; ?>
                                    </strong>

                                    <br>

                                    Prioridad:

                                    <?php echo
                                    $alerta['nivel_prioridad'];
                                    ?>

                                    <br>

                                    Estado:

                                    <?php echo
                                    $alerta['estado'];
                                    ?>

                                </li>

                            <?php } ?>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>