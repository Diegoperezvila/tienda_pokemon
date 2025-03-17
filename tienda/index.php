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
    <title>Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="tienda.css">
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
                    <a class="nav-link text-white" href="#">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../perfil.php">Perfil</a>
                </li>
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
    <div class="container mt-5">
        <div class="row" id="divTienda">
            
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="modalSobre" tabindex="-1" aria-labelledby="modalSobreLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSobreLabel">Imagen del Sobre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center flex-column">
        <!-- Imagen del sobre inicial que será reemplazada -->
        <img id="modalImg" src="../img/ejemplo.png" alt="Sobre" class="img-fluid" style="cursor: pointer; max-height: 300px; max-width: auto; object-fit: contain;">
        
        <!-- Contenedor para la información de la carta -->
        <div id="cardInfo" class="mt-3 text-center">
          <!-- Aquí se mostrará la info de la carta -->
        </div>
      </div>
    </div>
  </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="verSobres.js"></script>
</body>
</html>
