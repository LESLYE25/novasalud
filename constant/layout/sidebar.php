<?php
require_once('./constant/connect.php');
?>

<div class="left-sidebar bg-light" id="sidebar" style="width: 250px; transition: width 0.3s;">
    <div class="scroll-sidebar">

        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pl-2">
                <li class="nav-devider"></li>

                <li class="nav-label d-flex justify-content-between align-items-center pr-2">
                    <span class="menu-text">Menú</span>
                    <button id="toggleSidebar" class="btn btn-link p-0 m-0" style="font-size: 1.2rem;">
                        <i class="fa fa-bars"></i>
                    </button>
                </li>

                <li>
                    <a href="dashboard.php" class="d-flex align-items-center">
                        <i class="fa fa-eye mr-2"></i> <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1): ?>
                    <li>
                        <a class="has-arrow d-flex align-items-center" href="#">
                            <i class="fa fa-users mr-2"></i> <span class="menu-text">Usuarios</span>
                        </a>
                        <ul class="collapse">
                            <li><a href="add-brand.php">Agregar Usuario</a></li>
                            <li><a href="brand.php">Gestionar Usuario</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow d-flex align-items-center" href="#">
                            <i class="fa fa-list mr-2"></i> <span class="menu-text">Categorías</span>
                        </a>
                        <ul class="collapse">
                            <li><a href="add-category.php">Agregar Categoría</a></li>
                            <li><a href="categories.php">Gestionar Categorías</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow d-flex align-items-center" href="#">
                            <i class="fa fa-medkit mr-2"></i> <span class="menu-text">Medicina</span>
                        </a>
                        <ul class="collapse">
                            <li><a href="add-product.php">Agregar Medicina</a></li>
                            <li><a href="product.php">Gestionar Medicinas</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li>
                    <a class="has-arrow d-flex align-items-center" href="#">
                        <i class="fa fa-file mr-2"></i> <span class="menu-text">Facturas</span>
                    </a>
                    <ul class="collapse">
                        <li><a href="add-order.php">Agregar Factura</a></li>
                        <li><a href="Order.php">Gestionar Facturas</a></li>
                    </ul>
                </li>

                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1): ?>
                    <li>
                        <a class="has-arrow d-flex align-items-center" href="#">
                            <i class="fa fa-flag mr-2"></i> <span class="menu-text">Reportes</span>
                        </a>
                        <ul class="collapse">
                            <li><a href="sales_report.php">Reporte de Ventas</a></li>
                            <li><a href="productreport.php">Reporte Productos</a></li>
                            <li><a href="expreport.php">Reporte Expirados</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>
</div>

<!-- SCRIPT: Toggle sidebar ancho / mostrar texto -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const menuTexts = document.querySelectorAll('.menu-text');
        let collapsed = false;

        toggleBtn.addEventListener('click', () => {
            collapsed = !collapsed;

            // Cambiar ancho del sidebar
            sidebar.style.width = collapsed ? '60px' : '250px';

            // Mostrar/ocultar textos
            menuTexts.forEach(el => {
                el.style.display = collapsed ? 'none' : 'inline';
            });
        });
    });
</script>
