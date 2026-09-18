<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre_zona'];
    $descripcion = $_POST['descripcion'];
    $riesgo = $_POST['nivel_riesgo'];

    /*
VALIDAR ZONA DUPLICADA
*/

    $verificar = mysqli_query(
        $conexion,

        "SELECT * FROM zonas
    WHERE nombre_zona='$nombre'"
    );

    if (mysqli_num_rows($verificar) > 0) {

        echo "
    <script>
    alert('La zona ya existe');
    window.history.back();
    </script>
    ";

        exit();
    }

    $sql = "INSERT INTO zonas
    (nombre_zona, descripcion, nivel_riesgo)

    VALUES

    (
        '$nombre',
        '$descripcion',
        '$riesgo'
    )";

    mysqli_query($conexion, $sql);

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Zona</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Agregar Zona</h2>

                <form method="POST">

                    <input
                        class="form-control mb-3"
                        name="nombre_zona"
                        placeholder="Nombre de zona"
                        required>

                    <textarea
                        class="form-control mb-3"
                        name="descripcion"
                        placeholder="Descripción">
</textarea>

                    <select
                        class="form-control mb-3"
                        name="nivel_riesgo">

                        <option>Bajo</option>
                        <option>Medio</option>
                        <option>Alto</option>

                    </select>

                    <button class="btn btn-success">
                        Guardar
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