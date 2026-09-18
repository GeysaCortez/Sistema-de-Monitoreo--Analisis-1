<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "SELECT * FROM zonas
WHERE id_zona='$id'";

$resultado = mysqli_query($conexion, $sql);

$zona = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre_zona'];
    $descripcion = $_POST['descripcion'];
    $riesgo = $_POST['nivel_riesgo'];

    $sqlUpdate = "UPDATE zonas SET

    nombre_zona='$nombre',
    descripcion='$descripcion',
    nivel_riesgo='$riesgo'

    WHERE id_zona='$id'
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
    <title>Editar Zona</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Editar Zona</h2>

                <form method="POST">

                    <input
                        class="form-control mb-3"
                        name="nombre_zona"
                        value="<?php echo $zona['nombre_zona']; ?>"
                        required>

                    <textarea
                        class="form-control mb-3"
                        name="descripcion"><?php echo $zona['descripcion']; ?></textarea>

                    <select
                        class="form-control mb-3"
                        name="nivel_riesgo">

                        <option value="Bajo"
                            <?php if ($zona['nivel_riesgo'] == "Bajo") echo "selected"; ?>>
                            Bajo
                        </option>

                        <option value="Medio"
                            <?php if ($zona['nivel_riesgo'] == "Medio") echo "selected"; ?>>
                            Medio
                        </option>

                        <option value="Alto"
                            <?php if ($zona['nivel_riesgo'] == "Alto") echo "selected"; ?>>
                            Alto
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