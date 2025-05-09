    <?php //error_reporting(1); 
    ?>
    <?php include('./constant/layout/head.php'); ?>
    <?php include('./constant/layout/header.php'); ?>
    <?php include('./constant/layout/sidebar.php'); ?>
    <?php

    $lowStockSql = "SELECT * FROM product WHERE status = 1";
    $lowStockQuery = $connect->query($lowStockSql);
    $countLowStock = $lowStockQuery->num_rows;

    $lowStockSql1 = "SELECT * FROM brands WHERE brand_status = 1";
    $lowStockQuery1 = $connect->query($lowStockSql1);
    $countLowStock1 = $lowStockQuery1->num_rows;

    $date = date('Y-m-d');
    $lowStockSql3 = "SELECT * FROM product WHERE  expdate<'" . $date . "' AND status = 1";
    //echo "SELECT * FROM product WHERE  expdate<='".$date."' AND status = 1" ;exit;
    $lowStockQuery3 = $connect->query($lowStockSql3);
    $countLowStock3 = $lowStockQuery3->num_rows;

    $lowStockSql2 = "SELECT * FROM orders WHERE delete_status =0";
    $lowStockQuery2 = $connect->query($lowStockSql2);
    $countLowStock2 = $lowStockQuery2->num_rows;
    

    //$connect->close();

    ?>

    <style type="text/css">
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php
    // Consulta para productos con stock bajo
    $sqlLowStock = "SELECT COUNT(*) AS totalLowStock FROM product WHERE stock <= 2";
    $resultLowStock = $connect->query($sqlLowStock);
    $countLowStock4 = $resultLowStock->fetch_assoc()['totalLowStock'];
    ?>

    <div class="page-wrapper">
        <?php if ($countLowStock > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show mt-3 mx-3" role="alert">
            <strong>¡Atención!</strong> Hay <strong><?php echo $countLowStock4; ?></strong> productos con bajo stock.
            <a href="product.php" class="btn btn-sm btn-light ml-2">Ver productos</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        
        <!--<div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <div class="float-right"><h3 style="color:black;"><p style="color:black;"><?php echo date('l') . ' ' . date('d') . '- ' . date('m') . '- ' . date('Y'); ?></p></h3></div>
            </div>
        </div> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 dashboard">

                <div class="card" style="background:rgb(113, 109, 220)">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-support"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2 class="color-white"><?php echo $countLowStock; ?></h2>
                            <a href="product.php">
                                <p class="m-b-0">Medicinas</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
            <div class="col-md-3 col-sm-6 col-xs-12 dashboard">

                <div class="card" style="background-color:rgb(255, 190, 85)">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-agenda"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2 class="color-white"><?php echo $countLowStock4; ?></h2>
                                <a href="product.php">
                                 <p class="m-b-0">Stock Mínimo</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                <div class="col-md-3 col-sm-6 col-xs-12 dashboard">
                    <div class="card" style="background-color:rgb(236, 169, 245)">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="ti-notepad"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white"><?php echo $countLowStock2; ?></h2>
                                <a href="Order.php">
                                    <p class="m-b-0">Facturas</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                <div class="col-md-3 col-sm-6 col-xs-12 dashboard">

                    <div class="card" style="background:#65c8db">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="ti-rss"></i></span>
                             </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white"><?php echo $countLowStock1; ?></h2>
                                <a href="brand.php">
                                    <p class="m-b-0">Usuarios</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
            
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Tabla de Ventas</strong>
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Nombre Cliente</th>
                                        <th>Contacto</th>
                                        <th>Estado del Pago</th>
                                        <th>Total de Compra</th> <!-- Nueva columna de Total -->
                                    </tr>
                                </thead>
                            <tbody>
                                <?php
                                $sql = "
                                SELECT o.uno, o.orderDate, o.clientName, o.clientContact, o.paymentStatus, o.id,SUM(oi.total) AS totalCompra FROM orders o
                                LEFT JOIN order_item oi ON o.id = oi.lastid WHERE o.delete_status = 0 GROUP BY o.id";
                                $result = $connect->query($sql); 
                                foreach ($result as $row) {
                                    $no += 1;
                                    ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?php echo $row['orderDate']; ?></td>
                                        <td><?php echo $row['clientName']; ?></td>
                                        <td><?php echo $row['clientContact']; ?></td>
                                        <td>
                                            <?php 
                                            if ($row['paymentStatus'] == 1) {
                                                echo "<label class='label label-info'><h4>Pago Completo</h4></label>";
                                            } else if ($row['paymentStatus'] == 2) {
                                                echo "<label class='label label-warning'><h4>Pago Parcial</h4></label>";
                                            } else {
                                                echo "<label class='label label-danger'><h4>Pago Pendiente</h4></label>";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo "$" . number_format($row['totalCompra'], 2); ?> </td> <!-- Mostrar Total de Compra -->
                                    </tr>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--graficos-->
        <?php
        // Obtener el total de ventas por estado de pago
        $totalVentasSql = "
        SELECT paymentStatus, SUM(oi.total) AS totalVentas FROM orders o LEFT JOIN order_item oi ON o.id = oi.lastid WHERE o.delete_status = 0 GROUP BY paymentStatus";
        $resultVentas = $connect->query($totalVentasSql);
        // Crear un array de datos para Google Charts// 
        $chartData = '';
        while ($row = $resultVentas->fetch_assoc()) {
            $status = $row['paymentStatus'];
            $totalVentas = $row['totalVentas'];
            // Añadir datos al array en el formato adecuado para Google Charts
            $statusLabel = ($status == 1) ? 'Pago Completo' : (($status == 2) ? 'Pago Parcial' : 'Pago Pendiente');
            $chartData .= "['$statusLabel', $totalVentas],";
        }

        $chartData = rtrim($chartData, ','); // Eliminar la última coma
        ?>

        <?php
        // Consulta para obtener cantidad de medicinas por categoría
        $categoryChartSql = "
        SELECT c.categories_name AS categoria, COUNT(p.product_id) AS cantidad_de_medicinas FROM categories c LEFT JOIN product p ON c.categories_id = p.categories_id
        WHERE c.categories_status = 1 GROUP BY c.categories_id, c.categories_name";
        $resultCategoryChart = $connect->query($categoryChartSql);
        // Preparar datos para Google Charts
        $categoryChartData = "";
        while ($row = $resultCategoryChart->fetch_assoc()) {
            $categoryChartData .= "['" . $row['categoria'] . "', " . $row['cantidad_de_medicinas'] . "],";
        }
        $categoryChartData = rtrim($categoryChartData, ',');
        ?>  


        <!-- Script para cargar y dibujar el gráfico -->
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Estado de Pago', 'Total de Ventas'],
                    <?php echo $chartData; ?>
                ]);

                var options = {
                    title: 'Distribución de Ventas por Estado de Pago',
                    is3D: true,
                    slices: {
                        0: { offset: 0.1 },
                        1: { offset: 0.1 },
                        2: { offset: 0.1 }
                    },
                    legend: { position: 'top' }
                };

                var chart = new google.visualization.PieChart(document.getElementById('ventasChart'));
                chart.draw(data, options);
            }
        </script>

        <!-- Script para cargar y dibujar el gráfico de medicinas por categoría -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawCharts);

            function drawCharts() {
                // Gráfico de Pastel: Cantidad de Medicinas por Categoría
                var categoriaData = google.visualization.arrayToDataTable([
                    ['Categoría', 'Cantidad de Medicinas'],
                    <?php echo $categoryChartData; ?>  // Inyectamos los datos generados en PHP
                ]);

                var categoriaOptions = {
                    title: 'Cantidad de Medicinas por Categoría',
                    pieHole: 0.4, // Hacerlo tipo "donut"
                    colors: ['#ff9800', '#3f51b5', '#e91e63', '#4caf50', '#00bcd4']  // Opcional: define los colores
                };

                var categoriaChart = new google.visualization.PieChart(document.getElementById('categoriaChart'));
                categoriaChart.draw(categoriaData, categoriaOptions);

                // Gráfico de Barras: Cantidad de Medicinas por Categoría
                var categoriaBarData = google.visualization.arrayToDataTable([
                    ['Categoría', 'Cantidad de Medicinas'],
                    <?php echo $categoryChartData; ?>  // Inyectamos los datos generados en PHP
                ]);

                var categoriaBarOptions = {
                    title: 'Cantidad de Medicinas por Categoría',
                    chartArea: {width: '60%'},
                    hAxis: {
                        title: 'Cantidad de Medicinas',
                        minValue: 0
                    },
                    vAxis: {
                        title: 'Categoría'
                    },
                    colors: ['#4caf50']  // Opcional: define los colores
                };

                var categoriaBarChart = new google.visualization.BarChart(document.getElementById('categoriaBarChart'));
                categoriaBarChart.draw(categoriaBarData, categoriaBarOptions);
            }
        </script> 
        <div class="container-fluid">
            <div class="row">
                <!-- Gráfico de torta en la columna izquierda -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Total de Ventas</strong>
                        </div>
                        <div class="card-body">
                            <div id="ventasChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Segundo gráfico: Medicinas por Categoria (Gráfico de Barras) -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Medicinas por Categoria</strong>    
                        </div>
                        <div class="card-body">
                            <div id="categoriaChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php include('./constant/layout/footer.php'); ?>
    <script>
        $(function() {
            $(".preloader").fadeOut();
        })
    </script>
    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Mhl'], <?php echo $datavalue1; ?>
            ]);

            var options = {
                title: 'World Wide Wine Production',
                is3D: true
            };

            var chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);

            var chart = new google.visualization.BarChart(document.getElementById('myChart1'));
            chart.draw(data, options);
        }
    </script>

    <?php
    //error_reporting(0);
    //require_once('../constant/connect.php');
    $qqq = "SELECT * FROM product WHERE  status ='1' ";
    $result = $connect->query($qqq);
    //print_r($result);exit;
    foreach ($result as $row) {
    //print_r($row);
        $a .= $row["product_name"] . ',';
        $b .= $row["quantity"] . ',';
    }
    $am = explode(",", $a, -1);
    $amm = explode(",", $b, -1);
    //print_r($a);
     //print_r($b);

    $cnt = count($am);
    $datavalue1 = '';
        for ($i = 0; $i < $cnt; $i++) {
            $datavalue1 .= "['" . $am[$i] . "'," . $amm[$i] . "],";
        }
        //echo 
        $datavalue1; //used this $data variable in js
    ?>

        