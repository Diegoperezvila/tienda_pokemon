<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light p-3 pb-0 m-0">
    <div class="container-fluid m-0">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
            <a class="navbar-brand text-dark" href="../">
                <img src="../img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
            </a>
            <span class="ms-2 d-block text-center text-white text-lg-start">Bienvenido, <?php echo $_SESSION['usuario']; ?>!</span>
        </div>


        <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="../tienda/">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../wallet/"><i class="bi bi-wallet2 mx-1"></i><span id="wallet"></span>€</a>
                </li>
                <!-- Mostrar si es rol admin -->
                <?php if ($_SESSION['rol'] == "admin"): ?>
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-white" href="../admin/">Admin</a>
                </li>
                <?php endif; ?>
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-white" href="../cerrarSesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-flex">
            <!-- Mostrar si es rol admin -->
    <?php if ($_SESSION['rol'] == "admin"): ?>
        <a href="../admin/">
            <button class="btn btnNav btn-sm me-2">Admin</button>
        </a>
    <?php endif; ?>
    <a href="../cerrarSesion.php" class="">
        <button class="btn btnNav btn-sm">Cerrar Sesión</button>
    </a>
</div>

    </div>
</nav>
<div class="container-fluid m-0 p-0 mt-2 mb-2">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 text-center">
            <h3>Pedidos <button class="btn btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters" aria-controls="offcanvasFilters">
                <i class="bi bi-filter-circle">Filtrar</i>
            </button></h3>
            <div class="row scroll" id="pedidos">
                <!-- Mostrar pedidos vía js -->
            </div>
        </div>
        <div class="col-12 col-md-6 text-center borde">
            <h3>Últimas Aperturas</h3>
            <div class="row scroll" id="aperturas">
                <!-- Mostrar aperturas vía js -->
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilters" aria-labelledby="offcanvasFiltersLabel">
    <div class="offcanvas-header">
        <h5>Filtrar Pedidos</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form>
        <div class="mb-3">
                <label for="orden" class="form-label">Orden</label>
                <select class="form-select" id="orden">
                    <option value="" selected>Selecciona el orden</option>
                    <option value="recientes">Más Recientes</option>
                    <option value="antiguos">Más Antiguos</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado">
                    <option value="" selected>Selecciona el estado</option>
                    <option value="pedido">Pedidos</option>
                    <option value="aceptado">Aceptado</option>
                    <option value="rechazado">Rechazado</option>
                    <option value="enviado">Enviado</option>
                    <option value="completado">Completado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        </form>
    </div>
</div>



<footer>
  <div class="container-fluid m-0 p-0">
        <div class="col-12 p-2 d-flex bg-dark flex-column align-items-center text-white">
        Powered by Diego Pérez Vila | 2º DAW | Aula Estudio
        </div>
    </div>
  </footer>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="mostrarSaldo.js"></script>
    <script src="mostrar.js"></script>
</body>
</html>
