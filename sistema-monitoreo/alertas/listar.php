<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$sql = "SELECT
        alertas.*,
        incidentes.tipo_incidente

        FROM alertas

        INNER JOIN incidentes
        ON alertas.id_incidente =
        incidentes.id_incidente

        ORDER BY id_alerta DESC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Alertas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Gestión de Alertas</h2>

            <a href="../dashboard.php"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Tipo de Alerta</th>
                            <th>Prioridad</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Incidente</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td>
                                    <?php echo $fila['id_alerta']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['tipo_alerta']; ?>
                                </td>

                                <td>

                                    <?php
                                    if ($fila['nivel_prioridad'] == "Alta") {
                                    ?>

                                        <span class="badge bg-danger">
                                            Alta
                                        </span>

                                    <?php } elseif ($fila['nivel_prioridad'] == "Media") { ?>

                                        <span class="badge bg-warning text-dark">
                                            Media
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-success">
                                            Baja
                                        </span>

                                    <?php } ?>

                                </td>

                                <td>
                                    <?php echo $fila['fecha_generacion']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['estado']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['tipo_incidente']; ?>
                                </td>

                                <td>

                                    <a href="editar.php?id=<?php echo $fila['id_alerta']; ?>"
                                        class="btn btn-warning btn-sm">
                                        Cambiar Estado
                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>