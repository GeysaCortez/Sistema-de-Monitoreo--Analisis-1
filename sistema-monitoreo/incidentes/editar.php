<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = "SELECT * FROM incidentes
WHERE id_incidente='$id'";

$resultado = mysqli_query($conexion, $sql);

$incidente = mysqli_fetch_assoc($resultado);

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

    $sqlUpdate = "UPDATE incidentes SET

    tipo_incidente='$tipo',
    fecha='$fecha',
    hora='$hora',
    descripcion='$descripcion',
    estado='$estado',
    evidencia='$evidencia',
    id_camara='$id_camara'

    WHERE id_incidente='$id'
    ";

    mysqli_query($conexion, $sqlUpdate);

    /*
ACTUALIZAR ALERTA
SEGÚN ESTADO INCIDENTE
*/

    if (
        $estado == "Resuelto" ||
        $estado == "Cerrado"
    ) {

        $sqlAlerta = "UPDATE alertas SET

    estado='Atendida'

    WHERE id_incidente='$id'
    ";

        mysqli_query(
            $conexion,
            $sqlAlerta
        );
    } else {

        $sqlAlerta = "UPDATE alertas SET

    estado='Pendiente'

    WHERE id_incidente='$id'
    ";

        mysqli_query(
            $conexion,
            $sqlAlerta
        );
    }

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Incidente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Editar Incidente</h2>

                <form method="POST">

                    <select
                        class="form-control mb-3"
                        name="tipo_incidente">

                        <option value="Robo"
                            <?php if ($incidente['tipo_incidente'] == "Robo")
                                echo "selected"; ?>>
                            Robo
                        </option>

                        <option value="Pelea"
                            <?php if ($incidente['tipo_incidente'] == "Pelea")
                                echo "selected"; ?>>
                            Pelea
                        </option>

                        <option value="Accidente"
                            <?php if ($incidente['tipo_incidente'] == "Accidente")
                                echo "selected"; ?>>
                            Accidente
                        </option>

                        <option value="Vandalismo"
                            <?php if ($incidente['tipo_incidente'] == "Vandalismo")
                                echo "selected"; ?>>
                            Vandalismo
                        </option>

                        <option value="Otro"
                            <?php if ($incidente['tipo_incidente'] == "Otro")
                                echo "selected"; ?>>
                            Otro
                        </option>

                    </select>

                    <input
                        type="date"
                        class="form-control mb-3"
                        name="fecha"
                        value="<?php echo $incidente['fecha']; ?>"
                        required>

                    <input
                        type="time"
                        class="form-control mb-3"
                        name="hora"
                        value="<?php echo $incidente['hora']; ?>"
                        required>

                    <textarea
                        class="form-control mb-3"
                        name="descripcion"><?php
                                            echo $incidente['descripcion'];
                                            ?></textarea>

                    <input
                        class="form-control mb-3"
                        name="evidencia"
                        value="<?php echo $incidente['evidencia']; ?>">

                    <select
                        class="form-control mb-3"
                        name="estado">

                        <option value="Pendiente"
                            <?php if ($incidente['estado'] == "Pendiente")
                                echo "selected"; ?>>
                            Pendiente
                        </option>

                        <option value="En atención"
                            <?php if ($incidente['estado'] == "En atención")
                                echo "selected"; ?>>
                            En atención
                        </option>

                        <option value="Resuelto"
                            <?php if ($incidente['estado'] == "Resuelto")
                                echo "selected"; ?>>
                            Resuelto
                        </option>

                        <option value="Cerrado"
                            <?php if ($incidente['estado'] == "Cerrado")
                                echo "selected"; ?>>
                            Cerrado
                        </option>

                    </select>

                    <select
                        class="form-control mb-3"
                        name="id_camara">

                        <?php while ($camara = mysqli_fetch_assoc($camaras)) { ?>

                            <option
                                value="<?php echo $camara['id_camara']; ?>"

                                <?php
                                if (
                                    $incidente['id_camara']
                                    == $camara['id_camara']
                                )
                                    echo "selected";
                                ?>>

                                <?php echo $camara['nombre']; ?>

                            </option>

                        <?php } ?>

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