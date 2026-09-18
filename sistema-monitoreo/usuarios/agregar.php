<?php
session_start();
include("../config/conexion.php");
/** @var mysqli $conexion */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    # Encriptamos la contraseña antes de guardarla en la base de datos
    $password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );
    $estado = $_POST['estado'];
    $id_rol = $_POST['id_rol'];

    /*
VALIDAR USUARIO REPETIDO
*/

    $verificar = mysqli_query(
        $conexion,

        "SELECT * FROM usuarios
    WHERE usuario='$usuario'"
    );

    if (mysqli_num_rows($verificar) > 0) {

        echo "
    <script>
    alert('El usuario ya existe');
    window.history.back();
    </script>
    ";

        exit();
    }

    $sql = "INSERT INTO usuarios
    (nombre, apellido, cargo, usuario, password, estado, id_rol)

    VALUES

    ('$nombre',
    '$apellido',
    '$cargo',
    '$usuario',
    '$password',
    '$estado',
    '$id_rol')";

    mysqli_query($conexion, $sql);

    header("Location: listar.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Agregar Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body">

                <h2>Agregar Usuario</h2>

                <form method="POST">

                    <input class="form-control mb-3"
                        name="nombre"
                        placeholder="Nombre"
                        required>

                    <input class="form-control mb-3"
                        name="apellido"
                        placeholder="Apellido"
                        required>

                    <input class="form-control mb-3"
                        name="cargo"
                        placeholder="Cargo">

                    <input class="form-control mb-3"
                        name="usuario"
                        placeholder="Usuario"
                        required>

                    <input type="password"
                        class="form-control mb-3"
                        name="password"
                        placeholder="Contraseña"
                        required>

                    <select class="form-control mb-3"
                        name="estado">

                        <option>Activo</option>
                        <option>Inactivo</option>

                    </select>

                    <select class="form-control mb-3"
                        name="id_rol">

                        <option value="1">
                            Administrador
                        </option>

                        <option value="2">
                            Operador
                        </option>

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