<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$sql = "SELECT * FROM zonas";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Zonas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Gestión de Zonas</h2>

            <a href="../dashboard.php"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <a href="agregar.php"
            class="btn btn-primary mb-3">
            Agregar Zona
        </a>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Zona</th>
                            <th>Descripción</th>
                            <th>Nivel de Riesgo</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td>
                                    <?php echo $fila['id_zona']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['nombre_zona']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['descripcion']; ?>
                                </td>

                                <td>

                                    <?php
                                    if ($fila['nivel_riesgo'] == "Alto") {
                                    ?>

                                        <span class="badge bg-danger">
                                            Alto
                                        </span>

                                    <?php } elseif (
                                        $fila['nivel_riesgo'] == "Medio"
                                    ) { ?>

                                        <span class="badge bg-warning text-dark">
                                            Medio
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-success">
                                            Bajo
                                        </span>

                                    <?php } ?>

                                </td>

                                <td>

                                    <a href="editar.php?id=<?php echo $fila['id_zona']; ?>"
                                        class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <a href="eliminar.php?id=<?php echo $fila['id_zona']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar zona?')">
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