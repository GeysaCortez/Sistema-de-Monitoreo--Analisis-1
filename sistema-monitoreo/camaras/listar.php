<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$sql = "SELECT camaras.*, zonas.nombre_zona
        FROM camaras
        INNER JOIN zonas
        ON camaras.id_zona = zonas.id_zona";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cámaras</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Gestión de Cámaras</h2>

            <a href="../dashboard.php"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <a href="agregar.php"
            class="btn btn-primary mb-3">
            Agregar Cámara
        </a>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>IP</th>
                            <th>Zona</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td><?php echo $fila['id_camara']; ?></td>

                                <td><?php echo $fila['nombre']; ?></td>

                                <td><?php echo $fila['ubicacion']; ?></td>

                                <td><?php echo $fila['direccion_ip']; ?></td>

                                <td><?php echo $fila['nombre_zona']; ?></td>

                                <td>

                                    <?php
                                    if ($fila['estado'] == "Activa") {
                                    ?>

                                        <span class="badge bg-success">
                                            Activa
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-secondary">
                                            Inactiva
                                        </span>

                                    <?php } ?>

                                </td>

                                <td><?php echo $fila['fecha_instalacion']; ?></td>

                                <td>

                                    <a href="editar.php?id=<?php echo $fila['id_camara']; ?>"
                                        class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <a href="eliminar.php?id=<?php echo $fila['id_camara']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar cámara?')">
                                        Eliminar
                                    </a>

                                    <a href="ver.php?id=<?php echo $fila['id_camara'];?>"

                                        class="btn btn-info btn-sm">

                                        Ver cámara

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