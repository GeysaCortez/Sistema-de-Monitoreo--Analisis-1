<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/conexion.php");
/** @var mysqli $conexion */
$sql = "SELECT usuarios.*, roles.nombre_rol
        FROM usuarios
        INNER JOIN roles
        ON usuarios.id_rol = roles.id_rol";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Gestión de Usuarios</h2>

            <a href="../dashboard.php"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <a href="agregar.php"
            class="btn btn-primary mb-3">
            Agregar Usuario
        </a>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Cargo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>

                            <tr>

                                <td>
                                    <?php echo $fila['id_usuario']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['nombre']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['apellido']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['usuario']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['cargo']; ?>
                                </td>

                                <td>
                                    <?php echo $fila['nombre_rol']; ?>
                                </td>

                                <td>

                                    <?php
                                    if ($fila['estado'] == "Activo") {
                                    ?>

                                        <span class="badge bg-success">
                                            Activo
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-danger">
                                            Inactivo
                                        </span>

                                    <?php } ?>

                                </td>

                                <td>

                                    <a href="editar.php?id=<?php echo $fila['id_usuario']; ?>"
                                        class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <a href="eliminar.php?id=<?php echo $fila['id_usuario']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar usuario?')">
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