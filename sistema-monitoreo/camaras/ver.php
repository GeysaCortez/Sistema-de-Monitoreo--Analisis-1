<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/conexion.php");
/** @var mysqli $conexion */
$id = $_GET['id'];

$sql = mysqli_query(

    $conexion,

    "SELECT camaras.*,
    zonas.nombre_zona

    FROM camaras

    LEFT JOIN zonas
    ON camaras.id_zona =
    zonas.id_zona

    WHERE id_camara='$id'"
);

$camara =
    mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Ver Cámara
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-dark text-white">

    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-4">

            <h2>

                <?php
                echo $camara['nombre'];
                ?>

            </h2>

            <a href="listar.php"
                class="btn btn-secondary">

                Volver

            </a>

        </div>

        <div class="card bg-black border-secondary">

            <div class="card-body text-center">

                <img
                    src="<?php
                            echo $camara['url_stream'];
                            ?>"

                    class="img-fluid rounded"

                    style="
max-height:650px;
width:100%;
object-fit:cover;
">

            </div>

        </div>

        <div class="row mt-4">

            <div class="col-md-4">

                <div class="card bg-secondary">

                    <div class="card-body">

                        <h5>Zona</h5>

                        <p>
                            <?php
                            echo $camara['nombre_zona'];
                            ?>
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card bg-secondary">

                    <div class="card-body">

                        <h5>IP</h5>

                        <p>
                            <?php
                            echo $camara['direccion_ip'];
                            ?>
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card bg-secondary">

                    <div class="card-body">

                        <h5>Estado</h5>

                        <p>
                            <?php
                            echo $camara['estado'];
                            ?>
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>