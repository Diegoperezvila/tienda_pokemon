<?php
session_start();
$registrado = false;
if (isset($_SESSION['usuario'])) {
    $registrado = true;
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
    <link rel="stylesheet" href="probabilidades.css">
</head>
<body>
<?php if (!$registrado): ?>
    <nav class="navbar navbar-expand-lg navbar-light p-3 pb-0 m-0">
        <div class="container-fluid m-0">
            <a class="navbar-brand d-flex align-items-center" href="../">
                <img src="../img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
            </a>

            <a href="registro/" class="order-lg-1">
                <button class="btn btnNav btn-sm">Registro</button>
            </a>

            <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center p-5 p-lg-0" id="navbarContent">
                <form class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 mx-auto" id="inicioForm">
                    <input type="text" class="form-control form-control-sm" id="inputUser" placeholder="Usuario">
                    <input type="password" class="form-control form-control-sm" id="inputPassword" placeholder="Contraseña">
                    <button type="submit" class="btn btnNav btn-sm">Login</button>
                </form>
            </div>
        </div>
    </nav>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-light p-3 pb-0 m-0">
    <div class="container-fluid m-0">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
            <a class="navbar-brand text-dark" href="./">
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
                    <a class="nav-link text-white" href="./">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="wallet.php"><i class="bi bi-wallet2 mx-1"></i><span id="wallet"></span></a>
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
            <a href="../cerrarSesion.php">
                <button class="btn btnNav btn-sm">Cerrar Sesión</button>
            </a>
        </div>
    </div>
</nav>


<?php endif; ?>


<div class="container mt-5">
    <h2 class="text-center">PROBABILIDADES</h2>
    <div class="row mb-3" id="probabilidades" class="d-flex justify-content-center">

    </div>

    <h2 class="text-center">CARTAS</h2>
    <div class="row" id="cartas" class="d-flex justify-content-center">

    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="probabilidades.js"></script>
    <script src="mostrarSaldo.js"></script>
</body>
</html>
