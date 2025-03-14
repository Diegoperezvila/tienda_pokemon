<?php
session_start();
if (isset($_SESSION['rol'])) {
    if($_SESSION['rol']=="admin")
    header("Location: ../admin");
    exit();
}
if (isset($_SESSION['usuario'])) {
    header("Location: ../");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white d-flex justify-content-center align-items-center min-vh-100">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="p-4 shadow-lg">
                    <div class="text-center mb-4">
                        <img src="../img/logo.png" alt="Logo" class="img-fluid" style="max-width: 200px;">
                    </div>

                    <h2 class="text-center mb-4">Registrarse</h2>
                    <form id="registroForm">
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Tu nombre" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" placeholder="Tu apellido" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" placeholder="Tu usuario" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" placeholder="correo@ejemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" minlength="8" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirma tu contraseña" required>
                            <div id="passwordError" class="text-danger mt-1" style="display: none;">Las contraseñas no coinciden</div>
                            <div id="mensaje" class="text-center mt-3"></div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-dark w-100" disabled>Registrarse</button>
                    </form>
                </div>
                <a href="../"><button class="btn btn-primary btn-sm mt-3">Inicio</button></a>
            </div>
        </div>
    </div>

    <script src="procesarRegistro.js"></script>
    <script src="validarForm.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
