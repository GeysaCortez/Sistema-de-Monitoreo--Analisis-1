<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "SELECT * FROM alertas
WHERE id_alerta='$id'";

$resultado = mysqli_query($conexion, $sql);

$alerta = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $estado = $_POST['estado'];

    $sqlUpdate = "UPDATE alertas SET

    estado='$estado'

    WHERE id_alerta='$id'
    ";

    mysqli_query($conexion, $sqlUpdate);

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Alerta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Cambiar Estado de Alerta</h2>

                <form method="POST">

                    <select
                        class="form-control mb-3"
                        name="estado">

                        <option value="Pendiente"
                            <?php if ($alerta['estado'] == "Pendiente")
                                echo "selected"; ?>>
                            Pendiente
                        </option>

                        <option value="Enviada"
                            <?php if ($alerta['estado'] == "Enviada")
                                echo "selected"; ?>>
                            Enviada
                        </option>

                        <option value="Atendida"
                            <?php if ($alerta['estado'] == "Atendida")
                                echo "selected"; ?>>
                            Atendida
                        </option>

                    </select>

                    <button class="btn btn-warning">
                        Actualizar
                    </button>

                    <a href="listar.php"
                        class="btn btn-secondary">
                        Volver
                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>