<?php
session_start();

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$camaras = mysqli_query(
    $conexion,
    "SELECT * FROM camaras"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipo = $_POST['tipo_incidente'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $evidencia = $_POST['evidencia'];
    $id_camara = $_POST['id_camara'];

    $id_usuario = $_SESSION['id_usuario'];

    $sql = "INSERT INTO incidentes
    (
        tipo_incidente,
        fecha,
        hora,
        descripcion,
        estado,
        evidencia,
        id_camara,
        id_usuario
    )

    VALUES
    (
        '$tipo',
        '$fecha',
        '$hora',
        '$descripcion',
        '$estado',
        '$evidencia',
        '$id_camara',
        '$id_usuario'
    )";

    mysqli_query($conexion, $sql);

    $id_incidente =
        mysqli_insert_id($conexion);

    // ALERTA AUTOMÁTICA

    $prioridad = "Baja";

    if (
        $tipo == "Robo" ||
        $tipo == "Accidente"
    ) {

        $prioridad = "Alta";
    } elseif (
        $tipo == "Pelea" ||
        $tipo == "Vandalismo"
    ) {

        $prioridad = "Media";
    }

    $sqlAlerta = "INSERT INTO alertas
    (
        tipo_alerta,
        nivel_prioridad,
        id_incidente
    )

    VALUES
    (
        '$tipo',
        '$prioridad',
        '$id_incidente'
    )";

    mysqli_query($conexion, $sqlAlerta);

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Incidente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Registrar Incidente</h2>

                <form method="POST">

                    <select
                        class="form-control mb-3"
                        name="tipo_incidente"
                        required>

                        <option value="">
                            Seleccione tipo
                        </option>

                        <option>Robo</option>
                        <option>Pelea</option>
                        <option>Accidente</option>
                        <option>Vandalismo</option>
                        <option>Otro</option>

                    </select>

                    <input
                        type="date"
                        class="form-control mb-3"
                        name="fecha"
                        required>

                    <input
                        type="time"
                        class="form-control mb-3"
                        name="hora"
                        required>

                    <textarea
                        class="form-control mb-3"
                        name="descripcion"
                        placeholder="Descripción">
</textarea>

                    <input
                        class="form-control mb-3"
                        name="evidencia"
                        placeholder="Ruta evidencia">

                    <select
                        class="form-control mb-3"
                        name="estado">

                        <option>Pendiente</option>
                        <option>En atención</option>
                        <option>Resuelto</option>

                    </select>

                    <select
                        class="form-control mb-3"
                        name="id_camara"
                        required>

                        <option value="">
                            Seleccione cámara
                        </option>

                        <?php while ($camara = mysqli_fetch_assoc($camaras)) { ?>

                            <option value="<?php echo $camara['id_camara']; ?>">

                                <?php echo $camara['nombre']; ?>

                            </option>

                        <?php } ?>

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