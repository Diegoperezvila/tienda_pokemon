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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
<!-- Mostrar si no esta registrado -->
<?php if (!$registrado): ?>
    <nav class="navbar navbar-expand-lg navbar-light p-3 pb-0 m-0">
        <div class="container-fluid m-0">
            <a class="navbar-brand d-flex align-items-center" href="./">
                <img src="img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
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
<?php else: ?> <!-- Mostrar si está registrado -->
<nav class="navbar navbar-expand-lg navbar-light p-3 pb-0 m-0">
    <div class="container-fluid m-0">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
            <a class="navbar-brand text-dark" href="./">
                <img src="img/logo.png" alt="Logo" height="75" class="d-inline-block align-top">
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
                    <a class="nav-link text-white" href="./tienda/">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="./perfil/">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="./wallet/"><i class="bi bi-wallet2 mx-1"></i><span id="wallet"></span>€</a>
                </li>
                <!-- Mostrar al rol admin -->
                <?php if ($_SESSION['rol'] == "admin"): ?>
                    <li class="nav-item d-lg-none">
                    <a class="nav-link text-white" href="./admin/">Cerrar Sesión</a>
                </li>
                <?php endif; ?>
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-white" href="./cerrarSesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-flex">
            <!-- Mostrar al rol admin -->
        <?php if ($_SESSION['rol'] == "admin"): ?>
            <a href="./admin/">
                <button class="btn btnNav btn-sm me-2">Admin</button>
            </a>
                <?php endif; ?>
            <a href="./cerrarSesion.php">
                <button class="btn btnNav btn-sm">Cerrar Sesión</button>
            </a>
        </div>
    </div>
</nav>


<?php endif; ?>


<div class="container-fluid m-0 p-0">
    <div class="row g-0 p-5 d-flex align-items-center justify-content-center text-center ppalIndex">
        <div class="col-12 col-md-5 p-2 d-flex flex-column align-items-center align-items-md-start text-md-start text-white">
            <h1>AMPLIA TU MUNDO DE POKEMON TCG</h1>
            <h3>Abre sobres y llévate las mejores cartas</h3>
            <a href="./tienda/"><button class="btn btnNav btn-sm mt-3">Abrir Sobres</button></a>
            
        </div>
    
        <div class="col-12 col-md-5 d-none d-md-flex justify-content-center">
            <img src="img/evolucionesPrismaticas.png" alt="Evoluciones Prismáticas" class="img-fluid" style="max-width:300px;">
        </div>
    </div>
</div>

<div class="carrusel-container">
    <div class="carrusel">
        <a href="./tienda/probabilidades-cartas.php?texto=evoluciones-prismaticas"><img src="img/evolucionesPrismaticas.png" alt="evolucionesPrismaticas"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=chispas-fulgrulantes"><img src="img/chispasFulgrulantes.png" alt="chispasFulgrulantes"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=corona-astral"><img src="img/coronaAstral.png" alt="coronaAstral"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=fabula-sombria"><img src="img/fabulaSombria.png" alt="fabulaSombria"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=mascarada-crepuscular"><img src="img/mascaradaCrepuscular.png" alt="mascaradaCrepuscular"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=fuerzas-temporales"><img src="img/fuerzasTemporales.png" alt="fuerzasTemporales"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=destinos-paldea"><img src="img/destinosPaldea.png" alt="destinosPaldea"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=brecha-paradojica"><img src="img/brechaParadojica.png" alt="brechaParadojica"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=151"><img src="img/151.png" alt="151"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=llamas-obsidianas"><img src="img/llamasObsidianas.png" alt="llamasObsidianas"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=evoluciones-paldea"><img src="img/evolucionesPaldea.png" alt="evolucionesPaldea"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=escarlata-purpura"><img src="img/escarlataPurpura.png" alt="escarlataPurpura"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=evoluciones-prismaticas"><img src="img/evolucionesPrismaticas.png" alt="evolucionesPrismaticas"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=chispas-fulgrulantes"><img src="img/chispasFulgrulantes.png" alt="chispasFulgrulantes"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=corona-astral"><img src="img/coronaAstral.png" alt="coronaAstral"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=fabula-sombria"><img src="img/fabulaSombria.png" alt="fabulaSombria"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=mascarada-crepuscular"><img src="img/mascaradaCrepuscular.png" alt="mascaradaCrepuscular"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=fuerzas-temporales"><img src="img/fuerzasTemporales.png" alt="fuerzasTemporales"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=destinos-paldea"><img src="img/destinosPaldea.png" alt="destinosPaldea"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=brecha-paradojica"><img src="img/brechaParadojica.png" alt="brechaParadojica"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=151"><img src="img/151.png" alt="151"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=llamas-obsidianas"><img src="img/llamasObsidianas.png" alt="llamasObsidianas"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=evoluciones-paldea"><img src="img/evolucionesPaldea.png" alt="evolucionesPaldea"></a>
        <a href="./tienda/probabilidades-cartas.php?texto=escarlata-purpura"><img src="img/escarlataPurpura.png" alt="escarlataPurpura"></a>
    </div>
  </div>

  <div class="container-fluid m-0 p-0">
    <div class="row p-5 m-0">
        <div class="col-12 col-md-6 p-3">
            <h2 class="text-center">Formulario de Contacto</h2>
            <form id="contactForm" class="p-4 rounded shadow-lg bg-light">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Introduce tu nombre">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Introduce tu correo electrónico">
                </div>

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí..."></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Enviar</button>
                </div>
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
                            Para abrir un sobre, debes ir a la sección de "Tienda" y hacer clic en el botón del "Carrito" en el sobre que desees. Recuedad que debes tener saldo disponible para adquirir un sobre.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeading2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            ¿Como añado saldo a mi Wallet?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Para añadir saldo debes hacer click en tu wallet y enviar una transferencia a los datos que te indica.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeading3">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            ¿Como contacto con vosotros?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Puedes crear un ticket en el formulario junto a esta sección. Te contestaremos en un plazo de 24/48 horas.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de envío de formulario exitoso -->
<div class="modal fade" id="exitoForm" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Mensaje enviado con éxito
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
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


<script src="procesarLogin.js"></script>
<script src="mostrarSaldo.js"></script>
<script src="procesarForm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
