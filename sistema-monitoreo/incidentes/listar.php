<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$sql = "SELECT
        incidentes.*,
        camaras.nombre AS camara_nombre,
        usuarios.nombre AS usuario_nombre

        FROM incidentes

        LEFT JOIN camaras
        ON incidentes.id_camara = camaras.id_camara

        LEFT JOIN usuarios
        ON incidentes.id_usuario = usuarios.id_usuario

        ORDER BY id_incidente DESC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Incidentes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Gestión de Incidentes</h2>

            <a href="../dashboard.php"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <a href="agregar.php"
            class="btn btn-primary mb-3">
            Registrar Incidente
        </a>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cámara</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td><?php echo $fila['id_incidente']; ?></td>

                                <td><?php echo $fila['tipo_incidente']; ?></td>

                                <td><?php echo $fila['fecha']; ?></td>

                                <td><?php echo $fila['hora']; ?></td>

                                <td><?php echo $fila['camara_nombre']; ?></td>

                                <td><?php echo $fila['usuario_nombre']; ?></td>

                                <td>

                                    <?php
                                    if ($fila['estado'] == "Pendiente") {
                                    ?>

                                        <span class="badge bg-danger">
                                            Pendiente
                                        </span>

                                    <?php } elseif (
                                        $fila['estado'] == "En atención"
                                    ) { ?>

                                        <span class="badge bg-warning text-dark">
                                            En atención
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-success">
                                            <?php echo $fila['estado']; ?>
                                        </span>

                                    <?php } ?>

                                </td>

                                <td>

                                    <a href="editar.php?id=<?php echo $fila['id_incidente']; ?>"
                                        class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <a href="eliminar.php?id=<?php echo $fila['id_incidente']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar incidente?')">
                                        Eliminar
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