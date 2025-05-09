<?php
include('./constant/check.php');
require_once('./constant/connect.php');
?>

<div id="main-wrapper">

    <div class="header">
        <!-- Marquee solo visible en pantallas pequeñas -->
        <marquee class="d-lg-none d-block bg-light text-dark font-weight-bold py-1">
            <div class="text-center">
                <b id="ti"></b>
            </div>
        </marquee>

        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm px-3">
            <!-- Logo -->
            <div class="navbar-header">
                <a class="navbar-brand">
                    <img src="./assets/uploadImage/Logo/logo.jpg" alt="logo" class="dark-logo" style="max-height: 50px; width: auto;" />
                </a>
            </div>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido colapsable -->
            <div class="collapse navbar-collapse" id="navbarNav">
               

                <!-- Usuario -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown">
                            <img src="./assets/uploadImage/Profile/usuario-admin.png" alt="user" class="profile-pic rounded-circle" style="height: 40px; width: 40px;" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                            <ul class="dropdown-user list-unstyled mb-0">
                                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1): ?>
                                    <!-- Aquí puedes añadir opciones solo para admin -->
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="./constant/logout.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Script para mostrar la hora -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var today = new Date();
            document.getElementById('ti').innerHTML = today.toLocaleString();
        });
    </script>
</div>
