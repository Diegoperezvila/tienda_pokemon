<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../");
    exit();
}
if (isset($_SESSION['rol'])) {
    if($_SESSION['rol']!="admin"){
        header("Location: ../");
        exit();
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Sobres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="gestionSobres.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light p-3 pb-0 m-0">
    <div class="container-fluid m-0">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
            <a class="navbar-brand text-dark" href="../">
                <img src="../../img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
            </a>
        </div>


        <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-white" href="../../">Usuario</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-white" href="../../cerrarSesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-flex">
            <a href="../../">
                <button class="btn btnNav btn-sm me-2">Usuario</button>
            </a>
            <a href="../../cerrarSesion.php">
                <button class="btn btnNav btn-sm">Cerrar Sesión</button>
            </a>
        </div>
    </div>
</nav>



<div class="container-fluid m-0 p-0 mt-2">
    <div class="col-12 m-0">
        <div class="row m-0" id="sobres">
            <!-- Mostrar sobres vía js -->
        </div>
    </div>
</div>


  <footer>
  <div class="container-fluid m-0 p-0">
        <div class="col-12 p-2 d-flex bg-dark flex-column align-items-center text-white">
            Powered by Diego Pérez Vila | 2º DAW | Aula Estudio
        </div>
    </div>
  </footer>


<script src="editarSobres.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
