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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>

<?php if (!$registrado): ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-3 pb-0 m-0">
        <div class="container-fluid m-0">
            <a class="navbar-brand d-flex align-items-center" href="./">
                <img src="img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
            </a>

            <a href="registro/" class="order-lg-1">
                <button class="btn btn-primary btn-sm">Registro</button>
            </a>

            <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center p-5 p-lg-0" id="navbarContent">
                <form class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 mx-auto" id="inicioForm">
                    <input type="text" class="form-control form-control-sm" id="inputUser" placeholder="Usuario">
                    <input type="password" class="form-control form-control-sm" id="inputPassword" placeholder="Contraseña">
                    <button type="submit" class="btn btn-primary btn-sm">Login</button>
                </form>
            </div>
        </div>
    </nav>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-3 pb-0 m-0">
    <div class="container-fluid m-0">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
            <a class="navbar-brand text-dark" href="./">
                <img src="img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
            </a>
            <span class="ms-2 d-block text-center text-lg-start">Bienvenido, <?php echo $_SESSION['usuario']; ?>!</span>
        </div>


        <button class="navbar-toggler order-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="./tienda/">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="perfil.php">Perfil</a>
                </li>
                <?php if ($_SESSION['rol'] == "admin"): ?>
                    <li class="nav-item">
                    <a class="nav-link text-dark" href="./admin/">Continuar como admin</a>
                </li>
                <?php endif; ?>
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-danger" href="./cerrarSesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-flex">
            <a href="./cerrarSesion.php">
                <button class="btn btn-danger btn-sm">Cerrar Sesión</button>
            </a>
        </div>
    </div>
</nav>


<?php endif; ?>


<div class="container-fluid m-0 p-0">
    <div class="row g-0 p-5 d-flex align-items-center justify-content-center text-center" style="background-color: black;">
        <div class="col-12 col-md-5 p-2 d-flex flex-column align-items-center align-items-md-start text-md-start text-white">
            <h1>AMPLIA TU MUNDO DE POKEMON TCG</h1>
            <h3>Abre sobres y llévate las mejores cartas</h3>
            <a href="./tienda/"><button class="btn btn-primary btn-sm mt-3">Abrir Sobres</button></a>
            
        </div>
    
        <div class="col-12 col-md-5 d-none d-md-flex justify-content-center">
            <img src="img/evolucionesPrismaticas.png" alt="Evoluciones Prismáticas" class="img-fluid" style="max-width:300px;">
        </div>
    </div>
</div>

<div class="carrusel-container">
    <div class="carrusel">
        <a href="#"><img src="img/evolucionesPrismaticas.png" alt="evolucionesPrismaticas"></a>
        <a href="#"><img src="img/chispasFulgrulantes.png" alt="chispasFulgrulantes"></a>
        <a href="#"><img src="img/coronaAstral.png" alt="coronaAstral"></a>
        <a href="#"><img src="img/fabulaSombria.png" alt="fabulaSombria"></a>
        <a href="#"><img src="img/mascaradaCrepuscular.png" alt="mascaradaCrepuscular"></a>
        <a href="#"><img src="img/fuerzasTemporales.png" alt="fuerzasTemporales"></a>
        <a href="#"><img src="img/destinosPaldea.png" alt="destinosPaldea"></a>
        <a href="#"><img src="img/brechaParadojica.png" alt="brechaParadojica"></a>
        <a href="#"><img src="img/151.png" alt="151"></a>
        <a href="#"><img src="img/llamasObsidianas.png" alt="llamasObsidianas"></a>
        <a href="#"><img src="img/evolucionesPaldea.png" alt="evolucionesPaldea"></a>
        <a href="#"><img src="img/escarlataPurpura.png" alt="escarlataPurpura"></a>
    </div>
  </div>

  <div class="container-fluid m-0 p-0">
    <div class="row p-5 m-0">
        <div class="col-12 col-md-6 p-3">
            <h2 class="text-center">Formulario de Contacto</h2>
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>

        <div class="col-12 col-md-6 p-3">
            <h2 class="text-center">Preguntas Frecuentes (FAQ)</h2>
            <div class="accordion mt-4" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeading1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                            ¿Cómo abro un sobre?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Para abrir un sobre, debes ir a la sección de "Dashboard" y hacer clic en el botón "Abrir Sobres". Ahí podrás elegir qué sobre deseas abrir.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeading2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            ¿Cómo puedo ver mi perfil?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Puedes ver tu perfil haciendo clic en el enlace "Perfil" en la barra de navegación, al lado de tu nombre.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeading3">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            ¿Qué es el sistema de puntos?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            El sistema de puntos te permite ganar recompensas dentro del sitio al realizar actividades como abrir sobres o interactuar con contenido.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  <footer>
  <div class="container-fluid m-0 p-0">
        <div class="col-12 p-2 d-flex bg-dark flex-column align-items-center text-white">
            crewgfer
        </div>
    </div>
  </footer>


<script src="procesarLogin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
