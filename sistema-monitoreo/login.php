<?php
session_start();
include("config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    /* Hariamos un cambio para una contraseña segura
    ENCRIPATADA

    $sql = "SELECT * FROM usuarios 
            WHERE usuario = '$usuario'
            AND password = '$password'
            AND estado = 'Activo'";

    Quitamos el password porque ahora la contraseña
    se validará con hash
    */
    $sql = "SELECT * FROM usuarios 
            WHERE usuario = '$usuario'";

    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);

        if (
            password_verify(
                $password,
                $datos['password']
            )
        ) {

            $_SESSION['id_usuario'] =
                $datos['id_usuario'];

            $_SESSION['nombre'] =
                $datos['nombre'];

            $_SESSION['rol'] =
                $datos['id_rol'];

            header("Location: dashboard.php");
            exit();
        } else {

            $error =
                "Usuario o contraseña incorrectos";
        }
    } else {

        $error =
            "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Monitoreo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center mt-5">

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-header text-center">
                        <h3>Iniciar Sesión</h3>
                    </div>

                    <div class="card-body">

                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                        <form method="POST">

                            <div class="mb-3">
                                <label>Usuario</label>
                                <input
                                    type="text"
                                    name="usuario"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary w-100">
                                Ingresar
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>